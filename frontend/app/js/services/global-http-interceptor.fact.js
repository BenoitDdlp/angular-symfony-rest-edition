/**
 * Global http interceptor
 * Listen every request in or out from the client.
 * Manage global serialization of entities for server request.
 * Watch for 401 or 403 request response
 *
 *
 */
angular.module('asreApp').factory('globalHttpInterceptor', [
  '$q',
  '$rootScope',
  'pinesNotifications',
  'translateFilter',
  'progressLoader',
  'authenticationFact',
  function ($q, $rootScope, pinesNotifications, translateFilter, progressLoader, authenticationFact)
  {


    //Interceptor configurations
    return {

      //Executed whenever a request is made by the client
      'request': function (config)
      {
        progressLoader.start();
        progressLoader.set(50);
        var token = authenticationFact.getToken();
        if (config.url.indexOf(globalConfig.api.urls.base) > -1)
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
      'response': function (response)
      {
        //Stop progress loader
        progressLoader.end();
        return response || $q.when(response);
      },


      //Executed whenever an error is received
      'responseError': function (rejection)
      {
        //Stop progress loader
        progressLoader.end();
        //Watch for unauthorized status
        if (rejection.status == "401")
        {
          $rootScope.startOAuthLoginWorkflow();
        }

        //Watch for forbidden status
        else if (rejection.status == "403")
        {
          //Notify of the field update action error
          pinesNotifications.notify({
            title: translateFilter('global.validations.error'),
            text: translateFilter('authentication.messages.forbidden'),
            type: 'error'
          });
        }
//                else if (rejection.data.error)
//                {
//                    $rootScope.$broadcast('AlertCtrl:addAlert', {code: rejection.data.error, type: 'warning'});
//                }
        else
        {
//         $rootScope.$broadcast('AlertCtrl:addAlert', {code: rejection.status + ' ' + rejection.statusText, type: 'danger'});
        }

        //Resolve the promise
        return $q.reject(rejection);
      }
    };
  }
]);
