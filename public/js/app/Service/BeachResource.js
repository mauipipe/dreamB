/**
 * Created by davidcontavalli on 31/05/15.
 */

angular.module('dream-beach')
    .factory('BeachResource', ['$resource','$http', 'Helpers', function ($resource,$http, $helpers) {
        var url = $helpers.getEndPoint() + '/beach';
        return {
            getBeaches: function () {
                return $resource(url);
            }
        };
    }])
