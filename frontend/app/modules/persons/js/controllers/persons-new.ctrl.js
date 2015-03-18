/**
 * New person controller
 *
 * @type {controller}
 */
angular.module('personsApp').controller('personsNewCtrl', [
  '$scope',
  '$filter',
  '$window',
  '$location',
  'personsFact',
  'organizationsFact',
  'pinesNotifications',
  'translateFilter',
  function ($scope, $filter, $window, $location, personsFact, organizationsFact, pinesNotifications, translateFilter)
    {
        $scope.person = new personsFact();

        var error = function (response, args)
        {
            //Notify of the new role label post action error
            pinesNotifications.notify({
                title: translateFilter('global.validations.error'),
                text : translateFilter('persons.validations.not_created'),
                type : 'error'
            });
        };

        var success = function (response, args)
        {
            //close modal if view is a modal instance (resolve promise with the new person)
            if ($scope.$close)
            {
                $scope.$close(response);
            }
            else
            {
                //Go back to previous page otherwise
                $window.history.back();
            }
        };

      //Close the modal if the view is a modal instance
        $scope.cancel = function ()
        {
            $scope.$dismiss('cancel');
        };

        //Send post request with new person info
        $scope.create = function (form)
        {
            if (form.$valid)
            {
//                $scope.person.$create({}, success, error);
                personsFact.create(personsFact.serialize($scope.person), success, error);
            }
        };

        //Populate array of a specific linked entity
        $scope.addRelationship = function (key, model)
        {
            //Check if array available for the linked entity
            if (!$scope.person[key])
            {
                $scope.person[key] = [];
            }

            //Stop if the object selected is already in array (avoid duplicates)
            if (!$filter('inArray')('id', model.id, $scope.person[key]))
            {
                //If no duplicate add the selected object to the specified array
                $scope.person[key].push(model);
            }
        };

        $scope.removeRelationship = function (key, index)
        {
            $scope.person[key].splice(index, 1);
//        personsFact.update($scope.person);
            $scope.updatePerson(key, $scope.person[key]);
        };
    }]);
