/**
 * @TODO : define tests
 */
describe('Test personsShowCtrl - ', function() {

    //Asre app has to be loaded first
    beforeEach(module('asreApp', 'personsApp'));

    var ctrl, scope;

    //Loading of the  personsShowCtrl
    beforeEach(inject(function($controller, $rootScope) {
        // Create a new scope that's a child of the $rootScope
        scope = $rootScope.$new();
        // Create the controller
        ctrl = $controller('personsShowCtrl', {
            $scope: scope
        });
    }));

    //Verify that scope values are well formed
    it('should load scope values', function() {
    });

});


