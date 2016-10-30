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
            .when("/products/add", {
                templateUrl: "/admin-static/views/product.html",
                controller: addProductController,
                reloadOnSearch: false

            })
            .when("/products/edit/:id", {
                templateUrl: "/admin-static/views/product.html",
                controller: editProductController,
                reloadOnSearch: false

            })
            .when("/categories/list", {
                templateUrl: "/admin-static/views/categories.html",
                controller: categoriesController,
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
    .filter('greet', greetFilter)
    .run(function ($rootScope) {
        $('.selectpicker').selectpicker('refresh');

        $rootScope.globalBack = function() {
            window.history.back();
        };
    });

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

function greetFilter() {
    return function (name) {
        return 'Hello, ' + name + '!';
    }
}
