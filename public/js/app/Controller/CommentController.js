/**
 * Created by davidcontavalli on 30/05/15.
 */
'use strict';

angular.module('dream-beach')
    .controller('CommentController', ['$scope', 'CommentResource', 'CityResource', 'BeachResource', '$modal', '$rootScope', 'Helpers',
        function ($scope, $commentResource, $cityResource, $beachResource, $modal, $rootScope, $helpers) {

            $scope.comments = $commentResource.query();
            $scope.cities = $cityResource.query();
            $scope.beaches = $beachResource.getBeaches().query();
            $scope.isBeachFormActive = false;

            $helpers.getEndPoint();

            $scope.filterByCity = function () {
                var value = $scope.cityOption;
                $scope.comments = $commentResource.query({"city": value});
            }

            $rootScope.$on('commentSaved', function (event, comment) {
                $scope.comments.push(comment);
            });

            $scope.open = function (size) {
                $modal.open({
                    animation: $scope.animationsEnabled,
                    templateUrl: 'commentForm.html',
                    controller: 'ModalInstanceController',
                    size: size,
                    scope: $scope,
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

            $scope.toggleBeachForm = function () {
                if ($scope.isBeachFormActive === false) {
                    $scope.isBeachFormActive = true;
                } else {
                    $scope.isBeachFormActive = false;
                }
            }

            $scope.saveBeach = function (beachForm) {

                if(typeof  beachForm.beachName === "undefined"){
                    return;
                }
                var beach = {
                    name: beachForm.beachName,
                    city_id: beachForm.city
                };

               $beachResource.saveBeach(beach).success(function (data, status, headers, config) {
                    $scope.beaches.push(data.entity);
                    $scope.isBeachFormActive = false
                }).error(function (data, status, headers, config) {
                    console.log(status, headers);
                });
            };
        }
    ]);