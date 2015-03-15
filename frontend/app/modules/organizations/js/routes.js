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
                .when('/home/organizations/index', {
                    templateUrl: 'modules/organizations/partials/pages/organizations-index.html',
                    controller : 'organizationsCommunityIndexCtrl'
                })
                .when('/organizations/thumbnail', {
                    templateUrl: 'modules/organizations/partials/organizations-thumbnail.html',
                    controller : 'organizationsListCtrl'
                })
                .when('/organizations/new', {
                    templateUrl: 'modules/organizations/partials/pages/organizations-new.html',
                    controller : 'organizationsNewCtrl'
                })
                .when('/home/organizations/edit/:organizationId', {
                    templateUrl: 'modules/organizations/partials/pages/organizations-edit.html',
                    controller : 'organizationsEditCtrl'
                })
                .when('/home/organizations/show/:organizationId', {
                    templateUrl: 'modules/organizations/partials/pages/organizations-show.html',
                    controller : 'organizationsShowCtrl'
                })
                .otherwise({
                    redirectTo: '/organizations/list'
                });
        }
    ]);
