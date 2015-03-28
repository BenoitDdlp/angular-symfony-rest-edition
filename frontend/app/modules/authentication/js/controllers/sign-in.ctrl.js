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
    //submit signin form
    $scope.signinAction = signinAction;

    //submit signin form
    function signinAction(user)
    {
      return authenticationService.signInWithCredential({
        "username": user._username,
        "password": user._password
      });
    }
  }]);
