<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */

defined('ABSPATH') or die("No script kiddies please!");

get_header();
get_template_part('menu-section');

$main_title = wpbucket_return_theme_option('404_main_heading', '', 'Page Not Found');
$description = wpbucket_return_theme_option('404_description', '', 'We are sorry, but we cann\'t find the page you searching.');

?>
    <div class="main-wrapper">
        <div class="container">
            <div class="not-found text-center">
                <h1><?php echo esc_html__('404', 'yowel'); ?></h1>
                <h5><?php echo sprintf(esc_html__('%s', 'yowel'), $main_title); ?></h5>
                <p><?php echo esc_html($description); ?></p>
                <a class="btn btn-outline-primary" href="<?php echo esc_url(home_url('/')) ?>"
                   role="button"><?php echo esc_html__('Back To Home', 'yowel'); ?></a>
            </div>
        </div>
    </div>
<?php
get_footer();
?>