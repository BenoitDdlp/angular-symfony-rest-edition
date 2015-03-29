/**
 * Sign in controller
 * Handles the signin process of a user
 * @type {controller}
 */

angular.module('authenticationApp').controller('signinCtrl', [
  '$scope',
  'authenticationService',
  function ($scope, authenticationService)
  {
    $scope.startLoginWorkflow = authenticationService.startLoginWorkflow;
    $scope.signinAction = signinAction;
    $scope.windowPop = windowPop;

    //submit signin form
    function signinAction(user)
    {
      return authenticationService.signInWithCredential({
        "username": user._username,
        "password": user._password
      });
    }

    //open social login popup
    function windowPop(url)
    {
      authenticationService.getTokenByPopup(url)
        .then(function (result)
        {
          console.log(result);
        }, function (result)
        {
          console.log(result);
          alert("fail");
        }
      )
    }
  }]);
