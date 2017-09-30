var app = angular.module('ZeitGeistModule')


    .controller('JornalCtrl',  function($scope, $http, $routeParams, $location) {

        $scope.jornal= {};
        getListEdicoes(); 
        
        function getListEdicoes() {
            $http.get('api/jornal/list/').then(function(response) {
                var result = response.data;
                $scope.jornalList = result.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;
            });
        }
    
    });