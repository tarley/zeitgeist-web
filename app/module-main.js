var app = angular.module('ZeitGeistModule')

    .controller('LoginCtrl', ['$scope', '$rootScope', '$location', '$http', 'AuthenticationService', function ($scope, $rootScope, $location, $http, AuthenticationService){
        $scope.usuario = {};
        $scope.hasError = false;
        $scope.msg = "";
        
        $scope.login = function() {
            login();
        }

        function login() {
            AuthenticationService.ClearCredentials();
            AuthenticationService.Login($scope.usuario.login, $scope.usuario.senha, function(response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!result.hasError) {
                    AuthenticationService.SetCredentials(result.data.id_usuario, $scope.usuario.login, $scope.usuario.senha, result.data.id_perfil_usuario);
                    window.location = "/";
                }
            });
        }
    }])

    .controller('HomeCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.page = "Home";
    }]);