/**
 * Directive for autocompletion for entity links
 * use it like :
 *
 *  <div asre-autocomplete="organizations" on-select="addOrganization" on-keyup="searchOrganizations"></div>
 *
 *  the template is loaded dynamicaly like :
 *  "modules/" + scope.searchedEntity + "/partials/" + scope.searchedEntity + "/" + scope.searchedEntity + "-select.html"
 *
 *    @param asre-autocomplete : plural name of the entity to propose in the autocomplete (used to get the "select" template dynamicaly)
 *    @param on-select             : Function to trigger when a selection is done
 *    @param on-keyup             : Function to trigger when the user type a research
 */
angular.module('asreApp').directive('asreAutocomplete', [
  '$q',
  '$routeParams',
  function ($q, $routeParams)
  {
    return {
      template: '<div ng-include="templateUrl" ></div>',
      scope: {
        onSelect: "=",
        onKeyup: "="
      },

      link: function (scope, element, attrs)
      {
        if (!attrs.asreAutocomplete)
        {
          return console.error('missing mandatory field in "asre-autocomplete" directive (see doc above)');
        }

        scope.searchedEntity = attrs.asreAutocomplete;
        scope.templateUrl = "modules/" + scope.searchedEntity + "/partials/" + scope.searchedEntity + "/" + scope.searchedEntity + "-select.html";

        /**
         * fired when the keyboard is hit
         * @param query
         */
        scope.keyup = function (query)
        {
          //Prepare the parameters for the request
          var requestParams = {};
          requestParams.query = query;

          //Add route parameters to object for request
          for (var param in $routeParams)
          {
            requestParams[param] = $routeParams[param];
          }

          //Promise needed by the typeahead directive, resolved when something is typed
          var deferred = $q.defer();
          scope.onKeyup(requestParams, function (data)
          {
            data.results.push({label: ""});
            deferred.resolve(data.results);
          });
          return deferred.promise;
        };

        /**
         * fired when a selection is done on the autocomplete list
         * @param $item represents the selected item
         */
        scope.select = function ($item)
        {
          if ($item)
          {
            //Trigger the onSelect from the controller responsible for the view
            scope.onSelect($item);
          }


        }
      }
    };


  }]);


