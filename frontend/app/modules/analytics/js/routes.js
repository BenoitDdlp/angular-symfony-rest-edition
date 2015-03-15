/**
 * Events module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('analyticsApp').config([ '$routeProvider', function ($routeProvider)
{
    $routeProvider
        .when('/home/analytics/index', {
            templateUrl: 'modules/analytics/partials/pages/analytics-index.html',
            controller : 'analyticsIndexCtrl'
        })
        .otherwise({
            redirectTo: '/'
        });
}
]);
