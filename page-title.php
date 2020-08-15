<?php
/**
 * Copyright (c) 26/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */

/*
global $wpbucke_theme_config;
$title_classes = '';
$page_id = get_the_ID();

// breadcrumbs
$show_breadrumbs = wpbucket_return_theme_option('show_breadcrumbs', '', '1');

$page_title_alignment = get_post_meta($page_id, 'page_alignment', true);
$page_title_show_hide = get_post_meta($page_id, 'page_show_hide', true);
if (!isset($page_title_show_hide)) {
    $page_title_show_hide = 1;
}
$vlc_page_title = '';
$sub_title = '';
if (wpbucket_return_theme_option('sologan_show', '', 1) == 1) {
    $sub_title = '<h6>' . wpbucket_return_theme_option('wpbucket_sologan') . '</h6>';
}
if (is_archive()) {
    $vlc_page_title = get_the_archive_title();
} elseif (is_tag()) {
    $vlc_page_title = single_tag_title();
} elseif (is_category()) {
    $vlc_page_title = single_cat_title();
} elseif (is_search()) {
    if (get_search_query() == 'wp-location') {
        $vlc_page_title = esc_html__("Search Result.", 'yowel');
    } else
        $vlc_page_title = esc_html__("Search Result For: ", 'yowel') . get_search_query();
} elseif (is_singular('pi_team')) {
    $vlc_page_title = esc_html(wpbucket_return_theme_option('wpbucket_team_single_title', '', 'Team Details'));
} elseif (is_singular('pi_services')) {
    $vlc_page_title = esc_html(wpbucket_return_theme_option('wpbucket_service_single_title', '', 'Service Details'));
} elseif (is_singular('pi_portfolio')) {
    $vlc_page_title = esc_html(wpbucket_return_theme_option('wpbucket_project_single_title', '', 'Project Details'));
} elseif (is_single()) {
    $vlc_page_title = esc_html__('Post Details', 'yowel');
} elseif ($vlc_page_title == '') {
    if (is_front_page()) {
        $vlc_page_title = get_bloginfo('name');
    } elseif (is_home()) {
        $vlc_page_title = get_the_title(get_option('page_for_posts'));
    } else {
        $vlc_page_title = get_the_title($page_id);
    }

}
*/
?>
<!--<div class="page-title">
    <div id="particles-js-pagetitle"></div>
    <div class="container">
        <h1><?php /*if(is_author()){ print $vlc_page_title; }else echo esc_html($vlc_page_title); */?></h1>
        <?php /*print $sub_title; */?>
    </div>
</div>-->
