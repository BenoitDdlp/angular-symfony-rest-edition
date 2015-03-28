/**
 * Main Asre Angular app controller
 */
angular.module('asreApp').controller('mainCtrl', [
  '$scope',
  'GLOBAL_CONFIG',
  '$uiConfig',
  '$timeout',
  function ($scope, GLOBAL_CONFIG, $uiConfig, $timeout)
  {
    //initialize authentified user from local storage
    $scope.$root.currentUser = JSON.parse(localStorage.getItem('loggedUser'));
    $scope.$root.token = JSON.parse(localStorage.getItem('oauth'));


    /**
     * Getting main html attribute configurations for the ui from the uiConfig factory
     */
    $scope.$root.ui_navHeaderHidden = $uiConfig.get('navHeaderHidden');
    $scope.$root.ui_navLeftCollapsed = $uiConfig.get('navLeftCollapsed');
    $scope.$root.ui_navLeftShown = $uiConfig.get('navLeftShown');
    $scope.$root.ui_navRightCollapsed = $uiConfig.get('navRightCollapsed');
    $scope.$root.ui_searchCollapsed = $uiConfig.get('searchCollapsed');
    $scope.$root.ui_eventsFilterBarCollapsed = $uiConfig.get('eventsFilterBarCollapsed');
//    $scope.$root.ui_isSmallScreen = false;


    $scope.toggleNavLeft = function ()
    {
      if ($scope.$root.ui_isSmallScreen)
      {
        return $uiConfig.set('navLeftShown', !$scope.$root.ui_navLeftShown);
      }
      $uiConfig.set('navLeftCollapsed', !$scope.$root.ui_navLeftCollapsed);
    };

    /**
     * Event triggered whenever a global change of layout append
     * (usually when the user click somewhere on the app)
     */
    $scope.$root.$on('uiConfig:change', function (event, newVal)
    {
      $scope.$root['ui_' + newVal.key] = $scope['ui_' + newVal.key] = newVal.value;
    });

    $scope.$on('uiConfig:maxWidth767', function (event, newVal)
    {
      $timeout(function ()
      {
        $scope.$root.ui_isSmallScreen = newVal;
        if (!newVal)
        {
          $uiConfig.set('navLeftShown', false);
        }
        else
        {
          $uiConfig.set('navLeftCollapsed', false);
        }
      });
    });


    /**
     * Specify if the right accordeon show only one element at a time of severals
     * @type {boolean}
     */
    $scope.rightbarAccordionsShowOne = false;


    //Add app configuration to the rootScope
    $scope.$root.GLOBAL_CONFIG = GLOBAL_CONFIG;

    //scrollTop function
    $scope.scrollTop = function ()
    {
      $('html, body').animate({scrollTop: 0}, 'slow');
    }
  }]);

