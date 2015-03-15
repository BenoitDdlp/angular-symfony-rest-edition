/**
 * List (all) persons controller
 *
 * @type {controller}
 */
angular.module('personsApp').controller('personsListCtrl', [
  '$scope',
  '$routeParams',
  'personsFact',
  function ($scope, $routeParams, personsFact, $modal)
  {

    $scope.GLOBAL_CONFIG = $scope.$root.GLOBAL_CONFIG;

    $scope.entities = [];

    $scope.request = personsFact.all;


    $scope.clone = function (person)
    {
      var clonePerson = angular.copy(person);
      clonePerson.id = null;

      var error = function (response, args)
      {
        $scope.$root.$broadcast('AlertCtrl:addAlert', {code: 'Clone not completed', type: 'danger'});
      };

      var success = function (response, args)
      {
        $scope.$root.$broadcast('AlertCtrl:addAlert', {code: 'Person saved', type: 'success'});
        $scope.entities.push(response);
      };

      clonePerson.$create({}, success, error);
    };

    $scope.deleteModal = function (index, person)
    {
      $scope.index = index;

      var modalInstance = $modal.open({
        templateUrl: 'modules/persons/partials/persons-delete.html',
        controller: 'personsDeleteCtrl',
        size: "large",
        resolve: {
          personModel: function ()
          {
            return person;
          }
        }
      });

      modalInstance.resolve = function (data)
      {
        $scope.entities.splice(index, 1);
      };

    }
  }]);
