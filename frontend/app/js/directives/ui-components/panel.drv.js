/**
 * panel directive
 * use to handle panel component rendering
 */
angular.module('asreApp').directive('panel', [
  function ()
  {
    return {
      restrict: 'E',
      transclude: true,
      scope: {
        panelClass: '@',
        heading: '@',
        panelIcon: '@'
      },
      templateUrl: 'partials/panels/panel.html'
    }
  }]);
