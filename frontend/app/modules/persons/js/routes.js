/**
 * Persons module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('personsApp').config([
  '$routeProvider',
  function ($routeProvider)
  {
    $routeProvider
      .when('/persons', {
        templateUrl: 'modules/persons/partials/pages/persons-index.html',
        controller: 'personsListCtrl',
        resolve: {
          persons: function (personsFact)
          {
            return personsFact.all({
              limit: globalConfig.page_size,
              order: globalConfig.organizations.order
            }).$promise;
          }
        }
      })
      .when('/persons/new', {
        templateUrl: 'modules/persons/partials/pages/persons-new.html',
        controller: 'personsNewCtrl'
      })
      .when('/persons/show/:personId', {
        templateUrl: 'modules/persons/partials/pages/persons-show.html',
        controller: 'personsShowCtrl',
        resolve: {
          person: function (personsFact, $route)
          {
            return personsFact.get({id: $route.current.params.personId}).$promise;
          }
        }
      })
      .when('/persons/edit/:personId', {
        templateUrl: 'modules/persons/partials/pages/persons-edit.html',
        controller: 'personsEditCtrl',
        resolve: {
          person: function (personsFact, $route)
          {
            return personsFact.get({id: $route.current.params.personId}).$promise;
          }
        }
      })
      .otherwise({
        redirectTo: '/persons'
      });
  }
]);
