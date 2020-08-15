(function ($) {
    "use strict";

    // Home Top Background Image - Image Control
    wp.customize('wpbucket_footer_logo_control', function (value) {
        value.bind(function (to) {
            //$( '.footer-logo' ).css( 'background-image', 'url( ' + to + ')' );
            $('.footer-logo a > img').attr('src', to);
        });
    });

    wp.customize('wpbucket_button_text_control', function (value) {
        value.bind(function (to) {
            console.log(to);
            //$( '.footer-logo' ).css( 'background-image', 'url( ' + to + ')' );
            $('.menu-button a').text(to);
        });
    });

    wp.customize('wpbucket_button_url_control', function (value) {
        value.bind(function (to) {
            //$( '.footer-logo' ).css( 'background-image', 'url( ' + to + ')' );
            $('.menu-button a').attr('href', to);
        });
    });

    wp.customize('wpbucket_button_show_hide_control', function (value) {
        value.bind(function (to) {
            //$( '.footer-logo' ).css( 'background-image', 'url( ' + to + ')' );
            if (to == 1)
                $('.menu-button').hide();
            else
                $('.menu-button').show();
        });
    });

    wp.customize('wpbucket_button_bg_color_control', function (value) {
        value.bind(function (to) {
            //$( '.footer-logo' ).css( 'background-image', 'url( ' + to + ')' );
            $('.menu-button a').css('background-color', to);
        });
    });


})(jQuery);