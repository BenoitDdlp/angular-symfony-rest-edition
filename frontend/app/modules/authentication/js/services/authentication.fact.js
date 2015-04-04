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
  '$q',
  '$window',
  function ($rootScope, authService, usersFact, personsFact, $modal, translateFilter, pinesNotifications, $q, $window)
  {
    var modal,
        config =
        {
          //redirectUri: 'http://192.168.0.13/asre/frontend/app/',
          client_id: globalConfig.api.oauth_id,
          client_secret: globalConfig.api.oauth_secret
        },
        redirect_uri = globalConfig.api.oauth_redirect_uri
      ;

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
      signInWithCredential: signInWithCredential,
      getTokenByPopup: getTokenByPopup

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

    function getTokenByPopup(url)
    {
      return getAuthCodeByPopup(url)
        .then(function (data)
        {
          var param = angular.extend({}, config, {
            "grant_type": 'authorization_code',
            "code": data.code,
            "redirect_uri": redirect_uri
          });
          return new usersFact().$token(param)
            .then(saveToken, notifyError);
        }, notifyError)
    }

    //open social login popup
    function getAuthCodeByPopup(url)
    {
      var popupOptions = {
        name: 'AuthPopup',
        openParams: {
          width: 650,
          height: 300,
          resizable: true,
          scrollbars: true,
          status: true
        }
      };

      var deferred = $q.defer();

      var formatPopupOptions = function (options)
      {
        var pairs = [];
        angular.forEach(options, function (value, key)
        {
          if (value || value === 0)
          {
            value = value === true ? 'yes' : value;
            pairs.push(key + '=' + value);
          }
        });
        return pairs.join(',');
      };

      var popup = window.open(url, popupOptions.name, formatPopupOptions(popupOptions.openParams));

      angular.element($window).bind('message', function (event)
      {
        // Use JQuery originalEvent if present
        event = event.originalEvent || event;
        if (event.source == popup && event.origin == window.location.origin)
        {
          $rootScope.$apply(function ()
          {
            if (event.data.access_token)
            {
              deferred.resolve(event.data)
            }
            else if (event.data.code)
            {
              deferred.resolve(event.data)
            }
            {
              deferred.reject(event.data)
            }
          })
        }
      });

      // TODO: reject deferred if the popup was closed without a message being delivered + maybe offer a timeout

      return deferred.promise;
    }

    //when authentication was successful : the response is an oauth token
    function saveToken(newToken)
    {
      localStorage.setItem('oauth', JSON.stringify(newToken));
      $rootScope.token = newToken;
      if (!$rootScope.loggedUser)
      {
        new personsFact().$profile().then(saveLoggedUser, notifyError);
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
        }, notifyError);
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
  }])
;
