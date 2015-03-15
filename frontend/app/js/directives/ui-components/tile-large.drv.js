/**
 * tile large directive
 * use to handle tile large component rendering
 * @TODO : theme replace
 */
angular.module('asreApp').directive('tileLarge', [
  function ()
  {
    return {
      restrict: 'E',
      scope: {
        item: '=data'
      },
      templateUrl: 'partials/tiles/tile-large.html',
      replace: true,
      transclude: true
    }
  }]);
