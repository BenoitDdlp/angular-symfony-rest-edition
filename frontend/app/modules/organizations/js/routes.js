/**
 * Organizations module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('organizationsApp')
  .config([
    '$routeProvider',
    function ($routeProvider)
    {
      $routeProvider
        .when('/organizations', {
          templateUrl: 'modules/organizations/partials/pages/organizations-index.html',
          controller: 'organizationsListCtrl',
          resolve: {
            organizations: function (organizationsFact)
            {
              return organizationsFact.all({
                limit: globalConfig.page_size,
                order: globalConfig.organizations.order
              }).$promise;
            }
          }
        })
        .when('/organizations/new', {
          templateUrl: 'modules/organizations/partials/pages/organizations-new.html',
          controller: 'organizationsNewCtrl'
        })
        .when('/organizations/show/:organizationId', {
          templateUrl: 'modules/organizations/partials/pages/organizations-show.html',
          controller: 'organizationsShowCtrl',
          resolve: {
            organization: function (organizationsFact, $route)
            {
              return organizationsFact.get({id: $route.current.params.organizationId}).$promise;
            }
          }
        })
        .when('/organizations/edit/:organizationId', {
          templateUrl: 'modules/organizations/partials/pages/organizations-edit.html',
          controller: 'organizationsEditCtrl',
          resolve: {
            organization: function (organizationsFact, $route)
            {
              return organizationsFact.get({id: $route.current.params.organizationId}).$promise;
            }
          }
        })
        .otherwise({
          redirectTo: '/organizations/list'
        });
    }
  ]);
