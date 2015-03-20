/**
 * List (all) persons controller
 *
 * @type {controller}
 */
angular.module('personsApp').controller('personsListCtrl', [
  '$scope',
  'personsFact',
  function ($scope, personsFact)
  {
    //Prepare entities object for list entity handler directive
    $scope.entities = [];

    //Fetch all persons
    $scope.request = personsFact.all;

  }]);
