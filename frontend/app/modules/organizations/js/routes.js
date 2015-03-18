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
                    controller : 'organizationsCommunityIndexCtrl'
                })
                .when('/organizations/new', {
                    templateUrl: 'modules/organizations/partials/pages/organizations-new.html',
                    controller : 'organizationsNewCtrl'
                })
              .when('/organizations/edit/:organizationId', {
                    templateUrl: 'modules/organizations/partials/pages/organizations-edit.html',
                    controller : 'organizationsEditCtrl'
                })
              .when('/organizations/show/:organizationId', {
                    templateUrl: 'modules/organizations/partials/pages/organizations-show.html',
                    controller : 'organizationsShowCtrl'
                })
                .otherwise({
                    redirectTo: '/organizations/list'
                });
        }
    ]);
