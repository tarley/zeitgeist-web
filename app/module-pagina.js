var app = angular.module('ZeitGeistModule')

    .controller('PaginaCtrl', function($scope, $http, $routeParams, $location, $window) {
        $scope.pagina = {};
        $scope.templateList = [];
		$scope.selectedTemplate = {};

        if ($scope.hasError)
            toastr.error($scope.msg);

        if ($routeParams.codPagina && $routeParams.codPagina != 0) {
            getPagina($routeParams.codPagina);
        }

        getTemplateList();

		$scope.selectTemplate = function(template) {
			$scope.selectedTemplate = template;

		};

		function getPagina(idPagina) {
			$http.get('api/pagina/get/' + idPagina).then(function(response) {
				var result = response.data;
				$scope.pagina = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;
				Materialize.updateTextFields();
			});
		}

		function getTemplateList() {
			$http.get('api/template/list/').then(function(response) {
				var result = response.data;
				$scope.templateList = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;
			});
		}

		$scope.voltar = function() {
			$scope.go('jornal/' + $scope.pagina.idJornal);
		};

		//=============================

        $scope.save = function() {
            var templateSelecionado = $scope.currentTab;

            $scope.pagina.idTemplate = templateSelecionado;
            $scope.pagina.idJornal = $routeParams.codJornal;

            $http.post('api/pagina/insert/', $scope.pagina).then(function(response) {
                var resultPagina = response.data;

                $scope.pagina = resultPagina.data;
                var idPagina = $scope.pagina.idPagina;
                                
                $scope.dadosTemplate = {};
                $http.get('api/dadosTemplate/list/' + templateSelecionado).then(function(response) {
                    var resultDadosTemplate = response.data;
                    $scope.dadosTemplate = resultDadosTemplate.data;
                    $scope.hasError = resultDadosTemplate.hasError;
                    $scope.msg = resultDadosTemplate.msg;


                    if (!$scope.hasError) {
                        for (var i = 0; i < $scope.dadosTemplate.length; i++) {

                            $scope.paginaDado = {
                                idPaginaDado: null,
                                idPagina: idPagina,
                                idJornal: $routeParams.codJornal,
                                idTemplateDado: $scope.dadosTemplate[i].idTemplateDado
                            };
                            
                            var idPaginaDado;
                            
                            $http.post('api/paginaDado/insert/', $scope.paginaDado).then(function(response) {
                                var resultPaginaDado = response.data;

                                $scope.paginaDado = resultPaginaDado.data;
                                idPaginaDado = $scope.paginaDado.idPaginaDado;
                            });

                            if ($scope.dadosTemplate[i].idTipoTemplateDado == 1) {
                                var string = $("input[id*='" + $scope.dadosTemplate[i].chaveTemplateDado + "']").val();

                                alert(idPaginaDado); //undefined
                                $scope.paginaString = {
                                    idPaginaDado: idPaginaDado,
                                    valorPaginaString: string
                                };

                                $http.post('api/paginaString/insert/', $scope.paginaString).then(function(response) {
                                    var resultPaginaString = response.data;
                                });
                            }
                            else if ($scope.dadosTemplate[i].idTipoTemplateDado == 2) {
                                var textArea = $("textarea[id*='" + $scope.dadosTemplate[i].chaveTemplateDado + "']").val();

                                $scope.paginaTexto = {
                                    idPaginaDado: idPaginaDado,
                                    valorPaginaTexto: textArea
                                };

                                $http.post('api/paginaTexto/insert/', $scope.paginaTexto).then(function(response) {
                                    var resultPaginaTexto = response.data;
                                });
                            }
                            else if ($scope.dadosTemplate[i].idTipoTemplateDado == 3) {

                            }
                        }
                    }
                });
            });
        };



        function getListPagina() {
            $http.get('api/pagina/list/').then(function(response) {
                var result = response.data;
                $scope.paginaList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function insertPagina() {
            $http.post('api/pagina/insert/', $scope.pagina).then(function(response) {
                var result = response.data;
                $scope.pagina = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!$scope.hasError)
                    toastr.success(result.msg);

                $location.path('pagina/' + $scope.pagina.idPagina);
            });
        }

        function updatePagina() {
            $http.post('api/pagina/update/', $scope.pagina).then(function(response) {
                var result = response.data;
                $scope.pagina = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!$scope.hasError)
                    toastr.success(result.msg);
            });
        }
    });
