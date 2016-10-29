angular.module('myApp', ['ngRoute'])
    .config(function ($routeProvider) {
        $routeProvider
            .when("/", {
                templateUrl: "/admin-static/views/dashboard.html",
                controller: dashBoardController,
                reloadOnSearch: false
            })
            .when("/categories", {
                templateUrl: "dashboard.html"
            })
            .when("/products/list", {
                templateUrl: "/admin-static/views/products.html",
                controller: productsController,
                reloadOnSearch: false

            })
            .when("/blue", {
                templateUrl: "blue.htm"
            })
            .otherwise({
                redirectTo: '/'
            });
    })
    .controller('myCtrl', myCtrl)
    .controller('dashBoardController', dashBoardController)
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

function dashBoardController($scope) {
    $scope.red = 'red';
}

function productsController($scope, $http) {
    $scope.products = 'red';

    $scope.loadProducts = function () {
        $http.get('api/admin/product').success(function (response) {
            $scope.products = response.data;
        })
    };

    $scope.loadProducts();
}

function greetFilter() {
    return function (name) {
        return 'Hello, ' + name + '!';
    }
}