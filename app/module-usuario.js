var app = angular.module('ZeitGeistModule')

    .controller('UsuarioCtrl', ['$scope', '$http', '$routeParams', '$location', function($scope, $http, $routeParams, $location) {
        $scope.usuario = {};
        $scope.isEdit = false;

        if ($routeParams.codUsuario && $routeParams.codUsuario != 0) {
			$scope.isEdit = true;
            getUsuario($routeParams.codUsuario);
        } else {
            getListUsuario();
        }

        getListPerfil();

		if($scope.hasError)
			toastr.error($scope.msg);

        $scope.save = function() {
            if($routeParams.codUsuario == 0) {
                insertUsuario();
            } else {
                updateUsuario();
            }
        };

        function getUsuario(codUsuario) {
            $http.get('api/usuario/get/' + codUsuario).then(function (response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function getListUsuario() {
            $http.get('api/usuario/list/').then(function (response) {
                var result = response.data;
                $scope.usuarioList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function insertUsuario() {
            $http.post('api/usuario/insert/', $scope.usuario).then(function (response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				if(!$scope.hasError)
					toastr.success(result.msg);

                $location.path('usuario/' + $scope.usuario.codUsuario);
            });
        }

        function updateUsuario() {
            $http.post('api/usuario/update/', $scope.usuario).then(function (response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				if(!$scope.hasError)
					toastr.success(result.msg);
            });
        }

        function getListPerfil() {
            $http.get('api/perfil/list/').then(function (response) {
                var result = response.data;
                $scope.perfilList = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;
            });
        }
    }]);