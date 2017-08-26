var app = angular.module('ZeitGeistModule')

    .controller('LoginCtrl', ['$scope', '$rootScope', '$location', '$http', 'AuthenticationService', function ($scope, $rootScope, $location, $http, AuthenticationService){

        function login() {
            AuthenticationService.ClearCredentials();
            AuthenticationService.Login($scope.username, $scope.password, function(response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!result.hasError) {
                    AuthenticationService.SetCredentials($scope.username, $scope.password);
                }
            });
        }
    }])

    .controller('HomeCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.page = "Home";
    }]);