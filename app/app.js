angular.module('ZeitGeistModule', ['ngRoute', ]);
angular.module('ZeitGeistService', []);

var app = angular.module('ZeitGeist', [
    'ngRoute',
    'ngSanitize',
    'ngCookies',
    'ZeitGeistModule',
    'ZeitGeistService',
    'ui.mask'
]);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider

        .when('/', {
            templateUrl: 'view/home.html',
            controller: 'HomeCtrl'
        })

        .when('/home', {
            templateUrl: 'view/home.html',
            controller: 'HomeCtrl'
        })

        .when('/usuario', {
            templateUrl: 'view/usuario-list.html',
            controller: 'UsuarioCtrl'
        })

        .when('/usuario/:idUsuario', {
            templateUrl: 'view/usuario-edit.html',
            controller: 'UsuarioCtrl'
        })

        .when('/jornal/', {
            templateUrl: 'view/jornal-list.html',
            controller: 'JornalCtrl'
        })

        .when('/pagina/', {
            templateUrl: 'view/pagina-edit.html',
            controller: 'PaginaCtrl'
        })

        .when('/login', {})
        .otherwise({ templateUrl: 'view/page-404.html' });

    $locationProvider.html5Mode(true);
}]);

app.run(['$rootScope', '$location', '$cookies', '$http', function($rootScope, $location, $cookies, $http) {
    $rootScope.globals = $cookies.getObject('globals') || {};

    if ($rootScope.globals.currentUser) {
        $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
    }

    // $rootScope.$on('$locationChangeStart', function () {
    //     if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
    //         window.location = 'login';
    //     }
    // });
}]);

app.controller('MainCtrl', ['$scope', '$location', 'AuthenticationService', function($scope, $location, AuthenticationService) {
    $scope.logout = function() {
        AuthenticationService.ClearCredentials();
        window.location = 'login';
    };

    $scope.go = function(path) {
        $location.path(path);
    };
}]);
