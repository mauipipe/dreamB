/**
 * Created by davidcontavalli on 30/05/15.
 */
'use strict';

angular.module('dream-beach')
    .controller('CommentController', ['$scope', 'CommentResource', 'CityResource', 'BeachResource', '$modal', '$rootScope','$http',
        function ($scope, $commentResource, $cityResource, $beachResource, $modal, $rootScope,$http) {

            $scope.comments = $commentResource.query();
            $scope.cities = $cityResource.query();
            $scope.beaches = $beachResource.query();
            $scope.isBeachFormActive = false;

            $scope.filterByCity = function () {
                var value = $scope.cityOption;
                $scope.comments = $commentResource.query({"city": value});
            }

            $rootScope.$on('commentSaved', function (event, comment) {
                $scope.comments.push(comment);
            });

            $scope.open = function (size) {

                var modalInstance = $modal.open({
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
                    $scope.isBeachFormActive = false
                }
            }

            $scope.saveBeach = function (beachForm) {

                var beach = {
                    name:beachForm.name,
                    city_id:beachForm.city
                }

                $http({
                    url: Config.getEndPoint() + '/beach',
                    method: "POST",
                    data: beach,
                    transformRequest: function(obj) {
                        var str = [];
                        for(var p in obj)
                            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                        return str.join("&");
                    },
                    headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
                }).success(function (data, status, headers, config) {
                    $scope.beaches.push(data.entity);
                    $scope.isBeachFormActive = false
                }).error(function (data, status, headers, config) {
                    console.log(status,headers);
                });
            }
        }
    ]);