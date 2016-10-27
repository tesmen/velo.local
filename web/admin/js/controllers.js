angular.module('myApp', ['ngRoute'])
    .config(function ($routeProvider) {
        $routeProvider
            .when("/dashboard", {
                templateUrl: "/admin/views/dashboard.html",
                controller: "redCtrl",
                reloadOnSearch: false
            })
            .when("/categories", {
                templateUrl: "dashboard.html"
            })
            .when("/green", {
                templateUrl: "green.htm"
            })
            .when("/blue", {
                templateUrl: "blue.htm"
            })
            .otherwise({
                redirectTo: '/dashboard'
            });
    })
    .controller('myCtrl', myCtrl)
    .controller('redCtrl', redCtrl)
    .filter('greet', greetFilter);

function myCtrl($scope, $http) {
    $scope.foo = 1;

    $scope.getIt = function () {
        $http.get('http://velo.local/api/search-adverts')
            .success(
                function (data) {
                    console.log(data)
                    $location.path('/');
                }
            )
    }
}
function redCtrl($scope) {
    $scope.red = 'red';
}

function greetFilter() {
    return function (name) {
        return 'Hello, ' + name + '!';
    }
}