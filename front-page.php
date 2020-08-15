<?php
/**
 * Created by PhpStorm.
 * User: j3sha
 * Date: 7/15/2018
 * Time: 12:18 PM
 */
/*
 * Template name: Home
 */

defined('ABSPATH') or die("No script kiddies please!");

get_header();
get_template_part('menu-section');
if (have_posts()) :

    // Start the loop.
    while (have_posts()) : the_post();
        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        the_content();
    // End the loop.
    endwhile;

// If no content, include the "No posts found" template.
else :
    get_template_part('template-parts/content', 'none');

endif;

get_footer();
