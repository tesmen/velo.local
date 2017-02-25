function adminApiService($http) {
    this.load = function (tableName, id) {
        if (id) {
            return $http.get('api/admin/' + tableName + '/' + id);
        }

        return $http.get('api/admin/' + tableName);
    };

    this.save = function (tableName, id, data) {
        var intId = Number(id) ? '/' + Number(id) : '';
        console.log('save');
        console.log(data);
        return $http.post('api/admin/' + tableName + intId, data);
    };

    this.loadProducts = function () {
        return this.load('products');
    };

    this.loadProduct = function (id) {
        return this.load('products', id);
    };

    this.loadCategories = function (id) {
        return this.load('product_categories', id);
    };

    this.loadProductAttributes = function (id) {
        return this.load('product_attributes', id);
    };
}
