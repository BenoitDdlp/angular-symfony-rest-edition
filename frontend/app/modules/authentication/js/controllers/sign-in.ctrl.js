/**
 * Sign in controller
 * Handles the signin process of a user
 * @type {controller}
 */

angular.module('authenticationApp').controller('signinCtrl', [
  '$scope',
  '$routeParams',
  '$location',
  '$modal',
  '$timeout',
  'pinesNotifications',
  'translateFilter',
  'usersFact',
  'personsFact',
  'authService',
  function ($scope, $routeParams, $location, $modal, $timeout, pinesNotifications, translateFilter, usersFact, personsFact, authService)
  {
    var loggedUser = $scope.$root.currentUser,
      token = $scope.$root.token;

    //two way to trigger the authentication workflow
    $scope.startLoginWorkflow = startLoginWorkflow;
    $scope.$on('event:auth-loginRequired', function (event, data)
    {
      startLoginWorkflow();
    });

    $scope.$on('event:auth-forbidden', function (event, data)
    {
      console.log(data); // 'Data to send'
    });

    //submit signin form
    $scope.signinAction = signinAction;

    //start login workflow
    function startLoginWorkflow()
    {
      //get access token if a refresh token is available
      if (token && token.refresh_token)
      {
        var param = angular.extend({}, config, {
          "grant_type": 'refresh_token',
          "refresh_token": token.refresh_token
        });
        return new usersFact().$token(param)
          .then(saveToken, signInModal);
      }
      //Open signin modal
      function signInModal()
      {
        return $modal.open({
          templateUrl: 'modules/authentication/partials/signin.html',
          controller: 'signinCtrl',
          size: "large"
        });
      }
    }

    //submit signin form
    function signinAction(user)
    {
      var param = angular.extend({}, config, {
        "username": user._username,
        "password": user._password,
        "grant_type": 'password'
      });
      return usersFact.$token(param).then(saveToken);
    }

    //when authentication was successful
    function saveToken(newToken)
    {
      localStorage.setItem('oauth', JSON.stringify(newToken));
      $scope.$root.token = token = newToken;
      authService.loginConfirmed();
      if (!loggedUser)
      {
        new personsFact().$profile();
      }
    }

    //when authentication was successful
    function saveToken(newToken)
    {
      localStorage.setItem('oauth', JSON.stringify(newToken));
      $scope.$root.token = token = newToken;
      authService.loginConfirmed();
      if (!loggedUser)
      {
        new personsFact().$profile().then(saveLoggedUser);
      }
    }

    function removeToken()
    {
      localStorage.removeItem('oauth');
      token = undefined;
    }

    //when authentication was successful
    function saveLoggedUser(user)
    {
      localStorage.setItem('loggedUser', JSON.stringify(user));
      $scope.$root.loggedUser = token = user;
      authService.loginConfirmed();
    }

    function removeLoggedUser()
    {
      localStorage.removeItem('loggedUser');
      loggedUser = undefined;
    }

    var config =
    {
      //redirectUri: 'http://192.168.0.13/asre/frontend/app/',
      client_id: '6_1qw5cxiattogs8ckgk8cw00cwo0kk0wsckc0c0kcssg0o8csok',
      client_secret: '1v1rd14maydc8sc88wco400k4s4k0kgwwk484gsk8w4ggwcgsg',
      grant_type: 'password'
    }
  }]);
