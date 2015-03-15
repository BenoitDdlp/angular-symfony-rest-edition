/**
 * Events module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('notificationsApp').config(['$routeProvider', function ($routeProvider)
{
  $routeProvider
    .when('/notifications', {
      templateUrl: 'modules/notifications/partials/pages/notifications-list.html',
      controller: 'notificationsListCtrl'
    })
    .otherwise({
      redirectTo: '/notifications'
    });
}
]);
