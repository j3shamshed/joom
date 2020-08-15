<?php

/*
 * ---------------------------------------------------------
 * Color style
 *
 * Class for custom color style rendering
 * ----------------------------------------------------------
 */

class Wpbucket_Color_Style
{
    static function get_compiled_css($color_style, $color_style_hover, $color_style_border)
    {
        $lighter_color = wpbucket_adjust_color_brightness($color_style, 4);

        ob_start();
        ?>
        .map .cluster > div, .map .cluster > div:after, .map .marker .marker-wrapper .pin:before, .ui-slider .noUi-base .noUi-handle{
        background-color: <?php echo wp_kses($color_style, array()); ?>;
        border: 2px solid <?php echo wp_kses($color_style, array()); ?>;
        }
        .map .marker .marker-wrapper:before, .map .marker .tag, .background-wrapper .background-color.background-color-default, .background-is-dark .ui-slider .noUi-base .noUi-handle, .answer .box:after, .categories-list .list-item .title .icon, .customizer .sp-container button:active, .customizer .sp-container button:focus, .customizer .sp-container button:hover, .customizer .sp-container button:active:hover, .customizer .sp-container button:active:focus, .customizer .sp-container button:focus:hover, .datepicker .table-condensed > tbody > tr > td.day:hover, .datepicker .month:hover, .item.featured .additional-info, .item .circle.featured, .message-popup.featured, .my-items .circle, #page-footer .footer-navigation, .label.label-default, .pagination li.active a, .pricing.box.featured, .pricing.featured:not(.box) figure, .ribbon, .step .circle figure, .step .circle .circle-bg, .subpage-detail #gallery-nav .owl-next:after, .subpage-detail #gallery-nav .owl-prev:after, .btn.btn-primary:active, .btn.btn-primary:focus, .btn.btn-primary:hover, .btn.btn-primary:active:hover, .btn.btn-primary:active:focus, .btn.btn-primary:focus:hover, .hero-section select.form-control, .hero-section select, .hero-section input[type="text"], .hero-section input[type="email"], .hero-section input[type="date"], .hero-section input[type="time"], .hero-section input[type="search"], .hero-section input[type="password"], .hero-section input[type="number"], .hero-section input[type="tel"], .hero-section textarea.form-control, .hero-section .bootstrap-select .btn, .hero-section .bootstrap-select .btn:active, .hero-section .bootstrap-select .btn:focus, .hero-section .bootstrap-select .btn:hover, .hero-section .bootstrap-select .btn:active:hover, .hero-section .bootstrap-select .btn:active:focus, .hero-section .bootstrap-select .btn:focus:hover, .hero-section.has-background .form.horizontal form:after, .form.horizontal form, .form.inputs-dark input[type="text"], .form.inputs-dark input[type="email"], .form.inputs-dark input[type="date"], .form.inputs-dark input[type="time"], .form.inputs-dark input[type="search"], .form.inputs-dark input[type="password"], .form.inputs-dark input[type="number"], .form.inputs-dark input[type="tel"], .form.inputs-dark textarea.form-control, .form.inputs-dark input[type="text"]:active, .form.inputs-dark input[type="text"]:focus, .form.inputs-dark input[type="text"]:hover, .form.inputs-dark input[type="email"]:active, .form.inputs-dark input[type="email"]:focus, .form.inputs-dark input[type="email"]:hover, .form.inputs-dark input[type="date"]:active, .form.inputs-dark input[type="date"]:focus, .form.inputs-dark input[type="date"]:hover, .form.inputs-dark input[type="time"]:active, .form.inputs-dark input[type="time"]:focus, .form.inputs-dark input[type="time"]:hover, .form.inputs-dark input[type="search"]:active, .form.inputs-dark input[type="search"]:focus, .form.inputs-dark input[type="search"]:hover, .form.inputs-dark input[type="password"]:active, .form.inputs-dark input[type="password"]:focus, .form.inputs-dark input[type="password"]:hover, .form.inputs-dark input[type="number"]:active, .form.inputs-dark input[type="number"]:focus, .form.inputs-dark input[type="number"]:hover, .form.inputs-dark input[type="tel"]:active, .form.inputs-dark input[type="tel"]:focus, .form.inputs-dark input[type="tel"]:hover, .form.inputs-dark textarea.form-control:active, .form.inputs-dark textarea.form-control:focus, .form.inputs-dark textarea.form-control:hover, .form.inputs-dark select.form-control, .form.inputs-dark select, .form.inputs-dark select.form-control:hover, .form.inputs-dark select:hover, .form.inputs-dark .bootstrap-select .btn, .form.inputs-dark .bootstrap-select .btn:active, .form.inputs-dark .bootstrap-select .btn:focus, .form.inputs-dark .bootstrap-select .btn:hover, .form.inputs-dark .ui-slider .noUi-base .noUi-handle, .ui-slider .noUi-base .noUi-connect, .hero-section .coupon .image .circle, .hero-section .results-wrapper .result-item > a::before{
        background-color: <?php echo wp_kses($color_style, array()); ?>;
        }
        .map .marker .marker-wrapper .pin{
        border: 2px solid <?php echo wp_kses($color_style, array()); ?>;
        }
        .map .marker .marker-wrapper .pin .image:after, .answer .box:before, .ribbon:after{
        border-color: <?php echo wp_kses($color_style, array()); ?> transparent transparent transparent;
        }
        .sidebar-detail .back:after, .modal .back:after, address i, a, .homepage h2, ul.bullets li:before, .bg.color.default, .font-color-default, .circle-icon:hover, .circle-icon.active, .comments .comment .reply .fa, .controls-more:hover:after, .datepicker .glyphicon, .file-upload span, .item.item-row > a .description h3, .item .circle i, .list-descriptive.icon li i, .list-schedule .promoted, .my-items .featured.yes, .owl-carousel .owl-item .item .circle.featured, #page-footer .circle-icon, .pricing figure, .pricing ul li.available, .rating-passive .stars figure.active, .reviews .review .comment .comment-title .rating, .reviews .review .visitor-rating dd, .star-rating i.active, .star-rating i.hover, .visitor-rating dd, .tags li:before, .btn.btn-primary.btn-framed, h3, #wp-calendar tfoot td a:hover, .tagcloud a:hover, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-nav > li{
        color: <?php echo wp_kses($color_style, array()); ?>;
        }
        h1, h2, table #today{
        color: <?php echo wp_kses($color_style, array()); ?>!important;
        }
        .background-is-dark .btn.btn-primary.btn-framed:hover, .background-is-dark .btn.btn-primary.btn-framed:active, .background-is-dark .btn.btn-primary.btn-framed:active:hover, .background-is-dark .btn.btn-primary.btn-framed:focus{
        border-color: <?php echo wp_kses($color_style, array()); ?>;
        }
        .btn.btn-primary, .btn.btn-primary:hover, .btn.btn-primary:active, .btn.btn-primary:active:hover, .btn.btn-primary:focus, .btn.btn-primary:active:focus, .inputs-underline .btn-primary, .widget .tnp-submit{
        background-color: <?php echo wp_kses($color_style, array()); ?>;
        border-color: <?php echo wp_kses($color_style, array()); ?>;
        }
        .btn.sa:before{
        border-color: transparent transparent <?php echo wp_kses($color_style, array()); ?> transparent;
        }
        .widget .tnp-submit, .inputs-underline .btn-primary{
        background-color: <?php echo wp_kses($color_style, array()); ?>!important;
        border-color: <?php echo wp_kses($color_style, array()); ?>!important;
        }
        <?php
        $css = ob_get_clean();

        return $css;
    }
}
