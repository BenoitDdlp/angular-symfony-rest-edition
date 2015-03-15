/**
 * Persons module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('personsApp').config([ '$routeProvider', function ($routeProvider)
{
    $routeProvider
        .when('/home/persons/index', {
            templateUrl: 'modules/persons/partials/pages/persons-index.html',
            controller : 'personsCommunityIndexCtrl'
        })
        .when('/home/persons/:personId/events', {
            templateUrl: 'modules/persons/partials/pages/persons-events.html',
            controller : 'personsEventListCtrl'
        })

        .when('/home/persons/thumbnail', {
            templateUrl: 'modules/persons/partials/views/persons-thumbnail.html',
            controller : 'personsListCtrl'
        })
        .when('/home/persons/new', {
            templateUrl: 'modules/persons/partials/pages/persons-new.html',
            controller : 'personsNewCtrl'
        })
        .when('/home/persons/edit/:personId', {
            templateUrl: 'modules/persons/partials/pages/persons-edit.html',
            controller : 'personsEditCtrl'
        })
        .when('/home/persons/show/:personId', {
            templateUrl: 'modules/persons/partials/pages/persons-show.html',
            controller : 'personsShowCtrl'
        })
        .otherwise({
            redirectTo: '/persons/list'
        });
}
]);
