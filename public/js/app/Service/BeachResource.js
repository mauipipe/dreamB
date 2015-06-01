/**
 * Created by davidcontavalli on 31/05/15.
 */

angular.module('dream-beach')
    .factory('BeachResource', ['$resource', function ($resource) {
        var url = Config.getEndPoint() + '/beach';
        return $resource(url);
    }])
