/**
 * List (all) persons controller
 *
 * @type {controller}
 */
angular.module('personsApp').controller('personsListCtrl', [
  '$scope',
  'persons',
  'personsFact',
  function ($scope, persons, personsFact)
  {
    //Prepare enttties object for list entity handler directive
    $scope.entities = persons.results;

    //Fetch all persons
    $scope.request = personsFact.all;

  }]);
