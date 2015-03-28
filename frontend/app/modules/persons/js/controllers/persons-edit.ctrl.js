/**
 * Edit person controller
 * The profile of a person is managed via a live edit form. Each change is persisted uniquely using patch request
 * @type {controller}
 */
angular.module('personsApp').controller('personsEditCtrl', [
  '$scope',
  'person',
  '$q',
  '$filter',
  '$modal',
  '$location',
  'personsFact',
  'organizationsFact',
  'pinesNotifications',
  'translateFilter',
  'positionsFact',
  function ($scope, person, $q, $filter, $modal, $location, personsFact, organizationsFact, pinesNotifications, translateFilter, positionsFact)
  {
    $scope.person = person;


    //Error on request
    var error = function (response, args)
    {
      //Notify of error on patch request
      pinesNotifications.notify({
        title: translateFilter('global.validations.error'),
        text: translateFilter('response.data.error.message'),
        type: 'error'
      });
    };

    //Success on patch request
    var success = function (response, args)
    {
      alert("user logged in");
    };

    //Send patch request on the field to be persisted
    $scope.updatePerson = function (field, data)
    {
      var updatePersonParam = {id: $scope.person.id};
      updatePersonParam[field] = data;
      return personsFact.patch(updatePersonParam, success, error);
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
      if (!$filter('inArray')('label', model.label, $scope.person[key]))
      {
        //If no duplicate add the selected object to the specified array
        $scope.person[key].push(model);
        $scope.updatePerson(key, $scope.person[key]);
      }
    };

    /**
     * Remove a linked entity form the person
     * @param key, the array containing the linked entities (papers, organizations, events..)
     * @param index, index of the entity to remove on the key array
     */
    $scope.removeRelationship = function (key, index)
    {
      //Delete the specified index in the "key" array
      $scope.person[key].splice(index, 1);
      //Persist changes
      $scope.updatePerson(key, $scope.person[key]);
    };

    //Promise needed by the typeahead directive, resolved when something is selected
    $scope.getOrganizations = function (val)
    {
      //Fetch organization filter by the query and resolve the promise when results comes back
      var deferred = $q.defer();
      organizationsFact.all({query: val}, function (organizations)
      {
        deferred.resolve(organizations.results);
      });
      return deferred.promise;
    };

    //Persist a new position for the person
    $scope.addPosition = function (position)
    {
      //Verify that both fields are setted
      if (position.position && position.organization)
      {
        position.person = $scope.person;
        positionsFact.create(positionsFact.serialize(position), function (position)
        {
        }, error);
        $scope.person.positions.push(position);


      }
    };

    //Remove a specific position
    $scope.deletePosition = function (position, $index)
    {
      positionsFact.delete(positionsFact.serialize(position), success, error);
      $scope.person.positions.splice($index, 1);
    };


    $scope.setLocalization = function (formattedLocalization)
    {
      //Set new localization
      //$scope.person.localization = formattedLocalization;
      //Persist changes
      formattedLocalization.id = $scope.person.localization.id || "";
      return personsFact.patch({id: $scope.person.id, localization: formattedLocalization}, success, error);
      //$scope.updatePerson("localization", formattedLocalization);
    };


    //Select img modal workflow
    $scope.showImgModal = function ()
    {
      // Open modal with main event logo form
      var modalInstance = $modal.open({
        templateUrl: 'modules/persons/partials/modals/persons-select-logo-modal.html',
        //The edit controller is responsible for it
        controller: 'personsEditCtrl',
        size: "large",
        resolve: {
          //Passing current person as a parameter
          person: function ()
          {
            return $scope.person;
          }
        }
      });

      //On success modal $close function call, resolve the promise
      modalInstance.result.then(function (imgUrl)
      {
        $scope.person.img = imgUrl;
        $scope.updatePerson('img', imgUrl);
      })
    };
  }]);
