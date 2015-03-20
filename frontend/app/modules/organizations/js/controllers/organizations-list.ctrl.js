/**
 * List (all) organizations controller
 *
 * @type {controller}
 */
angular.module('organizationsApp').controller('organizationsListCtrl', [
  '$scope',
  'organizationsFact',
  function ($scope, organizationsFact)
  {
    //Prepare entities object for list entity handler directive
    $scope.entities = [];

    //Fetch all organizations
    $scope.request = organizationsFact.all;

  }]);
