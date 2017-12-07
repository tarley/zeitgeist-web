var app = angular.module('ZeitGeistModule')

    .controller('PaginaCtrl', function($scope, $http, $routeParams, $location, $rootScope) {
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

		function getTemplateList() {
			$rootScope.loading = true;

			$http.get('api/template/list/').then(function(response) {
				var result = response.data;
				$scope.templateList = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;

				if ($routeParams.codPagina && $routeParams.codPagina != 0) {
					getPagina($routeParams.codPagina);
				} else {
					$rootScope.loading = false;
				}
			});
		}

		function getPagina(idPagina) {
			$rootScope.loading = true;

			$http.get('api/pagina/get/' + idPagina).then(function(response) {
				var result = response.data;
				$scope.pagina = result.data;
				$scope.hasError = result.hasError;
				$scope.msg = result.msg;

				$rootScope.loading = false;

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

		$scope.selectTemplate = function(template) {
			setSelectedTemplate(template);
		};

        $scope.save = function() {
        	if (!$scope.selectedTemplate || $scope.selectedTemplate.idTemplate == null) {
				toastr.error("Por favor, selecione um template.", { positionClass: "toast-top-center"});
				return;
			}

			$rootScope.loading = true;

			var paginaDado = [];
			for (var prop in $scope.dado) {
				paginaDado.push($scope.dado[prop]);
			}

			$scope.pagina.paginaDado = paginaDado;

			if ($scope.pagina.idPagina) {
				$http.post('api/pagina/update/', $scope.pagina).then(function(response) {
					var result = response.data;
					$scope.pagina = result.data;
					$scope.message = result.msg;
					$scope.hasError = result.hasError;

					$rootScope.loading = false;

					toastr.success('Página atualizada com sucesso', { positionClass: "toast-top-center"});
				});
			} else {
				$http.post('api/pagina/insert/', $scope.pagina).then(function(response) {
					var result = response.data;

					$scope.message = result.msg;
					$scope.hasError = result.hasError;

					$rootScope.loading = false;

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
        };
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
