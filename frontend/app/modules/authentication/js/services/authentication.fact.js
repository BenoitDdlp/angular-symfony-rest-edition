/**
 * Authentication Factory
 * Manage the current user stored in local storage
 * @type {factory}
 */
//angular.module('authenticationApp').
//
//  config(function (TokenProvider)
//  {
//    TokenProvider.extendConfig({
//      redirectUri: 'http://192.168.0.13/asre/frontend/app/',  // allow lunching demo from a mirror
//      authorizationEndpoint: 'http://localhost/asre/backend/web/app_dev.php/account/oauth/v2/auth',
//      scopes: [""],
//      verifyFunc: "AsreTokenVerifier",
//      clientId: '6_1qw5cxiattogs8ckgk8cw00cwo0kk0wsckc0c0kcssg0o8csok',
//      clientsecret: '1v1rd14maydc8sc88wco400k4s4k0kgwwk484gsk8w4ggwcgsg'
//    });
//  }).
//
//  factory('authenticationFact', [
//  '$rootScope',
//    'Token',
//    function ($rootScope, Token)
//  {
//    var loggedUser = JSON.parse(localStorage.getItem('loggedUser')),
//      token = JSON.parse(localStorage.getItem('oauth'))
//      ;
//
//    //function success(user, notif)
//    //{
//    //  $scope.user = user;
//    //
//    //  //Modify current user
//    //  authenticationFact.addUser(user);
//    //
//    //  //Notify of the signin action success
//    //  if (notif)
//    //  {
//    //    pinesNotifications.notify({
//    //      title: translateFilter('global.validations.success'),
//    //      text: translateFilter('authentication.validations.signin_success'),
//    //      type: 'success'
//    //    });
//    //  }
//    //
//    //  //Close modal
//    //  if ($scope.$close)
//    //  {
//    //    $scope.$close();
//    //  }
//    //}
//    //
//    //function saveLoggedUser(user)
//    //{
//    //  localStorage.setItem('loggedUser', JSON.stringify(user));
//    //  loggedUser = user;
//    //}
//    //
//    //function removeLoggedUser()
//    //{
//    //  localStorage.removeItem('loggedUser');
//    //  loggedUser = undefined;
//    //}
//    //
//    //function saveToken(newToken)
//    //{
//    //  localStorage.setItem('oauth', JSON.stringify(newToken));
//    //  token = newToken;
//    //}
//    //
//    //function removeToken()
//    //{
//    //  localStorage.removeItem('oauth');
//    //  token = undefined;
//    //}
//
//    /**
//     * should be called when server has denied an access
//     * @returns {*}
//     */
//    $rootScope.startOAuthLoginWorkflow = function ()
//    {
//      //get access token if a refresh token is available
//      if (token && token.refresh_token)
//      {
//        return refreshAccessToken(token.refresh_token)
//      }
//      //if not, user has never logged in before => show him the login popup
//      $rootScope.startLoginWorkflow(function (params)
//      {
//        // Success getting token from popup.
//        saveToken(params)
//
//      }, function ()
//      {
//        // Failure getting token from popup.
//        alert("Failed to get token from popup.");
//      });
//      //if not, user has never logged in before => show him the login popup
//      //$rootScope.startLoginWorkflow();
//      //var extraParams = {};
//      /*Token.getTokenByPopup(extraParams).then(function (params)
//      {
//        // Success getting token from popup.
//        saveToken(params)
//
//      }, function ()
//      {
//        // Failure getting token from popup.
//        alert("Failed to get token from popup.");
//      });*/
//    };
//
//    return {
//      handleLoginForm: function (form)
//      {
//        //TODO serialize login method in resource
//        return sendLoginForm(form)
//          .then(grantAccess);
//      },
//
//      getToken: function ()
//      {
//        return token;
//      },
//
//      getUser: function ()
//      {
//        return loggedUser;
//      }
//
//    };
//  }]);
