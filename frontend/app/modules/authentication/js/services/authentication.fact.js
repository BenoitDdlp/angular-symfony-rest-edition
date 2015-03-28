/**
 * Authentication Factory
 * Manage the current user stored in local storage
 * @type {factory}
 */
angular.module('authenticationApp').factory('authenticationService', [
  '$rootScope',
  'authService',
  'usersFact',
  'personsFact',
  '$modal',
  'translateFilter',
  'pinesNotifications',
  function ($rootScope, authService, usersFact, personsFact, $modal, translateFilter, pinesNotifications)
  {
    var modal;
    var config =
        {
          //redirectUri: 'http://192.168.0.13/asre/frontend/app/',
          client_id: '6_1qw5cxiattogs8ckgk8cw00cwo0kk0wsckc0c0kcssg0o8csok',
          client_secret: '1v1rd14maydc8sc88wco400k4s4k0kgwwk484gsk8w4ggwcgsg'
        };

    //a way to trigger the authentication workflow
    $rootScope.$on('event:auth-loginRequired', startLoginWorkflow);
    //a way to trigger the authentication workflow
    $rootScope.$on('event:auth-signout', signOut);

    //when action is forbidden (http 403)
    $rootScope.$on('event:auth-forbidden', function (event, data)
    {
      console.log(data); // 'Data to send'
    });

    return {
      //another way to trigger the authentication workflow
      startLoginWorkflow: startLoginWorkflow,
      signInWithCredential: signInWithCredential
    };

    //called when the user want to check its account credentials
    function signInWithCredential(user)
    {
      var param = angular.extend({}, config, user, {
        "grant_type": 'password'
      });
      return new usersFact().$token(param).then(saveToken, function ()
      {
        notifyError("authentication.validations.signin_error")
      });
    }

    //start login workflow
    function startLoginWorkflow()
    {
      //try to refresh token
      if ($rootScope.token && $rootScope.token.refresh_token)
      {
        var param = angular.extend({}, config, {
          "grant_type": 'refresh_token',
          "refresh_token": $rootScope.token.refresh_token
        });
        return new usersFact().$token(param)
          .then(saveToken, signInModal);
      }
      //if no refresh token available : show sign in modal
      signInModal();
      function signInModal()
      {
        return modal = $modal.open({
          templateUrl: 'modules/authentication/partials/signin.html',
          controller: 'signinCtrl',
          size: "large"
        });
      }
    }

    //when authentication was successful : the response is an oauth token
    function saveToken(newToken)
    {
      localStorage.setItem('oauth', JSON.stringify(newToken));
      $rootScope.token = newToken;
      if (!$rootScope.loggedUser)
      {
        new personsFact().$profile().then(saveLoggedUser, notifyError());
      }
      //relaunch all denied requests
      authService.loginConfirmed();
      modal.close();
    }

    //when profile was successfully fetched
    function saveLoggedUser(user)
    {
      localStorage.setItem('loggedUser', JSON.stringify(user));
      $rootScope.loggedUser = user;
    }

    function signOut()
    {
      new usersFact().$revoke({token: $rootScope.token.refresh_token})
        .then(function (user)
        {
          return user.$revoke({token: $rootScope.token.access_token}).$promise;
        }, notifyError)
        .then(function ()
        {
          localStorage.removeItem('oauth');
          $rootScope.token = undefined;
          localStorage.removeItem('loggedUser');
          $rootScope.loggedUser = undefined;

          //Notify of the signout action success
          pinesNotifications.notify({
            title: translateFilter('global.validations.success'),
            text: translateFilter('authentication.validations.signout_success'),
            type: 'success'
          });
        }, notifyError
      )
      ;
    }

    function notifyError(code)
    {
      //Notify of the signout action error
      pinesNotifications.notify({
        title: translateFilter('global.validations.error'),
        text: translateFilter(typeof code == "string" ? code : 'global.error'),
        type: 'error'
      });
    }
  }]);
