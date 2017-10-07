var app = angular.module('ZeitGeistModule')

    .controller('UsuarioCtrl', ['$scope', '$http', '$routeParams', '$location', function($scope, $http, $routeParams, $location) {

        $scope.init = function() {
            $(document).ready(function() {
                $('#senha').mask('00000000');
                $('#confirmacaoSenha').mask('00000000');
            });
        }


        $scope.usuario = {};
        $scope.isEdit = false;

        if ($routeParams.idUsuario && $routeParams.idUsuario != 0) {
            $scope.isEdit = true;
            getUsuario($routeParams.idUsuario);
        }
        else {
            getListUsuario();
        }

        if ($scope.hasError)
            alert($scope.msg);

        $scope.save = function() {
            if ($routeParams.idUsuario == 0) {
                insertUsuario();
            }
            else {
                updateUsuario();
            }
        };

        function getUsuario(idUsuario) {
            $http.get('api/usuario/get/' + idUsuario).then(function(response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function getListUsuario() {
            $http.get('api/usuario/list/').then(function(response) {
                var result = response.data;
                $scope.usuarioList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function insertUsuario() {
            $http.post('api/usuario/insert/', $scope.usuario).then(function(response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!$scope.hasError)
                    alert(result.msg);

                $location.path('usuario/' + $scope.usuario.idUsuario);
            });
        }

        function updateUsuario() {
            $http.post('api/usuario/update/', $scope.usuario).then(function(response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!$scope.hasError)
                    alert(result.msg);
            });
        }

        function getListPerfil() {
            $http.get('api/perfil/list/').then(function(response) {
                var result = response.data;
                $scope.perfilList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }
    }]);
