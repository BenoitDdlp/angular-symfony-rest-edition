/**
 * Sign in controller
 * Handles the signin process of a user
 * @type {controller}
 */

angular.module('authenticationApp').controller('signinCtrl',[
  '$scope',
  '$routeParams',
  'usersFact',
  '$location',
  '$modal',
  '$timeout',
  'pinesNotifications',
  'translateFilter',
  'authenticationFact',
  function ($scope, $routeParams, usersFact, $location, $modal, $timeout, pinesNotifications, translateFilter, authenticationFact)
    {
        //log user after a social account login.
        var id = getURLParameter('id'),
            username = getURLParameter('username');
        if (id && username)
        {
            //remove username and id param from url
            window.location.href = window.location.href.replace(/&?(username|id)=.[^&]*/g, "");
//            todo : fetch this ?
            success({username: username, id: id}, false);
        }
        else
        {
            $scope.$root.currentUser = JSON.parse(localStorage.getItem('currentUser'));
        }

        $scope.user = $scope.$root.currentUser || new usersFact;
        $scope.user._remember_me = true;

        var error = function (response, args)
        {
            //Notify of the signin action error
            pinesNotifications.notify({
                title: translateFilter('global.validations.error'),
                text : translateFilter('authentication.validations.signin_error'),
                type : 'error'
            });
        };

        function success(user, notif)
        {
            $scope.user = user;

            //Modify current user
            authenticationFact.addUser(user);

            //Notify of the signin action success
            if (notif)
            {
                pinesNotifications.notify({
                    title: translateFilter('global.validations.success'),
                    text : translateFilter('authentication.validations.signin_success'),
                    type : 'success'
                });
            }

            //Close modal
            if ($scope.$close)
            {
                $scope.$close();
            }
        }

        //Manage the signin modal
        $scope.showSigninPopup = $scope.$root.showSigninPopup = function ()
        {
            //Open signin modal
            var modalInstance = $modal.open({
                templateUrl: 'modules/authentication/partials/signin.html',
                controller : 'signinCtrl',
                size       : "large"
            });
        };

        //Send signin request with signin form information
        $scope.signinAction = function (user)
        {
            //TODO serialize login method in resource
            usersFact.signin({}, {"_username": $scope.user._username, "_password": $scope.user._password, "_remember_me": $scope.user._remember_me}, success, error);
        };

        function getURLParameter(param)
        {
            var sURLVariables = window.location.hash.split('?').length > 1 ? window.location.hash.split('?')[1].split('&') : {};
            var sURLVariables = window.location.hash.split('?').length > 1 ? window.location.hash.split('?')[1].split('&') : {};
            for (var i = 0; i < sURLVariables.length; i++)
            {
                var parameterName = sURLVariables[i].split('=');
                if (parameterName[0] == param)
                {
                    return parameterName[1];
                }
            }
        }

    }]);
