/**
 * Created by davidcontavalli on 31/05/15.
 */

angular.module('dream-beach')
    .factory('BeachResource', ['$resource','$http', 'Helpers', function ($resource,$http, $helpers) {
        var url = $helpers.getEndPoint() + '/beach';
        return {
            getBeaches: function () {
                return $resource(url);
            },
            saveBeach: function (beach) {
                return $http({
                    url: url,
                    method: "POST",
                    data: beach,
                    transformRequest: function (obj) {
                        var str = [];
                        for (var p in obj)
                            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                        return str.join("&");
                    },
                    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                });
            }
        };
    }])
