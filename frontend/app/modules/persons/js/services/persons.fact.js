/**
 * Persons Factory
 *
 * Service calls for CRUD actions
 *
 * @type {factory}
 */
angular.module('personsApp').factory('personsFact', ['$resource', function ($resource)
{
  var basePath = globalConfig.api.urls.get_persons;
  var resource = $resource(
    basePath,
    {},
    {
      profile: {method: 'GET', url: globalConfig.api.urls.profile, isArray: false},
      get: {method: 'GET', url: basePath + '/:id', params: {'id': '@id', cache: true}, isArray: false},
      create: {method: 'POST', params: {}, isArray: false},
      update: {method: 'PUT', url: basePath + '/:id', params: {id: '@id'}, isArray: false},
      patch: {method: 'PATCH', url: basePath + '/:id', params: {id: '@id'}, isArray: false},
      delete: {method: 'DELETE', url: basePath + '/:id', params: {id: '@id'}, isArray: false},
      all: {method: 'GET', params: {}}
    }
  );

  //Construct a DTO object to send to server (Data Transfert Object)
  resource.serialize = function (object)
  {
    //Serialize DTO object to be sent
    var DTObject = {
      firstName: object.firstName,
      familyName: object.familyName,
      email: object.email,
      image: object.image,
      website: object.website,
      description: object.description,
      localization: object.localization ? {id: object.localization.id} : undefined,
      positions: object.positions,
      twitter: object.twitter,
      share: object.share
    };

    //create the new resource object from DTObject
    return new resource(DTObject);
  };
  return resource;
}]);
