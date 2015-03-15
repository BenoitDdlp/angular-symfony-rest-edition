'use strict';

/**
 * Navigation main controller. Handles the configuration of the nav bars and search system
 * @TODO : theme replace
 */
angular.module('asreApp').controller('navMainCtrl', ['$scope', '$rootScope', '$location', '$timeout', '$uiConfig', function ($scope, $rootScope, $location, $timeout, $uiConfig)
{

  //Array containing the open nodes (nodes clicked)
  $scope.openNodes = [];
  //Array containing the open nodes (nodes clicked)
  $scope.selectedNodes = [];

  /**
   * This menu is always present
   * @type {{label: string, iconClass: string, link: string}[]}
   */
  var basicMenu = [
    {
      label: 'persons.links.persons',
      iconClass: 'fa fa-user',
      link: '#/home/persons/index'
    },
    {
      label: 'organizations.links.organizations',
      iconClass: 'fa fa-group',
      link : '#/home/organizations/index'
    },
    {
      label: "menu",
      iconClass: 'fa fa-certificate',
      childNodes: [
        {
          label: 'persons.links.persons',
          iconClass: 'fa fa-user',
          link: '#/home/persons/index'
        }
      ]
    }
  ];

  /**
   * Set parent for all nodes
   *
   * @param childNodes
   * @param parent
   */
  var setParent = function (childNodes, parent)
  {
    angular.forEach(childNodes, function (child)
    {
      child.parent = parent;
      if (child.childNodes !== undefined)
      {
        setParent(child.childNodes, child);
      }
    });
  };

  /**
   * Get the menu node from the link
   * Goal : set the correct left menu node selected whenever the user
   * change the current main page (or directly from the link)
   *
   * @param childNodes
   * @param link
   * @returns {*} the node from the menu architecture
   */
  $scope.findNodeByUrl = function (childNodes, link)
  {
    for (var i = 0, length = childNodes.length; i < length; i++)
    {
      if (childNodes[i].link && childNodes[i].link.replace('#', '') == link)
      {
        return childNodes[i];
      }
      if (childNodes[i].childNodes !== undefined)
      {
        var node = $scope.findNodeByUrl(childNodes[i].childNodes, link);
        if (node)
        {
          return node;
        }
      }
    }
  };


  /**
   * Action triggerred when a node is selected
   * @param node
   */
  $scope.navigate = function (node)
  {
    // Close the node and stop if selected node opened
    if (node.open)
    {
      node.open = false;
      return;
    }
    //Close all nodes
    for (var i = $scope.openNodes.length - 1; i >= 0; i--)
    {
      $scope.openNodes[i].open = false;
    }
    $scope.openNodes = [];
    var parentNode = node;

    //Open all the parent
    while (parentNode !== null)
    {
      parentNode.open = true;
      $scope.openNodes.push(parentNode);
      parentNode = parentNode.parent;
    }

    // handle leaf nodes
    if (!node.childNodes || (node.childNodes && node.childNodes.length < 1))
    {
      for (var j = $scope.selectedNodes.length - 1; j >= 0; j--)
      {
        $scope.selectedNodes[j].selected = false;
      }
      $scope.selectedNodes = [];
      parentNode = node;
      while (parentNode !== null)
      {
        parentNode.selected = true;
        $scope.selectedNodes.push(parentNode);
        parentNode = parentNode.parent;
      }
    }
  };


  /**
   * Initialize menu with current link path
   * @returns {string}
   */
  function initMenu()
  {
    /**
     * Each time there is a change, the menu is actualized
     *
     */
    $scope.menu = basicMenu;

    /**
     * Set hierarchy for a menu node
     */
    setParent($scope.menu, null);

    /**
     * Set selected node
     */
    initSelected();

    return $location.path();
  }
  /**
   * Select node according to the current link
   */
  function initSelected()
  {
    //Find current node from link
    var currentNode = $scope.findNodeByUrl($scope.menu, $location.path());
    if (currentNode)
    {
      //Mark as selected
      $scope.navigate(currentNode);
    }
  }

  //Trigger init
  initMenu();

  /**
   * Menu search form
   * @param $e
   */
  $scope.showSearchBar = function ($e)
  {
    $e.stopPropagation();
    $uiConfig.set('searchCollapsed', true);
  };
}]);











