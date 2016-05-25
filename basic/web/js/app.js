var app = angular.module('app', [
    'ngRoute',          //$routeProvider
    'mgcrea.ngStrap',   //bs-navbar, data-match-route directives
    'controllers'       //Our module app/web/js/controllers.js
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
            .when('/thesis/create', {
              templateUrl: 'partials/thesis/creata_thesis.html',
              controller: 'ThesisController'
            })
            .when('/thesis/:thesis_id?', {
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
    templateUrl: 'partials/home/recent_side.html'
    };
});