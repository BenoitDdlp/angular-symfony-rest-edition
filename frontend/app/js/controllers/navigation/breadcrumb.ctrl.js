'use strict';

/**
 * Breadcrumb controller (or also called 'fil d'ariane')
 */
angular.module('asreApp').controller('breadcrumbCtrl', ['$scope', '$rootScope', '$location', function ($scope, $rootScope, $location)
{
    /**
     * Definitions for breadcrump
     *
     * idUrl: mandatory, must correspond to the sub url of the current page
     * label: mandatory, the label to show on the breadcrumb
     * url: optional, the url where to go when the user click on it
     * children: the children node (must know all routes of the next subUrl)
     *
     * @type {{idUrl: string, label: string, url: string, children: {idUrl: string, label: string, children: {idUrl: string, label: string}[]}[]}[]}
     */
    var breadcrumbDefinitions = [
        {
            idUrl: 'home',
            label: 'navleft.home',
            url: '#/',
            children: [
                {
                    idUrl: 'authentication',
                    label: 'authentication.links.authentication',
                    children: [
                        {
                            idUrl: 'account',
                            label: 'authentication.labels.account'
                        }
                    ]
                },
                {
                    idUrl: 'persons',
                    label: 'persons.links.persons',
                    children: [
                        {
                            idUrl: 'show',
                            label: 'global.actions.show'
                        },
                        {
                            idUrl: 'edit',
                            label: 'global.actions.edit'
                        },
                        {
                            idUrl: 'index',
                            label: 'global.actions.search'
                        }
                    ]
                },
                {
                    idUrl: 'organizations',
                    label: 'organizations.links.organizations',
                    children: [
                        {
                            idUrl: 'index',
                            label: 'organizations.actions.search'
                        }
                    ]
                }
            ]
        }
    ];

    /**
     * Find an item in an items array
     *
     * @param items A list of items
     * @param itemId The item to look for
     * @returns {*}
     */
    var findItem = function (items, itemId)
    {
        if (items !== undefined)
        {
            for (var i = 0, length = items.length; i < length; i++)
            {

                if (itemId === items[i].idUrl)
                {
                    return items[i];
                }
            }



            console.error('[ERROR] - Breadcrumb.js : \n   children node \'' + itemId + '\' does not exist.\n   The parent node must contains a correct id child.');
            return null;
        }
        else
        {
            console.error('[ERROR] - Breadcrumb.js : \n   parent node for itemId \'' + itemId + '\' undefined.\n   Maybe you forgot to define a children node ?')
        }
        return null;
    };

    /**
     * Return an array containing the breadcrump to show
     *
     * @returns {Array}
     */
    var getCurrentBreadcrumb = function ()
    {
        // Getting the current url...
        var currentPath = $location.path();
        // ...Removing the first '/'...
        currentPath = currentPath.substr(1);
        // ...Splitting each subroutes...
        var arrayPath = currentPath.split('/');
        // ...and for each sub paths
        var subPath = null;
        var breadcrumbArray = [];
        var isLastSubpath = false;
        var tempArray = breadcrumbDefinitions;
        for (var i = 0; i < arrayPath.length; i++)
        {

            // If it's the last subpath
            if (i === (arrayPath.length - 1))
            {
                isLastSubpath = true;
            }


            subPath = arrayPath[i];

            //@TODO: find a solution for variable in breadcrum (something with the entities label ?). Exclude IDS from lookup for now
            if( parseInt(subPath)){
                // Add a "fake" value for the variable on the breacrum
                breadcrumbArray = breadcrumbArray.concat([
                    {
                        label: subPath,
                        url: "",
                        isActive: isLastSubpath ? 'active' : ''
                    }
                ]);
                continue;
            }

            tempArray = findItem(tempArray, subPath);

            if (tempArray != null)
            {


                // For each element, we add the item to the breadcrump line
                breadcrumbArray = breadcrumbArray.concat([
                    {
                        label: tempArray.label,
                        url: (tempArray.url !== undefined) ? tempArray.url : false,
                        isActive: isLastSubpath ? 'active' : ''
                    }
                ]);
                tempArray = tempArray.children;
            }
            else
            {
                // If an error occured, we stop the process
                i = arrayPath.length;
            }
        }
        return breadcrumbArray;
    };

    $scope.breadcrumbArray = getCurrentBreadcrumb();
}]);











