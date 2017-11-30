var app = angular.module('ZeitGeistModule')

    .controller('PaginaCtrl', function($scope, $http, $routeParams, $location, $window) {
        $scope.pagina = {};
        $scope.dado = {};
        $scope.templateList = [];
		$scope.selectedTemplate = {};

        if ($scope.hasError)
            toastr.error($scope.msg);

		if ($routeParams.codJornal ) {
			$scope.pagina.idJornal = $routeParams.codJornal;
		}

		getTemplateList();

		$scope.selectTemplate = function(template) {
			setSelectedTemplate(template);
		};

		function getTemplateList() {
			$http.get('api/template/list/').then(function(response) {
				var result = response.data;
				$scope.templateList = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;

				if ($routeParams.codPagina && $routeParams.codPagina != 0) {
					getPagina($routeParams.codPagina);
				}
			});
		}

		function getPagina(idPagina) {
			$http.get('api/pagina/get/' + idPagina).then(function(response) {
				var result = response.data;
				$scope.pagina = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;

				if (!$scope.hasError) {
					$scope.templateList.forEach(function (template) {
						if (template.idTemplate === $scope.pagina.idTemplate) {
							setSelectedTemplate(template);
							return;
						}
					});
				}
			});
		}

		function setSelectedTemplate(template) {
			$scope.selectedTemplate = template;

			if (!$scope.pagina.idTemplate || $scope.pagina.idTemplate == null) {
				$scope.pagina.idTemplate = template.idTemplate;
			}

			$scope.pagina.newIdTemplate = template.idTemplate;
			$scope.dado = {};

			$scope.selectedTemplate.dadosTemplate.forEach(function (dadoTemplate) {
				$scope.dado[dadoTemplate.idTemplateDado] = {};
				$scope.dado[dadoTemplate.idTemplateDado].idTemplateDado = dadoTemplate.idTemplateDado;
				$scope.dado[dadoTemplate.idTemplateDado].idTipoTemplateDado = dadoTemplate.idTipoTemplateDado;
				$scope.dado[dadoTemplate.idTemplateDado].valorPaginaDado = "";

				if ($scope.pagina && $scope.pagina.paginaDado && $scope.pagina.paginaDado[dadoTemplate.idTemplateDado] != null) {
					$scope.dado[dadoTemplate.idTemplateDado].idPaginaDado = $scope.pagina.paginaDado[dadoTemplate.idTemplateDado].idPaginaDado;
					$scope.dado[dadoTemplate.idTemplateDado].valorPaginaDado = $scope.pagina.paginaDado[dadoTemplate.idTemplateDado].valorPaginaDado;
				}
			});
		}

		$scope.voltar = function() {
			$scope.go('jornal/' + $scope.pagina.idJornal);
		};

		//=============================

        $scope.save = function() {
        	if (!$scope.selectedTemplate || $scope.selectedTemplate.idTemplate == null) {
				toastr.error("Por favor, selecione um template.", { positionClass: "toast-top-center"});
				return;
			}

			var paginaDado = [];
			for (var prop in $scope.dado) {
				paginaDado.push($scope.dado[prop]);
			}

			$scope.pagina.paginaDado = paginaDado;

			//console.log($scope.pagina);

			if ($scope.pagina.idPagina) {
				$http.post('api/pagina/update/', $scope.pagina).then(function(response) {
					var result = response.data;
					$scope.pagina = result.data;
					$scope.message = result.msg;
					$scope.hasError = result.hasError;

					toastr.success('Página atualizada com sucesso', { positionClass: "toast-top-center"});
				});
			} else {
				$http.post('api/pagina/insert/', $scope.pagina).then(function(response) {
					var result = response.data;

					$scope.message = result.msg;
					$scope.hasError = result.hasError;

					if(!$scope.hasError){

						$scope.pagina = result.data;
						toastr.success($scope.message, { positionClass: "toast-top-center"});

						$location.path('jornal/' + $scope.pagina.idJornal + '/pagina/' + $scope.pagina.idPagina);
					}
					else{
						toastr.error($scope.message, { positionClass: "toast-top-center"});
					}
				});
			}


			// var templateSelecionado = $scope.currentTab;
			//
            // $scope.pagina.idTemplate = templateSelecionado;
            // $scope.pagina.idJornal = $routeParams.codJornal;
			//
            // $http.post('api/pagina/insert/', $scope.pagina).then(function(response) {
            //     var resultPagina = response.data;
			//
            //     $scope.pagina = resultPagina.data;
            //     var idPagina = $scope.pagina.idPagina;
            //
            //     $scope.dadosTemplate = {};
            //     $http.get('api/dadosTemplate/list/' + templateSelecionado).then(function(response) {
            //         var resultDadosTemplate = response.data;
            //         $scope.dadosTemplate = resultDadosTemplate.data;
            //         $scope.hasError = resultDadosTemplate.hasError;
            //         $scope.msg = resultDadosTemplate.msg;
			//
			//
            //         if (!$scope.hasError) {
            //             for (var i = 0; i < $scope.dadosTemplate.length; i++) {
			//
            //                 $scope.paginaDado = {
            //                     idPaginaDado: null,
            //                     idPagina: idPagina,
            //                     idJornal: $routeParams.codJornal,
            //                     idTemplateDado: $scope.dadosTemplate[i].idTemplateDado
            //                 };
            //
            //                 var idPaginaDado;
            //
            //                 $http.post('api/paginaDado/insert/', $scope.paginaDado).then(function(response) {
            //                     var resultPaginaDado = response.data;
			//
            //                     $scope.paginaDado = resultPaginaDado.data;
            //                     idPaginaDado = $scope.paginaDado.idPaginaDado;
            //                 });
			//
            //                 if ($scope.dadosTemplate[i].idTipoTemplateDado == 1) {
            //                     var string = $("input[id*='" + $scope.dadosTemplate[i].chaveTemplateDado + "']").val();
			//
            //                     alert(idPaginaDado); //undefined
            //                     $scope.paginaString = {
            //                         idPaginaDado: idPaginaDado,
            //                         valorPaginaString: string
            //                     };
			//
            //                     $http.post('api/paginaString/insert/', $scope.paginaString).then(function(response) {
            //                         var resultPaginaString = response.data;
            //                     });
            //                 }
            //                 else if ($scope.dadosTemplate[i].idTipoTemplateDado == 2) {
            //                     var textArea = $("textarea[id*='" + $scope.dadosTemplate[i].chaveTemplateDado + "']").val();
			//
            //                     $scope.paginaTexto = {
            //                         idPaginaDado: idPaginaDado,
            //                         valorPaginaTexto: textArea
            //                     };
			//
            //                     $http.post('api/paginaTexto/insert/', $scope.paginaTexto).then(function(response) {
            //                         var resultPaginaTexto = response.data;
            //                     });
            //                 }
            //                 else if ($scope.dadosTemplate[i].idTipoTemplateDado == 3) {
			//
            //                 }
            //             }
            //         }
            //     });
            // });
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
    })

	.directive('fileInput', function () {
		return {
			restrict: 'A',
			scope: {
				fileInput: "="
			},
			link: function (scope, element) {
				element.bind("change", function (changeEvent) {
					var reader = new FileReader();
					reader.onload = function (loadEvent) {
						scope.$apply(function () {
							scope.fileInput = loadEvent.target.result;
						});
					};
					reader.readAsDataURL(changeEvent.target.files[0]);
				});
			}
		};
	});
