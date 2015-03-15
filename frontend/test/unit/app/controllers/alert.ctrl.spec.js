describe('Test alert controller - ', function() {

    //Asre app has to be loaded first
    beforeEach(module('asreApp'));

    var ctrl, scope;

    //Loading of the  alertCtrl
    beforeEach(inject(function($controller, $rootScope) {
        // Create a new scope that's a child of the $rootScope
        scope = $rootScope.$new();
        // Create the controller
        ctrl = $controller('alertCtrl', {
            $scope: scope
        });
    }));

    //Verify that scope values are well formed
    it('should load scope values', function() {
        expect(scope.alerts).toBeDefined();
    });

});


