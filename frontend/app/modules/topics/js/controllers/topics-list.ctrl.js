/**
 * List (all) topics controller
 *
 * @type {controller}
 */
angular.module('topicsApp').controller('topicsListCtrl', [
  '$scope',
  'createDialog',
  'topicsFact',
  function ($scope, createDialogService, topicsFact)
{
    $scope.GLOBAL_CONFIG = $scope.$root.GLOBAL_CONFIG;

    var offset = -20;
    var limit = 20;
    $scope.busy = false;

    $scope.topics = [];

    $scope.reload = function ()
    {
        // $scope.topics = Topic.list();
        $scope.topics.$promise.then(function ()
        {
            console.log('From cache:', $scope.topics);
        });
        //console.log($scope.topics);
    };

    $scope.clone = function (topic)
    {
        // $scope.topics = Topic.list();

        var cloneTopic = angular.copy(topic);
        delete cloneTopic.id;

        var error = function (response, args)
        {
            $scope.$root.$broadcast('AlertCtrl:addAlert', {code: 'Clone not completed', type: 'danger'});
        };

        var success = function (response, args)
        {
            $scope.$root.$broadcast('AlertCtrl:addAlert', {code: 'Topic saved', type: 'success'});
            $scope.topics.push(response);
        };

        cloneTopic.$create({}, success, error);
    };


    $scope.deleteModal = function (index, topic)
    {
        $scope.index = index;

        createDialogService('modules/topics/partials/topics-delete.html', {
            id        : 'complexDialog',
            title     : 'Topic deletion',
            backdrop  : true,
            controller: 'topicsDeleteCtrl',
            success   : {label: 'Ok', fn: function ()
            {
                topicsFact.delete({id: topic.id});
                $scope.topics.splice(index, 1);
            }}
        }, {
            topicModel: topic
        });
    };


    $scope.load = function (query)
    {
        offset = offset + limit;

        if (query)
        {
            offset = 0;
            limit = 20;
            $scope.busy = false;
        }

        if (this.busy)
        {
            return;
        }

        $scope.busy = true;
        topicsFact.all({offset: offset, limit: limit, query: query}, function (data)
        {
            var items = data;

            if (query)
            {
                $scope.topics = data;
            }
            else
            {
                for (var i = 0; i < items.length; i++)
                {
                    $scope.topics.push(items[i]);
                }
            }

            if (items.length > 1)
            {
                $scope.busy = false;
            }
        })
    };
}]);
