var app = angular.module('ZeitGeistModule')

    .controller('UsuarioCtrl', ['$scope', '$http', '$routeParams', '$location', '$rootScope', function($scope, $http, $routeParams, $location, $rootScope) {

        $scope.init = function() {
            $(document).ready(function() {
                $('#senha').mask('AAAAAAAA');
                $('#confirmacaoSenha').mask('AAAAAAAA');
            });
        };

        $scope.usuario = {};
        $scope.isEdit = false;

        if ($routeParams.idUsuario && $routeParams.idUsuario != 0) {
            $scope.isEdit = true;
            getUsuario($routeParams.idUsuario);
        } else {
            getListUsuario();
        }

        if ($scope.hasError)
			toastr.error($scope.msg, { positionClass: "toast-top-center"});

        $scope.save = function() {
            if ($routeParams.idUsuario == 0) {
                insertUsuario();
            }
            else {
                updateUsuario();
            }
        };

        $scope.changeStatus = function(usuario, status) {
        	var msg = "Tem certeza que deseja inativar este usuário?";

			if (status == 0) {
				msg = "Tem certeza que deseja ativar este usuário?";
			}

        	if (confirm(msg)) {
				changeStatusUsuario(usuario, status);
				getListUsuario();
			}
		};

        function getUsuario(idUsuario) {
			$rootScope.loading = true;

			$http.get('api/usuario/get/' + idUsuario).then(function(response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				$rootScope.loading = false;
			});
        }

        function getListUsuario() {
			$rootScope.loading = true;

			$http.get('api/usuario/list/').then(function(response) {
                var result = response.data;
                $scope.usuarioList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				$rootScope.loading = false;
			});
        }

        function insertUsuario() {
            
            if($scope.usuario.senhaUsuario != $scope.usuario.confirmacaoSenha){
				toastr.error("As senhas devem ser iguais!", { positionClass: "toast-top-center"});
				return;
            }

			$rootScope.loading = true;

			$http.post('api/usuario/insert/', $scope.usuario).then(function(response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				$rootScope.loading = false;

				if (!$scope.hasError)
					toastr.success($scope.msg, { positionClass: "toast-top-center"});

                $location.path('usuario/' + $scope.usuario.idUsuario);
            });
        }

        function updateUsuario() {
            
            if($scope.usuario.senhaUsuario != $scope.usuario.confirmacaoSenha){
				toastr.error("As senhas devem ser iguais!", { positionClass: "toast-top-center"});
                return;
            }

			$rootScope.loading = true;

			$http.post('api/usuario/update/', $scope.usuario).then(function(response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				$rootScope.loading = false;

				if (!$scope.hasError)
					toastr.success($scope.msg, { positionClass: "toast-top-center"});
            });
        }

        function changeStatusUsuario(usuario, status) {
			$rootScope.loading = true;
			var action = (status == 1) ? "inactivate" : "activate";

			$http.post('api/usuario/' + action + '/', usuario).then(function(response) {
				var result = response.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;

				$rootScope.loading = false;

				if (!$scope.hasError)
					toastr.success($scope.msg, { positionClass: "toast-top-center"});
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
