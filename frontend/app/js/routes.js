'use strict';

/**
 * Main Asre angular application router
 */
angular.module('asreApp').config(['$provide', '$routeProvider', function ($provide, $routeProvider)
{
    $routeProvider
        .when('/', {
            templateUrl: 'partials/home/home.html',
            controller: 'mainCtrl'
        })
        .otherwise({
            /**
             * IF UNKNOWN ROUTE : redirection to the main page (see above)
             */
            redirectTo: '/'
        });

}]);

