/**
 * Authentication Factory
 * Manage the current user stored in local storage
 * @type {factory}
 */
angular.module('authenticationApp').factory('authenticationFact', [
  '$rootScope',
  'usersFact',
  function ($rootScope, usersFact)
  {
    var loggedUser = localStorage.getItem('loggedUser'),
      auth = localStorage.getItem('oauth')
      ;

    function sendLoginForm(form, success, error)
    {
      //TODO serialize login method in resource
      return usersFact.signin({}, form, success, error).promise;
    }

    function refreshAccessToken(refreshToken)
    {
      //TODO
      return usersFact.signin().promise;
    }

    function grantAccess()
    {
      //TODO
      return usersFact.grantAccess().promise;
    }

    return {
      /**
       * should be called when server has denied an access
       * @returns {*}
       */
      startOAuthLoginWorkflow: function ()
      {
        //get access token if a refresh token is available
        if (auth.refresh_token)
        {
          return refreshAccessToken(auth.refresh_token)
        }
        //if not, user has never logged in before => show him the login popup
        $rootScope.showSigninPopup();
      },
      handleLoginForm: function (form, success, error)
      {
        //TODO serialize login method in resource
        return sendLoginForm(form, success, error)
          .then(grantAccess);
      },

      getUser: function ()
      {
        return loggedUser;
      },
      saveLoggedUser: function (user)
      {
        localStorage.setItem('loggedUser', JSON.stringify(user));
        return loggedUser = user;
      },
      removeLoggedUser: function (user)
      {
        localStorage.removeItem('loggedUser');
        loggedUser = undefined;
      }

    };
  }]);

