var app = angular.module('ZeitGeistModule')

    .controller('JornalCtrl', function($scope, $http, $routeParams, $location) {

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
            }
            else {
                $http.get('api/jornal/getUltimaEdicao/').then(function(response) {
                    var result = response.data;
                    $scope.jornal = result.data;
                });
            }
        };

        $scope.initListage = function() {
            $scope.jornal = {};
            getListEdicoes();
        };

        function getListEdicoes(codStatus) {

            if (codStatus != undefined) {
                $http.get('api/jornal/list/' + codStatus).then(function(response) {
                    var result = response.data;
                    $scope.jornalList = result.data;
                    $scope.hasError = result.hasError;
                    $scope.msg = result.msg;
                });
            }
            else {
                $http.get('api/jornal/list/').then(function(response) {
                    var result = response.data;
                    $scope.jornalList = result.data;
                    $scope.hasError = result.hasError;
                    $scope.msg = result.msg;
                });
            }
        }

        $scope.DropDownChanged = function() {
            $scope.DropDownStatus = $scope.ZeitGeistModule;
            getListEdicoes($scope.DropDownStatus);
        };

        if ($scope.hasError)
            alert($scope.msg);

        $scope.save = function() {
            if ($routeParams.codJornal == 0) {
                insertJornal();
            }
            else {
                updateJornal();
            }
        };

        function getJornal(codJornal) {
            $http.get('api/jornal/get/' + codJornal).then(function(response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function getListJornal() {
            $http.get('api/jornal/list/').then(function(response) {
                var result = response.data;
                $scope.jornalList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
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
            $scope.jornal.idSituacao = 3;
            $scope.jornal.idUsuario = 1;
            $http.post('api/jornal/insert/', $scope.jornal).then(function(response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                alert(result.msg);

                $location.path('jornal/' + $scope.jornal.idJornal);
            });
        }

        function updateJornal() {
            $http.post('api/jornal/update/', $scope.jornal).then(function(response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                alert(result.msg);

                $location.path('jornal/' + $scope.jornal.idJornal);
            });
        }

        $scope.goJornal = function(idJornal) {
            $location.path("jornal/" + idJornal);
        };
    });
