var controllers = angular.module('controllers', []);

controllers.controller('MainController', function ($scope, $location, $window) {
        $scope.loggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };
        $scope.logout = function () {
            delete $window.sessionStorage.access_token;
            $location.path('/login').replace();
        };
    }
);

controllers.controller('HomeController', ['$scope', '$http', '$location',
    function ($scope, $http, $location) {
        $http.get('api/home').success(function (data) {
           $scope.departments = data.departments;
        });

        $scope.goToListThesisDepartment = function(thesis_department) {
            if (thesis_department) {
              $location.path('/department/' + thesis_department.department_id);
            }
        }
    }

]);

controllers.controller('DashboardController', ['$scope', '$http',
    function ($scope, $http) {
        $http.get('api/dashboard').success(function (data) {
           $scope.dashboard = data;
        });

        $http.get('api/home').success(function (data) {
           $scope.departments = data;
        });
    }
]);

controllers.controller('DepartmentController', ['$scope', '$http', '$routeParams',
    function ($scope, $http, $routeParams) {
        $http.get('api/department/?id=' + $routeParams.department_id).success(function (data) {
           $scope.department = data;
        });


    }
]);

controllers.controller('ThesisController', function ($scope, $http, $routeParams, $location) {
        $http.get('api/department').success(function (data) {
           $scope.departments = data;
        });
        $scope.new_thesis = null;
        $scope.saveThesis = function (thesis){
            $http.post('/api/thesis/create', $scope.new_thesis).then(function(data) {
                console.log(data)

                if (data && data.data && data.data.message == 'ok') {
                    $location.path( "/" );
                } else {
                    $scope.error = data.data.error;
                }
            });

           // $scope.new_thesis = null; 
        }
    }
);


controllers.controller('LoginController', ['$scope', '$http', '$window', '$location',
    function($scope, $http, $window, $location) {
        $scope.login = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/auth/login', $scope.userModel).success(
                function (data) {
                    $window.sessionStorage.access_token = data.access_token;
                    $location.path('/dashboard').replace();
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };
    }
]);

controllers.controller('ContactController', ['$scope', '$http', '$window',
    function($scope, $http, $window) {
        $scope.captchaUrl = 'site/captcha';
        $scope.contact = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/pages/contact', $scope.contactModel).success(
                function (data) {
                    $scope.contactModel = {};
                    $scope.flash = data.flash;
                    $window.scrollTo(0,0);
                    $scope.submitted = false;
                    $scope.captchaUrl = 'site/captcha' + '?' + new Date().getTime();
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };

        $scope.refreshCaptcha = function() {
            $http.get('site/captcha?refresh=1').success(function(data) {
                $scope.captchaUrl = data.url;
            });
        };
    }]);