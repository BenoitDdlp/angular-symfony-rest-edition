'use strict';

/**
 * angular directive used to handle infinite scroll, filter and specific query on list of entities
 * use it like :
 *  <div entity-list-handler="person" offset="-20" limit="20" query="""></div>
 *
 *    @param entityListHandler                  : the name of the entity the list has to handle
 *    @param (default : -20) offset             : the starting index of the entity
 *    @param (default : 20) limit               : The number of instance to fetch
 *    @param (default : null) query             : Query filter to add
 *    @param (default : "label") orderBy        : The side of the sort (ascendent : ASC | descendent : DESC
 *    @param (optional) query                   : A string filter
 */
angular.module('asreApp').directive('entityListHandler', [
  '$routeParams',
  'searchService',
  function ($routeParams, searchService)
  {
    var pageSize = globalConfig.page_size;
    return {
      restrict: 'A',
      link: function (scope, element, attrs)
      {
        //"request" param in scope specifies kind of entity
        if (!attrs.entityListHandler)
        {
          return console.error('missing mandatory param "entity-list-handler" for directive "entity-list-handler" directive (see doc above)');
        }

        //"request" param in scope specifies the url to use for fetching entities
        if (!scope.request)
        {
          return console.error('missing mandatory request parameter in the scope');
        }

        //The type of entity to load (papers/events/persons...)
        var childEntityLbl = attrs.entityListHandler,
          reset = false,
        //offset is the row number to start the results set from
        //use fetchPage(pageNb, reset) to change this value for infinitescroll and pagination
          offset = parseInt(attrs.offset) || pageSize
          ;

        //Initialize the options
        //Query is a string
        scope.query = attrs.query;
        //order object
        scope.order = attrs.order || globalConfig[childEntityLbl].order;
        //Limit is the results set size
        scope.limit = parseInt(attrs.limit) || pageSize;
        //currentPage is the page to fetch when use fetchPage(page). must be exposed to be watched by bootstrap ui pagination
        scope.currentPage = 1;
        //Busy is use by the infinite-scroll directive to manage scroll event listenning
        scope.busy = false;

        //scope.load is the search function triggered by infinite-scroll directive when a scroll event is detected and busy is false
        scope.load = search;

        //put sendQuery function in scope for reuse
        scope.sendQuery = sendQuery;
        //put goToPage function in scope for reuse
        scope.fetchPage = fetchPage;
        //put order function in scope for reuse
        scope.orderBy = orderBy;
        //put filter function in scope for reuse
        scope.filter = filter;


        function initialize()
        {
          offset = 0;
        }

        //Called when a query is type
        function sendQuery(query)
        {
          initialize();
          scope.query = query;
          search(true);
        }

        //called by pagination && ininiteScroll
        function fetchPage(page, reset)
        {
          scope.currentPage = page;
          offset = (page - 1) * scope.limit;
          search(reset);
        }

        //Called when an order parameters is changed
        function orderBy(orderBy, orderSide)
        {
          initialize();
          scope.order[orderBy] = orderSide || "ASC";
          search(true);
        }


        //Called when a filter changes (scope.filters are managed by the list controller)
        function filter()
        {
          initialize();
          search(true);
        }

        //Trigger the search with specified parameters.
        // The request is handled by the search service that will serialize the request
        function search(resetResults)
        {
          //param specifying if results set has to be cleared when new data received
          reset = resetResults;


          //a request is now pending, infinite-scroll stops listening on scroll event
          scope.busy = true;

          //send request to search service with parameters
          searchService.doSearch({
            entitiesLbl: childEntityLbl,
            callback: callback
          }, {
            request: scope.request,
            query: scope.query,
            offset: offset,
            limit: scope.limit,
            order: scope.order,
            filters: scope.filters,
            routeParams: $routeParams,
          });

          //increasing offset
          offset = offset + scope.limit;
        }

        //Manage the results set coming back from the server
        function callback(data)
        {
          var items = data.results;
          scope.count = data.count;

          //Copy results set into scope.entities fœor display
          //if reset specified, clear the data object entities
          if (reset)
          {
            scope.entities = items;
          }
          else
          {
            for (var i = 0; i < items.length; i++)
            {
              scope.entities.push(items[i]);
            }
          }

          if (items.length > 0)
          {
            scope.busy = false;
          }
        }
      }
    };
  }]);
