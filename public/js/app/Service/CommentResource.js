/**
 * Created by davidcontavalli on 30/05/15.
 */
'use strict';

angular.module('dream-beach')
    .factory('CommentResource', ['$resource','Helpers', function ($resource,$helpers) {
        var url = $helpers.getEndPoint() + '/comment';
        return $resource(url,{city : '@city'});
    }])


