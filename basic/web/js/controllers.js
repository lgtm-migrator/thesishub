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

controllers.directive('inputStars', function () {

    var directive = {

        restrict: 'EA',
        replace: true,
        template:
        '<ul ng-class="listClass">' +
            '<li ng-mouseenter="paintStars($index)" ng-mouseleave="unpaintStars($index)" ng-repeat="item in items track by $index">' +
                '<i  ng-class="getClass($index)" ng-click="setValue($index, $event)"></i>' +
            '</li>' +
        '</ul>',
        require: 'ngModel',
        scope:true,

        link: link

    };

    return directive;

    function link (scope, element, attrs, ngModelCtrl) {

        scope.items = new Array(+attrs.max);
        
        var emptyIcon   = attrs.iconEmpty || 'fa-star-o';
        var fullIcon    = attrs.iconFull  || 'fa-star';
        //var halfIcon    = attrs.halfIcon  || 'fa-star';
        var iconBase    = attrs.iconBase  || 'fa fa-fw';
        scope.listClass = attrs.listClass || 'angular-input-stars';

        ngModelCtrl.$render = function () {

            scope.last_value = ngModelCtrl.$viewValue;
        
        };

        scope.getClass = function(index) {

            return index >= scope.last_value 
                ? iconBase + ' ' + emptyIcon 
                : iconBase + ' ' + fullIcon + ' active ';
        };

        scope.unpaintStars = function () {

            scope.paintStars( scope.last_value -1 );

        }

        scope.paintStars = function ($index) {
            
            var items = element.find('li').find('i');

            for (var index = 0 ; index < items.length ; index++) {

                var $star = angular.element(items[index]);

                if ( $index >= index ) {

                    $star.addClass(fullIcon);
                    $star.addClass('active');
                    $star.removeClass(emptyIcon);

                } else {

                    $star.removeClass(fullIcon);
                    $star.removeClass('active');
                    $star.addClass(emptyIcon);
                
                }
            }
        }

        scope.setValue = function(index, e) {

            var star = e.target;

            if (e.pageX < star.getBoundingClientRect().left + star.offsetWidth / 2) {
                    scope.last_value = index + 1;
            } else {
                    scope.last_value = index + 1;
                }

            ngModelCtrl.$setViewValue(scope.last_value);
        
        };

    }

})

controllers.controller('MainController', function ($rootScope, $scope, $location, $window) {
        $scope.loggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };

        $rootScope.getUser = function() {
            return JSON.parse($window.sessionStorage.user);
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

        $scope.goToViewThesis = function (thesis_id){ 
            $location.path('/thesis/'+ thesis_id + '/');
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

controllers.controller('DepartmentController', ['$scope', '$http', '$routeParams', '$location',
    function ($scope, $http, $routeParams, $location) {
        $http.get('api/department/?id=' + $routeParams.department_id).success(function (data) {
           $scope.department = data;
        });

        $scope.goToViewThesis = function (thesis_id){ 
            $location.path('/thesis/'+ thesis_id + '/');
        }
    }
]);


controllers.controller('LoginController', ['$scope', '$http', '$window', '$location',
    function($scope, $http, $window, $location) {
        $scope.login = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/auth/login', $scope.userModel).success(
                function (data) {
                    $window.sessionStorage.access_token = data.access_token;
                    $window.sessionStorage.user = JSON.stringify(data.user);
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

controllers.controller('ThesisController', function ($rootScope, $scope, $http, $routeParams, $location,fileUpload, $filter) {
        $http.get('api/department').success(function (data) {
           $scope.departments = data;
        });

        $http.get('api/thesis/thesis?id=' + $routeParams.thesis_id)
        .success(function (data) {
            // if ((!data || !data.detail) ) {
            //     window.location = '#/404'
            //     return;
            // }
            $scope.thesis = data;
            $scope.comments = $scope.thesis.comments;
            $scope.refs = $scope.thesis.refs;
            $scope.maps = $scope.thesis.maps;            
            $scope.reccs = data.reccs;
            $scope.rate_now;

            $scope.new_thesis = $scope.thesis.detail;
            $scope.reference = $scope.thesis.refs;
            $scope.users = $scope.thesis.users;  
            $scope.thesis_tag = $scope.thesis.tags; 
            $scope.files = $scope.thesis.files

        }).error(function() {

        });

        $http.get('api/home').success(function (data) {
           $scope.departments = data.departments;
           $scope.recent_thesis = data.recent_thesis;
           $scope.score_thesis = data.score_thesis;
        });
        $http.get('api/thesis').success(function (data) {
            $scope.users_index = data.users;
            $scope.data_thesis = data.query;
        });
        $scope.new_thesis = null;
        $scope.new_comment = {};
        $scope.thesis_tag = null;
        $scope.new_tag = null;
        $scope.thesis_inf = null;
        $scope.new_reference  = null;
        $scope.reference  = null;
        $scope.new_user  = null;
        $scope.users  = null;
        $scope.new_file  = null;
        $scope.files  = [];

        $scope.goToCreateThesis = function (){ 
            $location.path('/thesis/create');
        }

        $scope.goToViewThesis = function (thesis_id){ 
            $location.path('/thesis/'+ thesis_id + '/');
        }

        $scope.goToUpdateThesis = function (thesis_id){ 
            $location.path('/thesis/update/'+ thesis_id + '/');
                
        }
        
        $scope.saveThesis = function (thesis){    
            $http.post('/api/thesis/create',{
                                            thesis: $scope.new_thesis,
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

        $scope.updateThesis = function (thesis){   
            delete  $scope.maps['name'];
            $http.post('/api/thesis/update?id=' + $routeParams.thesis_id ,{
                                            thesis: $scope.new_thesis,
                                            thesis_tag: $scope.thesis_tag,
                                            reference: $scope.reference,
                                            files: $scope.files,
                                            users: $scope.users
                                            // users: $scope.maps
                                         }).then(function(data) {
                if (data && data.data && data.data.message == 'ok') {
                    $location.path( "/" );
                } else {
                    $scope.error = data.data.error;
                }
            });             
        }

        $scope.deleteThesis = function (thesis_id){  
            $http.post('/api/thesis/delete?id=' + thesis_id).success(function(data) {
                $location.path( "/thesis/" );
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
            $scope.users= $scope.users || [];
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
            $scope.reference = $scope.reference || [];
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
            $scope.files = $scope.files || [];
            $scope.files.push($scope.new_file);
            $scope.new_file = null;
          }
        $scope.saveComment = function (cmt){
            if($scope.new_comment.content=="")
                return;
            $scope.new_comment.thesis_id = $routeParams.thesis_id;
            $scope.new_comment.user_id = $rootScope.getUser().user_id;
            $scope.new_comment.created = new Date();
            var data = $.extend({}, $scope.new_comment);
            $http.post('/api/thesis/comment', data).then(function(data) {
                console.log(data)
                if (data && data.data && data.data.message == 'ok') {
                    $scope.new_comment = {};
                } else {
                    $scope.error = data.data.error;
                }
            });
            $scope.new_comment.username= $rootScope.getUser().username;
            $scope.new_comment.name= $rootScope.getUser().name;          
            $scope.comments.unshift($scope.new_comment);
        }

        $scope.rate_star = function(){
            $http.post('/api/thesis/rating',
              {rate_now: $scope.rate_now,
              user_id: $rootScope.getUser().user_id,
              thesis_id: $routeParams.thesis_id}).then(function(data) {
                console.log(data)
                if (data && data.data && data.data.message == 'ok') {
                    return;
                } else {
                    $scope.error = data.data.error;
                }
            });
          }
        }
);
