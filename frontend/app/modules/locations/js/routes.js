/**
 * Location module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('locationsApp')
  .config(
  ['$routeProvider',
    function ($routeProvider)
    {
      $routeProvider
        .otherwise({
          redirectTo: '/home/locations/list'
        });
    }
  ]);
