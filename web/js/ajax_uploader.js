function AjaxUploader() {
    var self = this;
    this.timeout = null; // JS timeout var
    this.timer = 300;  // msec

    this.make = function (method, params) {
        params.callback = 'callbackFunc';
        var script = document.createElement('SCRIPT');
        script.src = "https://api.vk.com/method/" + method + "?" + $.param(params);

        document.getElementsByTagName("head")[0].appendChild(script);
    };

    this.getCities = function (countryId, search) {
        if (undefined === countryId) {
            countryId = 1; // Russian Federation
        }

        return this.make('database.getCities', {
            country_id: countryId,
            q: search
        });
    }
}
