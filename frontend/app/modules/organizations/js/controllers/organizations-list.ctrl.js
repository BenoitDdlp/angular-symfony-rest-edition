/**
 * List organization controller
 *
 * @type {controller}
 */
angular.module('organizationsApp').controller('organizationsListCtrl', [
  '$scope',
  '$routeParams',
  'createDialog',
  'organizationsFact',
  function ($scope, $routeParams, createDialogService, organizationsFact)
{
    $scope.GLOBAL_CONFIG = $scope.$root.GLOBAL_CONFIG;
    $scope.entities = [];

    $scope.request = organizationsFact.all;

    $scope.reload = function ()
    {
        $scope.entities.$promise.then(function ()
        {
            console.log('From cache:', $scope.entities);
        });
    };

    $scope.clone = function (organization, index)
    {
        var cloneOrganization = angular.copy(organization);
        delete cloneOrganization.id;

        var error = function (response, args)
        {
            $scope.$root.$broadcast('AlertCtrl:addAlert', {code: 'Clone not completed', type: 'danger'});
        };

        var success = function (response, args)
        {
            $scope.$root.$broadcast('AlertCtrl:addAlert', {code: 'Organization saved', type: 'success'});
            $scope.entities.splice(index + 1, 0, response);
        };

        cloneOrganization.$create({}, success, error);
    };


    $scope.deleteModal = function (index, organization)
    {
        $scope.index = index;

        createDialogService('modules/organizations/partials/organizations-delete.html', {
            id: 'complexDialog',
            title: 'Organization deletion',
            backdrop: true,
            controller: 'organizationsDeleteCtrl',
            success: {label: 'Ok', fn: function ()
            {
                organizationsFact.delete({id: organization.id});
                $scope.entities.splice(index, 1);
            }}
        }, {
            organizationModel: organization
        });
    };

}]);
