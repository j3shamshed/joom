/*
Theme Name: 
Version: 
Author: 
Author URI: 
Description: 
*/
/*	IE 10 Fix*/

(function ($) {
	'use strict';
	
	jQuery(document).ready(function () {

        // Search Box Open On Click
        $('.search-form').on("click",(function(e){
            $(".search-form").addClass("search-open");
            e.stopPropagation()
        }));
//        $(document).on("click", function(e) {
//            if ($(e.target).is(".search-form") === false && $(".form-control").val().length == 0) {
//                $(".search-form").removeClass("search-open");
//            }
//        });

		// Slider Carousel
		$('.slider_carousel').owlCarousel({
            items: 1,
            loop: true,
            center: true,
            margin: 100,
            autoplay: true,
            autoplayTimeout: 6000,
            responsiveClass: true,
            dots: true,
            nav: false,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 1,
                    nav: false
                },
                1000: {
                    items: 1,
                    nav: false
                }
            }

        });

		// Gallery Carousel
		$('.insta_gallery').owlCarousel({
            loop: true,
            margin: 30,
            autoplay: true,
            dots: false,
            center: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                   	items: 4,
                    nav: false
                },
                1000: {
                    items: 6,
                    nav: false
                }
            }
        });

        // Gallery Carousel
        $('.post_gallery_carousel').owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            autoplay: true,
            center: true,
            dots: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });

        // Gallery Carousel
        $('.post_gallery_tiled').owlCarousel({
            items: 3,
            loop: true,
            margin: 30,
            autoplay: true,
            center: false,
            dots: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                1000: {
                    items: 3,
                }
            }
        });
 	});

	
})(jQuery);
