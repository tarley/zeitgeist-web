var app = angular.module('ZeitGeistModule')

    .controller('PaginaCtrl', function($scope, $http, $routeParams, $location, $window) {



        $scope.initCadastro = function() {
            $scope.pagina = {};
            $scope.isEdit = false;
        }

        if ($routeParams.idPagina && $routeParams.idPagina != 0) {
            $scope.isEdit = true;
            getPagina($routeParams.idPagina);
        }
        else {
            getListPagina();
        }

        getListPagina();

        if ($scope.hasError)
            toastr.error($scope.msg);

        $scope.save = function() {
            if ($routeParams.idPagina == 0) {
                insertPagina();
            }
            else {
                updatePagina();
            }
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
