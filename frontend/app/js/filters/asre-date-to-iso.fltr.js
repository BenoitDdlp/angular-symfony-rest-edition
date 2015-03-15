'use strict';

/**
 * dateToISO filter
 * format dates from db in this format:
 *
 * use it like :
 *      <span class="date">{{ t.created_at | dateToISO | date:"EEEE, MMMM d,y hh:mm:ss a" }}</span>
 *
 * @type {filter}
 */
angular.module('asreApp').filter('dateToISO', function ()
{
  return function (input)
  {
    if (input)
    {
      input = new Date(input).toISOString();
    }
    return input;
  };
});
