describe('Test dashboard controller - ', function() {

    //Asre app has to be loaded first
    beforeEach(module('asreApp'));

    var ctrl, scope;

    //Loading of the  genericModalCtrl
    beforeEach(inject(function($controller, $rootScope) {
        // Create a new scope that's a child of the $rootScope
        scope = $rootScope.$new();
        // Create the controller
        ctrl = $controller('genericModalCtrl', {
            $scope: scope,
            model : {id:1},
            modelName : "mockedModel"
        });
    }));

    //Verify that scope values are well formed
    it('should load scope values', function() {
    });

});


