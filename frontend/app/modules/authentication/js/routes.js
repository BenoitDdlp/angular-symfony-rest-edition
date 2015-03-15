/**
 * Authentication module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('authenticationApp')
  .config(
  ['$routeProvider',
    function ($routeProvider)
    {
      $routeProvider
        .when('/home/authentication/account', {
          templateUrl: 'modules/authentication/partials/account.html',
          controller: 'accountCtrl'
        })
        .when('/confirm/:token', {
          templateUrl: 'partials/home/home.html',
          controller: 'confirmCtrl'
        })
        .when('/forgotten_password', {
          templateUrl: 'modules/authentication/partials/reset-pwd-request.html',
          controller: 'resetPwdRequestCtrl'
        })
        .when('/reset/:token', {
          templateUrl: 'partials/home/home.html',
          controller: 'resetPwdCtrl'
        })
        .otherwise({
          redirectTo: '/login'
        });
    }
  ]);
