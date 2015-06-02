/**
 * Created by davidcontavalli on 31/05/15.
 */

angular.module('dream-beach')
    .factory('CityResource', ['$resource','Helpers', function ($resource,$helpers) {
        var url = $helpers.getEndPoint() + '/city';
        return $resource(url);
    }])
