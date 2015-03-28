/**
 * Sign out controller
 *
 * @type {controller}
 */
angular.module('authenticationApp').controller('signoutCtrl', [
  '$scope',
  '$window',
  '$routeParams',
  'pinesNotifications',
  '$cookieStore',
  '$location',
  'usersFact',
  'translateFilter',
  function ($scope, $window, $routeParams, pinesNotifications, $cookieStore, $location, usersFact, translateFilter)
  {

    var error = function (response, args)
    {
      //Notify of the signout action error
      pinesNotifications.notify({
        title: translateFilter('global.validations.error'),
        text: translateFilter('response.data.error'),
        type: 'error'
      });
    };

    var success = function (response, args)
    {
      //Clear user from local storage and rootscope
      alert("user logged OUT");

      //Notify of the signout action success
      pinesNotifications.notify({
        title: translateFilter('global.validations.success'),
        text: translateFilter('authentication.validations.signout_success'),
        type: 'success'
      });

//            $location.path('/');
    };

    //Send signout request
    $scope.signoutAction = function ()
    {
      usersFact.signout({}, success, error);
    }
  }]);
