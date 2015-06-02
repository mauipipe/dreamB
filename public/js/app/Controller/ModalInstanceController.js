/**
 * Created by davidcontavalli on 31/05/15.
 */

angular.module('dream-beach')
    .controller('ModalInstanceController', ['$scope', '$modalInstance', 'beaches', 'cities', 'Upload','Helpers',
        function ($scope, $modalInstance, beaches, cities, Upload,$helpers) {

            $scope.beaches = beaches;
            $scope.cities = cities;

            $scope.$watch('picFile', function (file) {
                $scope.formUpload = false;
                if (file != null) {
                    uploadPic(file);
                }
            });


            $scope.save = function (file) {

                var comment = {
                    title: $scope.commentTitle,
                    name: $scope.name,
                    lastName: $scope.lastName,
                    beach_id: $scope.beach,
                    description: $scope.description
                }

                Upload.upload({
                    url: $helpers.getEndPoint() + '/comment',
                    fields: comment,
                    file: file
                }).success(function (data, status, headers, config) {
                    $scope.comments.push(data.entity);
                    $modalInstance.dismiss('cancel');
                });
            }

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };
        }
    ]
)
;