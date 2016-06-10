var app = angular.module('app', [
    'ngRoute',          //$routeProvider
    'mgcrea.ngStrap',   //bs-navbar, data-match-route directives
    'controllers',       //Our module app/web/js/controllers.js
    'bw.paging'
]);

app.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('', {
                templateUrl: 'partials/home/index.html',
                controller: 'HomeController'
            })
            .when('/', {
                templateUrl: 'partials/home/index.html',
                controller: 'HomeController'
            })
            .when('/about', {
                templateUrl: 'partials/pages/about.html'
            })
            .when('/contact', {
                templateUrl: 'partials/pages/contact.html',
                controller: 'ContactController'
            })
            .when('/login', {
                templateUrl: 'partials/auth/login.html',
                controller: 'LoginController'
            })
            .when('/dashboard', {
                templateUrl: 'partials/home/dashboard.html',
                controller: 'DashboardController'
            })
            .when('/department/:department_id?', {
              templateUrl: 'partials/department/department.html',
              controller: 'DepartmentController'
            })
            .when('/search', {
              templateUrl: 'partials/home/search.html',
              controller: 'SearchController'
            })
            .when('/thesis', {
              templateUrl: 'partials/thesis/thesis.html',
              controller: 'ThesisController'
            })
            .when('/thesis/create', {
              templateUrl: 'partials/thesis/create_thesis.html',
              controller: 'ThesisController'
            })
            .when('/thesis/update/:thesis_id?', {
              templateUrl: 'partials/thesis/update_thesis.html',
              controller: 'ThesisController'
            })
            .when('/thesis/:thesis_id?', {
                templateUrl: 'partials/thesis/show.html',
                controller: 'ThesisDetailController'
            })
            .when('/404', {
                templateUrl: 'partials/pages/404.html'
            })
            
            // Static page
            .when('/pages/', {
                templateUrl: 'partials/thesis/show.html',
                controller: 'ThesisController'
            })
            

            .otherwise({
                templateUrl: 'partials/pages/404.html'
            });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

app.factory('authInterceptor', function ($q, $window, $location) {
    return {
        request: function (config) {
            if ($window.sessionStorage.access_token) {
                // HttpBearerAuth
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
            }
            return config;
        },
        responseError: function (rejection) {
            if (rejection.status === 401) {
                $location.path('/login').replace();
            }
            return $q.reject(rejection);
        }
    };
});

app.run(['$rootScope', 
    function ($rootScope) {
    	$rootScope.pageTitle = 'Thesis Hub';
    }
  ]
);

app.directive("recentSide", function(){
    return {
        restrict: 'E',
        scope: false,
        templateUrl: 'partials/home/recent_side.html',
        controller: function($http, $scope) {
            // console.log('Load recentSide');
            $http.get('api/home').success(function (data) {
               $scope.departments = data.departments;
               $scope.recent_thesis = data.recent_thesis;
               $scope.score_thesis = data.score_thesis;
            });
        }
    };
});

app.directive("recommend", function(){
    return {
    restrict: 'E',
    scope: false,
    templateUrl: 'partials/thesis/recommend.html'
    };
});

app.directive("comment", function(){
    return {
    restrict: 'E',
    scope: false,
    templateUrl: 'partials/thesis/comment.html'
    };
});

app.directive("previewPDF", function() {
    return {
    restrict: 'E',
    scope: false,
    templateUrl: 'partials/thesis/previewPDF.html'
    };
});