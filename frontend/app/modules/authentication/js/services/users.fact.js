/**
 * User Factory
 *
 * Service calls for following actions :
 * - get
 * - signin
 * - signup
 * - show
 * - list
 *
 * @type {factory}
 */
angular.module('authenticationApp').factory('usersFact', ['$resource', function ($resource)
{
  return $resource(
    globalConfig.api.urls.login,
    {id: '@id'},
    {
      get: {method: 'GET', params: {}, isArray: false},
      signin: {method: 'POST', params: {}, isArray: false},
      token: {method: 'GET', url: globalConfig.api.urls.token, params: {no_token: true}, isArray: false},
      revoke: {
        method: 'GET', url: globalConfig.api.urls.revoke + '/:token', params: {token: '@token', no_token: true},
        isArray: false
      },
      signup: {method: 'POST', url: globalConfig.api.urls.registration, isArray: false},
      confirm: {method: 'POST', url: globalConfig.api.urls.confirm, isArray: false},
      changepwd: {method: 'POST', url: globalConfig.api.urls.changepwd, isArray: false},
      resetpwdrequest: {method: 'POST', url: globalConfig.api.urls.reset_pwd_request, isArray: false},
      resetpwd: {method: 'POST', url: globalConfig.api.urls.reset_pwd, isArray: false},
      show: {method: 'GET', isArray: false}
    }
  );
}]);

