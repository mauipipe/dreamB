/**
 * Created by davidcontavalli on 30/05/15.
 */
'use strict';

angular.module('dream-beach')
    .factory('CommentResource', ['$resource', function ($resource) {
        var url = Config.getEndPoint() + '/comment';
        return $resource(url,{city : '@city'});
    }])


