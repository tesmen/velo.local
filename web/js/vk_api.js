function vkApi() {
    var self = this;
    this.timeout = null; // JS timeout var
    this.timer = 300;  // msec

    this.make = function (method, params) {
        var script = document.createElement('SCRIPT');
        script.src = "https://api.vk.com/method/" + method + "?callback=callbackFunc&" + $.param(params);
        console.log(script.src);

        document.getElementsByTagName("head")[0].appendChild(script);
    };

    this.getCities = function (countryId, search) {
        if (undefined === countryId) {
            countryId = 1;
        }

        return this.make('database.getCities', {
            country_id: countryId,
            q: search
        });
    }
}
