/**
 * Created by davidcontavalli on 30/05/15.
 */
'use strict';

angular.module('dream-beach')
    .controller('CommentController', ['$scope', 'CommentResource', 'CityResource', 'BeachResource', '$modal','$rootScope',
        function ($scope, $commentResource, $cityResource, $beachResource, $modal,$rootScope) {

            $scope.comments = $commentResource.query();
            $scope.cities = $cityResource.query();
            $scope.beaches = $beachResource.query();

            $scope.filterByCity = function () {
                var value = $scope.cityOption;
                $scope.comments = $commentResource.query({"city": value});
            }

            $rootScope.$on('commentSaved',function(event,comment){
                alert('boom');
               $scope.comments.push(comment);
            });

            $scope.open = function (size) {

                var modalInstance = $modal.open({
                    animation: $scope.animationsEnabled,
                    templateUrl: 'commentForm.html',
                    controller: 'ModalInstanceController',
                    size: size,
                    scope:$scope,
                    resolve: {
                        cities: function () {
                            return $scope.cities;
                        },
                        beaches: function () {
                            return $scope.beaches;
                        }
                    }
                });
            };
        }
    ]);