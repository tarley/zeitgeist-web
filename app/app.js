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

        .when('/usuario', {
            templateUrl: '/view/usuario-list.html',
            controller: 'UsuarioCtrl',
            admin: true
        })

        .when('/usuario/:idUsuario', {
            templateUrl: '/view/usuario-edit.html',
            controller: 'UsuarioCtrl',
            admin: true
        })

        .when('/', {
            templateUrl: '/view/jornal-list.html',
            controller: 'JornalCtrl'
        })

        .when('/jornal-view/:codJornal', {
            templateUrl: '/view/jornal-view.html',
            controller: 'PaginaPreviewCtrl'
        })

        .when('/jornal/:codJornal', {
            templateUrl: '/view/jornal-edit.html',
            controller: 'JornalCtrl'
        })

        .when('/pagina/:codJornal', {
            templateUrl: '/view/pagina-edit.html',
            controller: 'PaginaCtrl'
        })

        .when('/team', {
            templateUrl: '/team.html',
            controller: 'MainCtrl'
        })

        .when('/contato', {
            templateUrl: '/contato.php',
            controller: 'MainCtrl'
        })
        .when('/login', {
            templateUrl: '/view/login.html',
            controller: 'MainCtrl',
            open: true
        })
        .when('/page-404', {
            templateUrl: '/view/page-404.html'
        })
        .otherwise({
            redirectTo: "/login.html"
        });

    $locationProvider.html5Mode(false);
}]);

app.run(['$rootScope', '$location', '$cookies', '$http', function($rootScope, $location, $cookies, $http) {
    $rootScope.globals = $cookies.getObject('globals') || {};

    if ($rootScope.globals.currentUser) {
        $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
    }

    $rootScope.$on('$routeChangeStart', function(event, next, current) {
        
        instance = next.__proto__;
        
        if(!instance.open) {
            if (!$rootScope.globals.currentUser) {
                $location.path('/login');
            } else if (instance.admin && $rootScope.globals.currentUser.role != '1') {
                $location.path('/');
            }
        }
    });
}]);

app.controller('MainCtrl', ['$scope', '$location', 'AuthenticationService', function($scope, $location, AuthenticationService) {
    $scope.logout = function() {
        AuthenticationService.ClearCredentials();
        $location.path('/login');
    };

    $scope.go = function(path) {
        $location.path(path);
    };
}]);
