/**
 * tile directive
 * use to handle tile component rendering
 * @TODO : theme replace
 */
angular.module('asreApp').directive('tile', [
  function ()
  {
    return {
      restrict: 'E',
      scope: {
        heading: '@',
        type: '@'
      },
      transclude: true,
      templateUrl: 'partials/tiles/tile-generic.html',
      link: function (scope, element, attr)
      {
        var heading = element.find('tile-heading');
        if (heading.length)
        {
          heading.appendTo(element.find('.tiles-heading'));
        }
      },
      replace: true
    }
  }]);
