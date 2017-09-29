var app = angular.module('ZeitGeistModule')

    .controller('JornalCtrl', ['$scope', '$http', '$routeParams', '$location', function($scope, $http, $routeParams, $location) {
        $scope.jornal = {};
        $scope.isEdit = false;

        if ($routeParams.codJornal && $routeParams.codJornal != 0) {
            $scope.isEdit = true;
            getJornal($routeParams.codJornal);
        } else {
            getListJornal();
        }

        getListJornal();

        if($scope.hasError)
            toastr.error($scope.msg);

        $scope.save = function() {
            if($routeParams.codJornal == 0) {
                insertJornal();
            } else {
                updateJornal();
            }
        };

        function getJornal(codJornal) {
            $http.get('api/jornal/get/' + codJornal).then(function (response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function getListJornal() {
            $http.get('api/jornal/list/').then(function (response) {
                var result = response.data;
                $scope.jornalList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }

        function insertJornal() {
            $http.post('api/jornal/insert/', $scope.jornal).then(function (response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if(!$scope.hasError)
                    toastr.success(result.msg);

                $location.path('jornal/' + $scope.jornal.codJornal);
            });
        }

        function updateJornal() {
            $http.post('api/jornal/update/', $scope.jornal).then(function (response) {
                var result = response.data;
                $scope.jornal = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if(!$scope.hasError)
                    toastr.success(result.msg);
            });
        }
    }]);