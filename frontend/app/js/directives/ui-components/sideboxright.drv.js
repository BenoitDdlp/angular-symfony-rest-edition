/**
 * sideboxright directive
 * use to create a new navigation box on the right side just like the nav right bar
 * The sidebox share the scope with the controller that is responsible for the scope of the view that instantciated it
 * use it like :
 * <div sideboxright="" show-sidebox-right="showFilterBar" inner-template-url="{{GLOBAL_CONFIG.app.modules.events.urls.partials}}pages/events-filters.html"></div>
 * @param show-sidebox-right, boolean that decides the visibility of the side bar (true = visible, false = not) default="false"
 * @param inner-template-url, the template url to load inside de side box
 */
angular.module('asreApp').directive('sideboxright', [
  function ()
  {
    return {
      restrict: 'EA',
      template: '<div ng-include="templateUrl"  ></div>',
      link: function (scope, element, attr)
      {

        //Set templateUrl to be used in the "template" property of the directive
        scope.templateUrl = 'partials/sideboxright/sideboxright.html';

        //Set the template to load inside the sidebox
        scope.innerTemplateUrl = attr.innerTemplateUrl || "";
        //Watch for visibility value changes
        scope.$watch(function ()
        {
          return scope.showSideboxRight;
        }, function (newVal, oldVal)
        {
          if (newVal)
          {
            //Add class to the parent and make the ".sideboxright" visible
            element.addClass("show-sideboxright");
          }
          else
          {
            //Remove classes that makes the ".sideboxright" visible
            element.removeClass("show-sideboxright");
            element.find(".show-sideboxright").removeClass("show-sideboxright");
          }
        })
      }
    }
  }]);
