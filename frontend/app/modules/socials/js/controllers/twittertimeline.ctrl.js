/**
 * Show twitter timeline controller
 *
 * @type {controller}
 */
angular.module('socialsApp').controller('twitterTimelineCtrl', [
    '$scope', '$routeParams', 'twitterFact', '$location',
    function ($scope, $routeParams, twitterFact, $location)
    {
        // Retrieve the url and get the specific scope
        //TODO change this !
        // => use angular's scope inheritance properties or $routeParams or something more appropriated
        $scope.entitiesLbl = $location.$$path.split('/')[2];

        $scope.$watch('$parent.person', function (person)
        {
            if (person && person.twitter)
            {
                $scope.tweets = twitterFact.getPersonTag({tag: person.twitter }, function success(data)
                {
                    $scope.tweets = data;
                });
            }
        }, true);
    }]);
