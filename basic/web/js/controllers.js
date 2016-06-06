var controllers = angular.module('controllers', []);


controllers.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

controllers.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl, callback){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(response) {
            console.log()
            callback(response)
        })
        .error(function(response){
            callback(response)
        });
    }
}]);

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
           $scope.recent_thesis = data.recent_thesis;
           $scope.score_thesis = data.score_thesis;
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

controllers.controller('ThesisController', function ($scope, $http, $routeParams, $location, fileUpload) {
        $http.get('api/department').success(function (data) {
           $scope.departments = data;
        });

        $http.get('api/thesis/thesis?id=' + $routeParams.thesis_id).success(function (data) {
            $scope.thesis = data;
            $scope.comments = $scope.thesis.comments;
            $scope.refs = $scope.thesis.refs;
            $scope.maps = $scope.thesis.maps;            
            $scope.reccs = data.reccs;        
        });

        $http.get('api/home').success(function (data) {
           $scope.departments = data.departments;
           $scope.recent_thesis = data.recent_thesis;
           $scope.score_thesis = data.score_thesis;
        });

        $http.get('api/thesis').success(function (data) {
            $scope.users_index = data.users;
        });

        $scope.new_thesis =  null;
        $scope.thesis_tag = null;
        $scope.new_tag = null;
        $scope.thesis_inf = null;
        $scope.new_reference  = null;
        $scope.reference  = null;
        $scope.new_user  = null;
        $scope.users  = null;
        $scope.new_file  = null;
        $scope.files  = [];

        $scope.saveThesis = function (thesis){            


            
            $http.post('/api/thesis/create',{thesis: $scope.new_thesis,
                                            thesis_tag: $scope.thesis_tag,
                                            reference: $scope.reference,
                                            files: $scope.files,
                                            users: $scope.users
                                         }).then(function(data) {
                if (data && data.data && data.data.message == 'ok') {
                    $location.path( "/" );
                } else {
                    $scope.error = data.data.error;
                }
            });
        }

        $scope.removeUser = function (index) {    
            $scope.users.splice(index, 1);  
        }

        $scope.initNewUser = function () {
            
            $scope.new_user = {};
            if($scope.new_user){
                $scope.saveUser();
            }
        }
       
        $scope.saveUser = function () {
          
            $scope.users=
                $scope.users || [];

            $scope.users.push($scope.new_user);
            

            $scope.new_user = null;
          }

        $scope.removeTag = function (index) {   
            $scope.thesis_tag.splice(index, 1);  
        }

        
        $scope.initNewTag = function () {
            
            $scope.new_thesis_tag = {};
            if($scope.new_thesis_tag){
                $scope.saveTag();
            }
        }
       
        $scope.saveTag = function () {
          
            $scope.thesis_tag=
                $scope.thesis_tag || [];

            $scope.thesis_tag.push($scope.new_thesis_tag);
            

            $scope.new_thesis_tag = null;
        }

        $scope.removeReference = function (index) {    
            $scope.reference.splice(index, 1);  
        }

        
        $scope.initNewReference = function () {
            
            $scope.new_reference = {};
            if($scope.new_reference){
                $scope.saveReference();
            }
        }
       
        $scope.saveReference = function () {
          
            $scope.reference =
                $scope.reference || [];

            $scope.reference.push($scope.new_reference);
            

            $scope.new_reference = null;
        }


        $scope.uploadFile = function() {
            console.log('file is ', $scope.myFile);
            var uploadUrl = "/upload";
            var cb = function(response) {
                if (response.error == false) {
                    $scope.files.push(response.data)
                }
                else {
                    alert('Upload fail, please try again later.')
                }
            }

            fileUpload.uploadFileToUrl($scope.myFile, uploadUrl, cb);
        };

        
        $scope.$watch( 'myFile', function(newValue, oldValue) {
            if (newValue) $scope.uploadFile();
        })

        $scope.removeFile = function (index) {    
            $scope.files.splice(index, 1);  
        }

        
        $scope.initNewFile = function () {
            
            $scope.new_file = {};
            if($scope.new_file){
                $scope.saveFile ();
            }
        }
       
        $scope.saveFile = function () {
          
            $scope.files =
                $scope.files || [];

            $scope.files.push($scope.new_file);
            

            $scope.new_file = null;
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