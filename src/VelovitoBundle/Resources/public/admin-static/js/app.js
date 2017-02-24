angular.module('adminApp', ['ngRoute'])
    .config(function ($routeProvider, $locationProvider) {
        $locationProvider.hashPrefix('');
        var templatesBase = '/bundles/velovito/admin-static/views';

        $routeProvider
            .when("/", {
                templateUrl: templatesBase + "/dashboard.html",
                controller: dashBoardController
            })
            .when("/categories", {
                templateUrl: "dashboard.html",
                reloadOnSearch: true
            })
            .when("/products", {
                templateUrl: templatesBase + "/products.html",
                controller: productsController,
                reloadOnSearch: true
            })
            .when("/products/add", {
                templateUrl: templatesBase + "/product.html",
                controller: editProductController,
                reloadOnSearch: true
            })
            .when("/products/edit/:id", {
                templateUrl: templatesBase + "/product.html",
                controller: editProductController
            })
            .when("/categories", {
                templateUrl: templatesBase + "/categories.html",
                controller: categoriesController
            })
            .otherwise({
                redirectTo: "/"
            });
    })
    .service('adminApi', adminApiService)
    .controller('dashBoardController', dashBoardController)
    .controller('commonCtrl', commonController)
    .filter('greet', greetFilter)
    .filter('objectKeys', objectKeysFilter);

function dashBoardController($scope) {
    $scope.setName('dashBoardController');
}

function productsController($scope, $http, $location, adminApi) {
    $scope.setName('Products');
    $scope.loadProducts();
    $scope.loadCategories();

    $scope.editItem = function (item) {
        $location.path('/products/edit/' + item.id);
    };

    $scope.addItem = function () {
        $location.path('/products/add');
    };

    $scope.toggleActive = function (item) {
        $http.post('api/admin/product/' + item.id, {entity: {active: !item.active}}).then(function (response) {
            $scope.loadProducts();
        })
    };
}

function editProductController($scope, $http, $location, $routeParams, adminApi) {
    $scope.setName('Edit product');
    $scope.item = {};

    $scope.loadCategories();
    adminApi.loadProduct($routeParams.id).then(function (response) {
        $scope.item = response.data.data;
    });

    $scope.back = function () {
        $location.path('/products');
    };

    $scope.save = function () {
        adminApi.save($routeParams.id).then(function (response) {
            $scope.item = response.data.data;
        });
    };
}

function categoriesController($scope, $http) {
    $scope.list = {};

    $http.get('api/admin/productCategory').then(function (response) {
        $scope.list = response.data;
    })
}

function commonController($rootScope, $scope, adminApi) {
    $scope.cache = {};
    $scope.products = {};
    $scope.categories = {};

    $scope.loadProducts = function () {
        adminApi.loadProducts().then(function (response) {
            $scope.products = response.data.data;
        });
    };

    $scope.loadCategories = function () {
        adminApi.loadCategories().then(function (response) {
            $scope.categories = response.data.data;
            console.log($scope.categories);
        });
    };

    $scope.setName = function (name) {
        $scope.pageName = name;
    };

    $scope.getCategoryById = function (id) {
        return pick($scope.categories, id)
    };
}
