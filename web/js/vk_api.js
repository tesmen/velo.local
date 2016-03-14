function vkApi() {
    var self = this;
    this.timeout = null; // JS timeout var
    this.timer = 300;  // msec
    this.requiredPromoLength = 6;

    this.make = function (method, params) {
        var script = document.createElement('SCRIPT');
        script.src = "https://api.vk.com/method/database.getCities?country_id=1&callback=callbackFunc";
        document.getElementsByTagName("head")[0].appendChild(script);
    };

    this.check = function () {
        var ajaxData = {
            code: this.code,
            type: productType
        };

        ajaxPromo = $.ajax({
            dataType: 'json',
            type: "GET",
            url: 'https://api.vk.com/method/' + method,
            data: ajaxData
        });

        ajaxPromo.done(function (data) {
            onResultAction(data);
        });

        return ajaxPromo;
    };

    this.input = function (rawCode) {
        var code = String(rawCode);
        clearTimeout(this.timeout);

        if (code.length < this.requiredPromoLength) {
            onCancelCheckAction();
            return;
        }
        onAcceptCheckAction();
        this.code = code;

        this.timeout = setTimeout(function () {
            self.check();
        }, self.timer);
    }
}
