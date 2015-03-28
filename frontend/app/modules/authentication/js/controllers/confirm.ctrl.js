/**
 * confirm email controller
 *
 * @type {controller}
 */
angular.module('authenticationApp').controller('confirmCtrl', [
  '$scope',
  '$routeParams',
  'usersFact',
  'pinesNotifications',
  'translateFilter',
  '$location',
  function ($scope, $routeParams, usersFact, pinesNotifications, translateFilter, $location)
  {
    var error = function (response, args)
    {
      $scope.busy = false;
      $scope.$root.$broadcast('AlertCtrl:addAlert', {code: 'Register_confirm_error', type: 'danger'});
    };

    var success = function (user)
    {
      $scope.user = user;

      //Modify current user
      alert("user logged in");

      //Notify of the signin action success
      pinesNotifications.notify({
        title: translateFilter('global.validations.success'),
        text: translateFilter('authentication.validations.signin_success'),
        type: 'success'
      });

      $location.path('/home/persons/show/' + user.person.id);
    };

    $scope.busy = true;
    var user = usersFact.confirm({token: $routeParams.token}, success, error);
  }]);
