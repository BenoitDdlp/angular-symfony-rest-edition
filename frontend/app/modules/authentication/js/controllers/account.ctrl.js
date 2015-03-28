
/**
 * account controller
 * Manage connexion informations and parameters related to the access to asre
 * @type {controller}
 */
angular.module('authenticationApp').controller('accountCtrl', [ '$scope', '$rootScope', '$routeParams', 'usersFact', '$location', function ($scope, $rootScope, $routeParams, usersFact, $location)
{
  if (!$scope.$root.loggedUser)
    {
        $location.path('/');
    }

}]);
