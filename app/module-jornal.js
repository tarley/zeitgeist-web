var app = angular.module('ZeitGeistModule')

    .controller('JornalCtrl', function($scope, $http, $routeParams, $location, $rootScope) {

        $scope.init = function() {
            $(document).ready(function() {
                $('#publicacao').mask('00/00/0000');
            });

            $scope.jornal = {};
            $scope.isEdit = false;
            
            if ($routeParams.codJornal && $routeParams.codJornal != 0) {
                $scope.isEdit = true;
                getJornal($routeParams.codJornal);
                getListPagina();
            } else {
				$http.get('api/jornal/getUltimaEdicao/').then(function(response) {
					var result = response.data;
					$scope.jornal = result.data;
					$scope.jornal.idSituacao = 1;
				});
			}
        };

        $scope.initList = function() {
            $scope.jornal = {};
            getListEdicoes();
        };

        if ($scope.hasError)
			toastr.error($scope.msg, { positionClass: "toast-top-center"});

        $scope.save = function() {
            if ($routeParams.codJornal == 0) {
                insertJornal();
            } else {
                updateJornal();
            }
        };

		$scope.excluirJornal = function (idJornal) {
			if (confirm("Tem certeza que deseja excluir este jornal")) {
				$rootScope.loading = true;

				$http.post('api/jornal/delete/',{ idJornal: idJornal }).then(function(response) {
					var result = response.data;
					$scope.hasError = result.hasError;
					$scope.msg = result.msg;

					$rootScope.loading = false;

					if (!$scope.hasError) {
						$scope.jornalList = $scope.jornalList.filter(function (jornal) {
							return jornal.idJornal != idJornal;
						});
						toastr.success($scope.msg, { positionClass: "toast-top-center"});
					} else {
						toastr.error($scope.msg, { positionClass: "toast-top-center"});
					}
				});
			}
		};

		$scope.goJornal = function(idJornal) {
			$location.path("jornal/" + idJornal);
		};

		$scope.goPagina = function() {
			$location.path('/jornal/' + $scope.jornal.idJornal + '/pagina/0');
		};

		$scope.subirPagina = function(idPagina){
			$http.get('api/jornal/subirPagina/' + idPagina).then(function(response) {
				var result = response.data;
				$scope.paginaList = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;
			});
		};

		$scope.descerPagina = function(idPagina){
			$http.get('api/jornal/descerPagina/' + idPagina).then(function(response) {
				var result = response.data;
				$scope.paginaList = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;
			});
		};

		$scope.publicarJornal = function(idJornal){
			$http.get('api/jornal/publicarJornal/' + idJornal).then(function(response) {
				var result = response.data;
				$scope.jornalList = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;
			});
		};

		$scope.excluirPagina = function (pagina) {
			if (confirm("Tem certeza que deseja excluir esta página?")) {
				$rootScope.loading = true;

				$http.post('api/pagina/delete/', pagina).then(function(response) {
					var result = response.data;
					$scope.hasError = result.hasError;
					$scope.msg = result.msg;

					$rootScope.loading = false;

					if (!$scope.hasError) {
						$scope.paginaList = result.data;
						toastr.success($scope.msg, { positionClass: "toast-top-center"});
					} else {
						toastr.error($scope.msg, { positionClass: "toast-top-center"});
					}
				});
			}
		};

		$scope.DropDownChanged = function() {
			$scope.DropDownStatus = $scope.ZeitGeistModule;
			getListEdicoes($scope.DropDownStatus);
		};

        function getJornal(codJornal) {
			$rootScope.loading = true;
            $http.get('api/jornal/get/' + codJornal).then(function(response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
				$rootScope.loading = false;
            });
        }

		function getListEdicoes(codStatus) {
			$rootScope.loading = true;

			if (codStatus != undefined) {
				$http.get('api/jornal/list/' + codStatus).then(function(response) {
					var result = response.data;
					$scope.jornalList = result.data;
					$scope.hasError = result.hasError;
					$scope.msg = result.msg;
					$rootScope.loading = false;
				});
			}
			else {
				$http.get('api/jornal/list/').then(function(response) {
					var result = response.data;
					$scope.jornalList = result.data;
					$scope.hasError = result.hasError;
					$scope.msg = result.msg;
					$rootScope.loading = false;
				});
			}
		}

        function getListPagina() {
            $http.get('api/pagina/list/' + $routeParams.codJornal).then(function(response) {
                var result = response.data;
                $scope.paginaList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function insertJornal() {
			$rootScope.loading = true;

            $scope.jornal.idSituacao = 1; //rascunho
            $scope.jornal.idUsuario = $rootScope.globals.currentUser.id;
            $http.post('api/jornal/insert/', $scope.jornal).then(function(response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				$rootScope.loading = false;

				if (!$scope.hasError)
					toastr.success($scope.msg, { positionClass: "toast-top-center"});

                $location.path('jornal/' + $scope.jornal.idJornal);
            });
        }

        function updateJornal() {
			$rootScope.loading = true;

            $http.post('api/jornal/update/', $scope.jornal).then(function(response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

				$rootScope.loading = false;

				if (!$scope.hasError)
					toastr.success($scope.msg, { positionClass: "toast-top-center"});
            });
        }
    });
