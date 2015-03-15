/**
 * directive acting like a filter to display date in a readable format
 * => to be used with ngModel directly on <input> tag
 *
 * use it like :
 * <input type="text" datetime-format ng-model="event.startAt" />
 *
 */
angular.module('asreApp').directive('datetimeFormat', [
    function ()
    {
        return {
            restrict: 'A',
            require : 'ngModel',
            link    : function (scope, element, attrs, ngModel)
            {
                var displayFormat = attrs.datetimeFormat || "LLLL";

                ngModel.$formatters.push(function (value)
                {
                    if (!value)
                    {
                        return value;
                    }
                    return moment(value).format(displayFormat);
                });
            }
        }
    }]);
