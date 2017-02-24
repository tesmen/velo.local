angular.module('myApp', ['ngRoute'])
    .config(function ($routeProvider, $locationProvider) {
        $locationProvider.hashPrefix('');
        var templatesBase = '/bundles/velovito/admin-static/views';

        $routeProvider
            .when("/", {
                templateUrl: templatesBase + "/dashboard.html",
                controller: dashBoardController
            })
            .when("/categories", {
                templateUrl: "dashboard.html"
            })
            .when("/products/list", {
                templateUrl: templatesBase + "/products.html",
                controller: productsController
            })
            .when("/products/add", {
                templateUrl: templatesBase + "/product.html",
                controller: addProductController
            })
            .when("/products/edit/:id", {
                templateUrl: templatesBase + "/product.html",
                controller: editProductController
            })
            .when("/categories/list", {
                templateUrl: templatesBase + "/categories.html",
                controller: categoriesController
            })
            .otherwise({
                redirectTo: "/"
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
                $location.path('/');
            }
        )
    }
}

function dashBoardController($scope) {
    $scope.name = 'dashBoardController';
}

function productsController($scope, $http, $location) {
    $scope.products = {};
    $scope.categories = {};

    $http.get('api/admin/productCategory?index_by=id').success(function (response) {
        $scope.categories = response.data;
    });

    $scope.loadProducts = function () {
        $http.get('api/admin/product').success(function (response) {
            $scope.products = response.data;
        })
    };

    $scope.editItem = function (item) {
        $location.path('/products/edit/' + item.id);
    };

    $scope.addItem = function () {
        $location.path('/products/add');
    };

    $scope.toggleActive = function (item) {
        $http.post('api/admin/product/' + item.id, {entity: {active: !item.active}}).success(function (response) {
            $scope.loadProducts();
        })
    };

    $scope.loadProducts();
}

function editProductController($scope, $http, $location, $routeParams) {
    $scope.item = {};
    $scope.categories = {};

    $http.get('api/admin/productCategory?index_by=id').success(function (response) {
        $scope.categories = response.data;
    });

    $http.get('api/admin/product/' + $routeParams.id).success(function (response) {
        $scope.item = response.data;
    });

    $scope.save = function () {
        $http.post('api/admin/product/' + $scope.item.id, {entity: $scope.item}).success(function (response) {
            $location.path('/products/list')
        })
    };
}

function addProductController($scope, $http, $location, $routeParams) {
    $scope.item = {};
    $scope.categories = {};

    $http.get('api/admin/productCategory?index_by=id').success(function (response) {
        $scope.categories = response.data;
    });

    $http.get('api/admin/product/' + $routeParams.id).success(function (response) {
        $scope.item = response.data;
    });

    $scope.save = function () {
        $http.post('api/admin/product', {entity: $scope.item}).success(function (response) {
            $location.path('/products/list')
        })
    };
}

function categoriesController($scope, $http) {
    $scope.list = {};

    $http.get('api/admin/productCategory').success(function (response) {
        $scope.list = response.data;
    })
}
