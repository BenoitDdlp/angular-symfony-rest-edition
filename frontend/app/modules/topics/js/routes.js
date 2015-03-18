///**
// * Topics module configuration
// * route <--> template <--> controller
// *
// * @type {config}
// */
angular.module('topicsApp')
  .config(
  ['$routeProvider',
    function ($routeProvider)
    {
      $routeProvider
        .when('/topics/show/:topicId', {
          templateUrl: 'modules/topics/partials/topics-show.html',
          controller: 'topicShowCtrl'
        })
//        .when('/topics/thumbnail', {
//          templateUrl: 'modules/topics/partials/topics-thumbnail.html',
//          controller: 'topicsListCtrl'
//        })
        .when('/topics/new', {
          templateUrl: 'modules/topics/partials/topics-new.html',
          controller: 'topicsNewCtrl'
        });
//        .when('/topics/edit/:topicId', {
//          templateUrl: 'modules/topics/partials/topics-edit.html',
//          controller: 'topicsEditCtrl'
//        })
//        .when('/topics/show/:topicId', {
//          templateUrl: 'modules/topics/partials/topics-show.html',
//          controller: 'topicsShowCtrl'
//        })
//        .otherwise({
//          redirectTo: '/topics/list'
//        });
  }
 ]);
