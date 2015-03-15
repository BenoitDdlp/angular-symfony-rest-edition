/**
 * tile mini directive
 * use to handle tile mini component rendering
 * @TODO : theme replace
 */
angular.module('asreApp').directive('tileMini', [
  function ()
  {
    return {
      restrict: 'E',
      scope: {
        item: '=data'
      },
      replace: true,
      templateUrl: 'partials/tiles/tile-large.html'
    }
  }]);
