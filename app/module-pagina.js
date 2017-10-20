var app = angular.module('ZeitGeistModule')

    .controller('PaginaCtrl', function($scope, $http, $routeParams, $location, $window) {

        $scope.initCadastro = function() {
            $scope.pagina = {};
            $scope.isEdit = false;
        };

        /*if ($routeParams.idPagina && $routeParams.idPagina != 0) {
            $scope.isEdit = true;
            getPagina($routeParams.idPagina);
        }
        else {
            getListPagina();
        }

        getListPagina();*/

        if ($scope.hasError)
            toastr.error($scope.msg);

        $scope.fillTemplateDados = function() {

            $("div[id*='divDadosTemplate']").html("");

            var templateSelecionado = $scope.currentTab;

            $scope.dadosTemplate = {};
            $http.get('api/dadosTemplate/list/' + templateSelecionado).then(function(response) {
                var result = response.data;
                $scope.dadosTemplate = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!$scope.hasError) {
                    for (var i = 0; i < $scope.dadosTemplate.length; i++) {
                        if ($scope.dadosTemplate[i].idTipoTemplateDado == 1) {
                            var input = $("<input id='" + $scope.dadosTemplate[i].chaveTemplateDado + "' type='text'>");
                            $("div[id*='divDadosTemplate']").append(input);
                        }
                        else if ($scope.dadosTemplate[i].idTipoTemplateDado == 2) {
                            var textArea = $("<textarea id='" + $scope.dadosTemplate[i].chaveTemplateDado + "' cols='40' rows='5'></textarea>");
                            $("div[id*='divDadosTemplate']").append(textArea);
                        }
                        else if ($scope.dadosTemplate[i].idTipoTemplateDado == 3) {
                            var uploadFile = $("<div flow-init='{target: '/upload'}' flow-files-submitted='$flow.upload()' flow-file-success='$file.msg = $message'>" +
                                "<input type='file' flow-btn/> Input OR Other element as upload button" +
                                "<span class='btn' flow-btn>Upload File</span>" +
                                "</div>");
                            $("div[id*='divDadosTemplate']").append(uploadFile);
                        }
                    }
                }
            });
        };

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

        function getPagina(idPagina) {
            $http.get('api/pagina/get/' + idPagina).then(function(response) {
                var result = response.data;
                $scope.pagina = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

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

    .controller('PaginaPreviewCtrl', function($scope, $http, $routeParams, $location, $window) {

        if ($routeParams.codJornal && $routeParams.codJornal != 0) {

            getListPagina($routeParams.codJornal);
        }
        else {
            $location.path('jornal/');
        }

        function getListPagina(codJornal) {
            $http.get('api/pagina/list/' + codJornal).then(function(response) {
                var result = response.data;
                $scope.paginaList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }
    });
