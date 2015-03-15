/**
 * import resource used to get import headers & send datas
 * @type {factory}
 */
angular.module('importApp').factory('importFact', [
    '$resource',
    function ($resource)
    {
        return $resource(
            globalConfig.api.urls.get_events,
            {},
            {
                get_header: {method: 'GET', url: globalConfig.api.urls.get_import_header + '/:entityLabel', params: {'entityLabel': '@entityLbl', cache: true}},
                import    : {method: 'POST', url: 'import/:entityLabel?commit=:commit', params: {'entityLabel': '@entityLbl', 'commit': '@commit'}}
            }
        );
    }
]);
