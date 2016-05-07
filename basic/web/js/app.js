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
            })
            .when('/', {
                templateUrl: 'partials/home/index.html',
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
)