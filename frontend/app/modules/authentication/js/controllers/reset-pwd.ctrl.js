/**
 * reset password controller
 * @type {controller}
 */
angular.module('authenticationApp').controller('resetPwdCtrl', [
  '$scope',
  '$routeParams',
  'usersFact',
  '$location',
  'pinesNotifications',
  'translateFilter',
  function ($scope, $routeParams, usersFact, $location, pinesNotifications, translateFilter)
  {
    var error = function (response, args)
    {
      //Notify of the password reset action error
      pinesNotifications.notify({
        title: translateFilter('global.validations.error'),
        text: translateFilter('response.data.error'),
        type: 'error'
      });
    };

    var success = function (response, args)
    {
      //Notify of the password reset action success
      pinesNotifications.notify({
        title: translateFilter('global.validations.success'),
        text: translateFilter('response.data.error'),
        type: 'success'
      });

      //Modify current user
      alert("user logged in");

      $scope.user = user;

      $location.path('/home/persons/show/' + user.person.id);
    };

    //Send reset pwd request to server
    var user = usersFact.resetpwd({token: $routeParams.token}, success, error);

  }]);
