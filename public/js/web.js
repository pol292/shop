$(document).ready(function () {
    function flyToElement(flyer, flyingTo) {
        var $func = $(this);
        var divider = 15;
        var flyerClone = $(flyer).clone();
        $(flyerClone).css({
            position: 'absolute',
            top: $(flyer).offset().top + "px",
            left: $(flyer).offset().left + "px",
            opacity: 1,
            'z-index': 100000000
        });
        $('body').append($(flyerClone));
        var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width() / divider) / 2;
        var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height() / divider) / 2;

        $(flyerClone).animate({
            opacity: 0.4,
            left: gotoX,
            top: gotoY,
            width: $(flyer).width() / divider,
            height: $(flyer).height() / divider
        }, 1000,
                function () {
                    $(flyingTo).fadeOut('fast', function () {
                        $(flyingTo).fadeIn('fast', function () {
                            $(flyerClone).fadeOut('fast', function () {
                                $(flyerClone).remove();
                            });
                        });
                    });
                });
    }


    $('.addToCart').on('click', function (e) {
        e.preventDefault();
        $(this).hide().delay(1000).fadeIn();
        var next = $(this).next(),
                id = $(this).data('pid');
        next.fadeIn().delay(500).fadeOut();

        var itemImg = $(this).parents('.box-product').children('.img-wrapper').find('img').eq(0);
        flyToElement($(itemImg), $('.cart-btn'));

        $.ajax({
            url: URL + "shop/add-to-cart/" + id,
            type: "GET",
            dataType: "html",
            data: {},
            success: function (data) {
                $("#top-header").load(" #top-content");
                $("#cart-show").load(" .table-cart");
            }
        });
        $('.message').delay(3000).fadeOut(200);
    });


    $('.addMenyToCart').on('click', function (e) {
        e.preventDefault();
        $(this).hide().delay(1000).fadeIn();
        var next = $(this).next(),
                id = $(this).data('id'),
                qty = $('#qty').val();
        next.fadeIn().delay(500).fadeOut();

        var itemImg = $('.image-detail').find('img').eq(0);
        flyToElement($(itemImg), $('.cart-btn'));

        $.ajax({
            url: URL + "shop/add-to-cart/" + id + '/' + qty,
            type: "GET",
            dataType: "html",
            data: {},
            success: function (data) {
                $("#top-header").load(" #top-content");
                $("#cart-show").load(" .table-cart");
            }
        });
        $('.message').delay(3000).fadeOut(200);
    });


    $('.remove-from-cart').on('click', function (e) {
        e.preventDefault();
        var rowid = $(this).data('rowid');
        $.ajax({
            url: URL + "shop/remove-from-cart/" + rowid,
            type: "GET",
            dataType: "html",
            data: {},
            success: function (data) {
                $("#top-header").load(" #top-content");
                $("#cart-show").load(" .table-cart");
            }
        });
        $('.message').delay(3000).fadeOut(200);
    });

    $('.message').delay(3000).fadeOut(200);

    $('.cart-qty').on('change', function (e) {
        e.preventDefault();
        var rowid = $(this).data('rowid'),
                value = $(this).val();
        $.ajax({
            url: URL + "shop/update-cart/" + rowid + '/' + value,
            type: "GET",
            dataType: "html",
            data: {},
            success: function (data) {
                location.reload();
            }
        });
    });
});

