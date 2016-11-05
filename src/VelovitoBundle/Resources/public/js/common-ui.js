$(document).ready(function () {
    $('.selectpicker').selectpicker();

    $('.bootstrap-select').click(function () {
        $('.selectpicker').selectpicker('refresh');
    });

    $('.dropdown-menu').on('click', '.unclickable-dropdown-item', function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('.catalog-menu .unclickable-dropdown-item').hover(
        function () {
            var menuId = $(this).data('label-for');

            $(this).parent().find('#' + menuId).removeClass('display-none');
        },
        function () {
            var menuId = $(this).data('label-for');

            $(this).parent().find('#' + menuId).addClass('display-none');
        }
    );

    $('.catalog-menu a').hover(
        function () {
            $(this).addClass('active')
            $(this).siblings().removeClass('active')
        }
    );

    $('.catalog-menu').mouseleave(
        function () {
            $(this).children().removeClass('active')
        }
    );
});