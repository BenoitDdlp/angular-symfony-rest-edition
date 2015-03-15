/**
 * Organizations Factory
 *
 * Service calls for CRUD actions
 *
 * @type {factory}
 */
angular.module('organizationsApp').factory('organizationsFact',
    ['$resource', '$routeParams', function ($resource, $routeParams)
    {
        var resource = $resource(
            globalConfig.api.urls.get_organizations,
            {},
            {
                get            : {method: 'GET', url: globalConfig.api.urls.get_organizations + '/:id', params: {'id': '@id', cache: true}, isArray: false},
                create         : {method: 'POST', params: {}, isArray: false},
                update         : {method: 'PUT', url: globalConfig.api.urls.get_organizations + '/:id', params: {id: '@id'}, isArray: false},
                delete         : {method: 'DELETE', url: globalConfig.api.urls.get_organizations + '/:id', params: {id: '@id'}, isArray: false},
                all            : {method: 'GET', params: {}, isArray: false}
            }
        );

        //Construct a DTO object to send to server (Data Transfert Object)
        resource.serialize = function (object)
        {
            //Serialize DTO object to be sent
            var DTObject = {
                image       : object.image,
                label       : object.label,
                website     : object.website,
                localization: object.localization ? {id: object.localization.id} : undefined,
                description : object.description
            };

            //create the new resource object from DTObject
            return new resource(DTObject);
        };

        return resource;
    }]);
