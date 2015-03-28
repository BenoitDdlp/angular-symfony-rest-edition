/**
 * directive used to hide a div when the current logged user doesn't have enough permission
 * @param right-right (optional) (default="OPERATOR") : the right to ask the permission for : @see asre-right-service.fact.js for more informations
 *
 * use it like :
 * <a right-show="person"  right-right="EDIT" class="btn btn-info" href="#persons/edit/{{mainEvent.id}}" role="button">
 *
 */
angular.module('asreApp').directive('asreRightShow', [
  function ()
  {
    //operator right can do everything but delete the whole mainEvent
    var read = "READ",
      edit = "EDIT",
      defaultRightToAsk = edit,
      field = "right",
      justLoggedIn = false
      ;

    return {
      restrict: 'A',
      scope: {
        resource: '=asreRightShow',
        resourceName: '@asreRightShow',
        right: '@asreRightRight'
      },
      link: function (scope, element, attrs)
      {
        if (!scope.resource)
        {
          return console.warn('Cannot get ' + scope.resourceName + ' from parent scope in "asre-right-show". Thus, cannot refresh right');
        }

        scope.resource.isRightUpToDate = false;

        //watch logged user to refresh its rights
        scope.$watch("$root.loggedUser", function (newValue, oldValue, scope)
        {
          if (newValue == oldValue)
          { //no change
            return;
          }

          if (scope.resource.isRightUpToDate)
          { //the update has already been handled by another asreRightShow directive.
            return;
          }
          scope.resource.isRightUpToDate = true;

          if (!newValue || !newValue.id)
          { //user has just logged out
            delete scope.resource.right;

            scope.resource.isRightUpToDate = false;
            return;
          }

          //user has just logged in
          justLoggedIn = true;
          //refresh context
//                    contextFact.refreshContext();

          if (!scope.resource.$promise)
          {
            //use sendQuery from entity list
            if (scope.$parent.sendQuery)
            {
              scope.$parent.sendQuery();
            }
            else
            {
              console.warn('Cannot get ' + scope.resourceName + ' as promise from parent scope in.');
            }
          }
          else
          {

            // we refetch the parent promise to update the right field
            scope.resource.$get({})
              .then(function ()
              {
                scope.resource.isRightUpToDate = false;
              });
          }
        });

        //watch promise right attribute to change button style (shown, hidden or disabled)
        scope.$watch("$parent." + scope.resourceName + "." + field, function (newValue, oldValue, scope)
        {
          if (!newValue)
          {
            element.hide();
          }
          else if (!scope.$root.loggedUser || !scope.$root.loggedUser.id)
          { //hide if not logged
            element.hide();
          }
          else
          {
            //if the current logged user has right on the entity : display the button.
            if (edit == (scope.right || defaultRightToAsk ))
            {
              element.show();
              //if the user has just logged in, make it pulsate!
              if (justLoggedIn)
              {
                //$(element).pulsate({repeat: 2});
                //wait before all other directive are processed to change this shared value.
                setTimeout(function ()
                {
                  justLoggedIn = false;
                }, 100)
              }
            }
            else
            {
              element.hide();
            }
          }
        });
      }
    }
  }
]);
