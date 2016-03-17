var words_roubles = ["рубль", "рубля", "рублей"];
var words_months = ["месяц", "месяца", "месяцев"];
var _discounts = {
    1: 0,
    3: 5,
    6: 10,
    12: 15,
    24: 20,
    36: 25
};

var dockerSpinnerSettings = {
    lines: 7,
    length: 0,
    width: 6,
    radius: 7,
    corners: 1,
    rotate: 0,
    direction: 1,
    color: '#4385f5',
    speed: 1,
    trail: 60,
    shadow: false,
    hwaccel: false,
    className: 'spinner',
    zIndex: 2e9,
    top: '50%',
    left: '50%'
};

function validateDomain(domain) {
    var reg = /^([a-zA-Z0-9-]{1,32}\.){1,3}[a-zA-Z]{2,}$/;

    return reg.test(domain);
}

function validateDomainRf(domain) {
    var reg = /^([а-яА-Я0-9-]{1,32}\.){1,3}рф$/;

    return reg.test(domain);
}

function getSelectOptions(id) {
    var optionValues = [];

    $('#' + id + ' option').each(function () {
        optionValues.push($(this).val());
    });

    return optionValues;
}

function triple(nStr) { // деление на разряды пробелами 0132456789 -> 0 123 456 789
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ' ' + '$2');
    }

    return x1 + x2;
}

function declension(amount, words) {
    var digit = (Number(amount) > 20) ? Number(amount) % 10 : Number(amount);

    if (digit >= 5 || digit == 0) {
        return words[2]
    }

    if (digit >= 2) {
        return words[1]
    }

    return words[0];
}

function plural(amount, words) {
    return amount + ' ' + declension(amount, words);
}

function refreshSelect(id) {
    var select = new Dropkick("#" + id);
    select.refresh();
}

function clearSelect(id) {
    var select = $('#' + id);
    select.empty();
}

function changeSelectOptions(id, list) {
    var select = $('#' + id);
    clearSelect(id);

    for (var key in list) {
        select.prepend($('<option value="' + key + '">' + list[key] + '</option>'));
    }

    refreshSelect(id);  // Reset to originally selected option
}

function setFreePrices(id) {
    var obj = $('#' + id);
    var price = Number(obj.text());
    obj.removeClass('free');

    if (0 === price) {
        obj.text('Бесплатно');
        obj.addClass('free');
    } else {
        obj.text(plural(price, words_roubles) + ' в месяц');
    }
}
