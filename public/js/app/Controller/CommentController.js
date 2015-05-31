/**
 * Created by davidcontavalli on 30/05/15.
 */
'use strict';

angular.module('dream-beach')
    .controller('CommentController', ['$scope', 'CommentResource','CityResource',
        function ($scope, commentResource, cityResource) {
            $scope.comments = commentResource.query();
            $scope.cities = cityResource.query();

            $scope.filterByCity = function(){
                var value = $scope.cityOption;
                $scope.comments = commentResource.query({"city":value});
            }

        }
    ]);