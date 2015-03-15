/**
 * Events module configuration
 * route <--> template <--> controller
 *
 * @type {config}
 */
angular.module('messagesApp').config([ '$routeProvider', function ($routeProvider)
{
    $routeProvider
        .when('/messages/inbox', {
            templateUrl: 'modules/messages/partials/pages/messages-inbox.html',
            controller : 'messagesInboxCtrl'
        })
        .when('/messages/chatroom', {
            templateUrl: 'modules/messages/partials/pages/messages-chatroom.html',
            controller : 'messagesChatroomCtrl'
        })
        .otherwise({
            redirectTo: '/messages'
        });
}
]);
