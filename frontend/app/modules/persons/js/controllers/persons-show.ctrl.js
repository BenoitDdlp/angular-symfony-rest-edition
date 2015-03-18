/**
 * Show person controller
 *
 * @type {controller}
 */
angular.module('personsApp').controller('personsShowCtrl', [
  '$scope',
  'person',
  function ($scope, person)
{
  $scope.person = person;
}]);
