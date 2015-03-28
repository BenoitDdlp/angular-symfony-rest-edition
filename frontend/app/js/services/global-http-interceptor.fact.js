/**
 * Global http interceptor
 * Listen every request in or out from the client.
 * Manage global serialization of entities for server request.
 * Watch for 401 or 403 request response
 *
 *
 */
angular.module('asreApp').config([
  '$httpProvider',
  function ($httpProvider)
  {
    $httpProvider.interceptors.push([
      '$q',
      '$rootScope',
      'pinesNotifications',
      'translateFilter',
      'progressLoader'
      , function ($q, $rootScope, pinesNotifications, translateFilter, progressLoader)
      {
        return {
          //Executed whenever a request is made by the client
          // append a acces_token param only for rest api request
          request: function (config)
          {
            progressLoader.start();
            progressLoader.set(50);

            if ((config.params && config.params.no_token) || config.url.indexOf(globalConfig.api.urls.base) == -1)
            {
              return config;
            }

            var token = $rootScope.token;
            if (token)
            {
              if (!config.params)
              {
                config.params = {};
              }
              config.params["access_token"] = token.access_token;
            }

            return config;
          },

          //Executed whenever a valid request is received by the client
          response: function (response)
          {
            //Stop progress loader
            progressLoader.end();
            return response || $q.when(response);
          },

          //Executed whenever an error is received
          responseError: function (rejection)
          {
            //Stop progress loader
            progressLoader.end();
            //Reject the promise
            return $q.reject(rejection);
          }
        };
      }
    ])
  }
])
;
