/**
 * List (all) organizations controller
 *
 * @type {controller}
 */
angular.module('organizationsApp').controller('organizationsListCtrl', [
  '$scope',
  'organizations',
  'organizationsFact',
  function ($scope, organizations, organizationsFact)
  {
    //Prepare entities object for list entity handler directive
    $scope.entities = organizations.results;

    //Fetch all organizations
    $scope.request = organizationsFact.all;

  }]);
