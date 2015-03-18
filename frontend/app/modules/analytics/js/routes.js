/**
 * Events module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('analyticsApp').config([ '$routeProvider', function ($routeProvider)
{
    $routeProvider
      .when('/analytics', {
            templateUrl: 'modules/analytics/partials/pages/analytics-index.html',
            controller : 'analyticsIndexCtrl'
        })
        .otherwise({
            redirectTo: '/'
        });
}
]);
