var controllers = angular.module('controllers', []);

controllers.controller('ThesisController', function ($scope, $http, $routeParams, $location) {
        $http.get('api/department').success(function (data) {
           $scope.departments = data;
        });

        $http.get('api/thesis/thesis?id=' + $routeParams.thesis_id).success(function (data) {
            $scope.thesis = data;
        });

        $scope.new_thesis = null;
        $scope.thesis_tag = null;
        $scope.saveThesis = function (thesis){
            $http.post('/api/thesis/create', $scope.new_thesis).then(function(data) {
                console.log(data)

                if (data && data.data && data.data.message == 'ok') {
                    $location.path( "/" );
                } else {
                    $scope.error = data.data.error;
                }
            });
        }
    }
);