/**
 * Created by davidcontavalli on 31/05/15.
 */

angular.module('dream-beach')
    .factory('CityResource', ['$resource', function ($resource) {
        var url = Config.getEndPoint() + '/city';
        return $resource(url);
    }])
