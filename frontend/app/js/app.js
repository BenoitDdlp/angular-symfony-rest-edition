'use strict';

/**
 * Main angular app
 */

/**
 * Main app sub-modules
 */
angular.module('organizationsApp', []);
angular.module('i18nApp', ['pascalprecht.translate']);
angular.module('notificationsApp', []);
angular.module('messagesApp', []);
angular.module('topicsApp', []);
angular.module('personsApp', []);
angular.module('analyticsApp', []);
angular.module('locationsApp', []);
angular.module('angularTranslateApp', ['pascalprecht.translate']);
angular.module('authenticationApp', ['ngCookies', 'personsApp', 'angularOauth']);
angular.module('socialsApp', []);
angular.module('positionsApp', []);
angular.module('angulartics', []);
angular.module('angulartics.google.analytics', []);

angular.module('importApp', []);


/**
 * Main Asre Angular app depedencies
 */
var asreApp = angular.module('asreApp', [
    'validation.match',
    'toggle-switch',
    'ui.bootstrap',
    'ui.select2',
    'xeditable',
    'angularMoment',
    'ngCookies',
    'ngResource',
    'ngSanitize',
    'ngRoute',
    'ngAnimate',
/** ASRE APPS **/
    'pascalprecht.translate',
    'ngCachedResource',
  'angularOauth',
    'authenticationApp',
    'importApp',
    'i18nApp',
    'organizationsApp',
    'personsApp',
    'topicsApp',
    'locationsApp',
    'messagesApp',
    'socialsApp',
    'notificationsApp',
    'analyticsApp',
    'angulartics',
    'angulartics.google.analytics',
    'flow',
    'positionsApp'
]);


/**
 * Configurations at run for xEditable live-edit plugin
 * (execute after injection)
 */
angular.module('asreApp').run(function (editableOptions, editableThemes)
{
    //Set bootstrap 3 theme
    editableOptions.theme = 'bs3';
    // overwrite submit button template
    editableThemes['bs3'].submitTpl = '<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i></button>';
    editableThemes['bs3'].cancelTpl = '<button type="button" class="btn btn-default" ng-click="$form.$cancel()"><i class="fa fa-times"></i></button>';

    $("#page-content").css("min-height", window.innerHeight - $('header.navbar').height());
    $(window).resize(function ()
    {
        $("#page-content").css("min-height", window.innerHeight - $('header.navbar').height());
    });

});

/**
 * Authentication module configuration from ASRE
 *
 * @type {config}
 */
angular.module('asreApp').config(['$provide', '$httpProvider', function ($provide, $httpProvider)
{
    //Add our custom interceptor on AJAX requests
    $httpProvider.interceptors.push('globalHttpInterceptor');

    //Enable cors authentication (otherwise doesn't set session cookie)
    $httpProvider.defaults.useXDomain = true;
    $httpProvider.defaults.withCredentials = true;

}]);



