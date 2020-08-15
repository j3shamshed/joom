<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */
define('WPBUCKET_THEME_NAME', "Blog");
define('WPBUCKET_TEMPLATEURL', get_template_directory_uri());
define('WPBUCKET_THEME_DIR', get_template_directory());
global $wpbucket_theme_config;
/* --------------------------------------------------------------------
 * Array with configurations for current theme
 * -------------------------------------------------------------------- */

$wpbucket_theme_config = array(
    'allowed_html_tags' => array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
            'target' => array()
        ),
        'br' => array(),
        'em' => array('class' => array(),),
        'strong' => array('class' => array(),),
        'span' => array('class' => array()),
        'div' => array('class' => array(),),
        'h1' => array('class' => array(),),
        'h2' => array('class' => array(),),
        'h3' => array('class' => array(),),
        'h4' => array('class' => array(),),
        'h5' => array('class' => array(),),
        'h6' => array('class' => array(),),
        'p' => array('class' => array(),),
        'ul' => array(
            'class' => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'i' => array(
            'class' => array(),
        ),
        'img' => array(
            'class' => array(),
            'src' => array(),
            'alt' => array(),
        ),
    ),
    'notification' => array(
        'insert_error' => esc_html__('Uncaught error, can not submit your listing.', 'yowel'),
        'insert_success' => esc_html__('Your submission is now on pending stage. You will be notified shortly', 'yowel'),
    ),
    'social_links' => array("twitter", "facebook", "googleplus", "linkedin", "pinterest"),
    'menu_caret' => '0',
    'text_domain' => 'yowel',
    'default_color' => '',
    'main_color' => '',
    'hover_color' => '',
    'border_color' => ''
);

$wpbucket_theme_config = apply_filters('wpbucket_theme_config', $wpbucket_theme_config);


function wpbucket_config_files_dir()
{
    return trailingslashit(WPBUCKET_THEME_DIR) . 'includes/configuration';
}

add_filter('wpbucket_config_files_dir', 'wpbucket_config_files_dir');

require_once WPBUCKET_THEME_DIR . '/core/core-includes.php';
include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-partials.php';
include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-actions.php';
include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-filters.php';
//include_once WPBUCKET_THEME_DIR . '/includes/wpbucket-demo-import.php';
include_once WPBUCKET_THEME_DIR . '/importer/importer.inc.php';
add_action( 'widgets_init', 'Wpbucket_Sidebars::wpbucket_custom_sidebar' );