/**
 * Sign out controller
 *
 * @type {controller}
 */
angular.module('authenticationApp').controller('signoutCtrl', [
  '$scope',
  function ($scope)
  {
    //Send signout request
    $scope.signoutAction = function ()
    {
      $scope.$root.$broadcast('event:auth-signout');
    }
  }]);
