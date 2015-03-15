/**
 * List persons by event controller
 *
 * @type {controller}
 */
angular.module('personsApp').controller('personsListByEventCtrl', [
  '$scope',
  'createDialog',
  '$rootScope',
  'personsFact',
  '$cachedResource',
  '$routeParams',
  function ($scope, createDialogService, $rootScope, personsFact, $cachedResource, $routeParams)
{
    $scope.GLOBAL_CONFIG = $scope.$root.GLOBAL_CONFIG;
    $scope.person = personsFact.get({idEvent: $routeParams.eventId});
}]);
