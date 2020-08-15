<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */

/*
 * Template name: Contact Page
 */
defined('ABSPATH') or die("-1");

get_header();
get_template_part('menu-section');
include_once WPBUCKET_THEME_DIR . '/page-title.php';
$map_show_hide = wpbucket_return_theme_option('map_area', '', 1);
if (WPBUCKET_META_BOX) {
    $value = rwmb_meta('wpbucket_shortcode_after_header');
    $value_after_content = rwmb_meta('wpbucket_shortcode_after_content');
    $value_before_footer = rwmb_meta('wpbucket_shortcode_before_footer');
    echo do_shortcode($value);
}
global $wpbucket_theme_config;
?>

<?php if (wpbucket_has_shortcode('vc_row') != true) { ?>
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-8 main-content blog_has_right_sidebar">
                        <?php if (have_posts()) : ?>

                            <?php
                            // Start the loop.
                            while (have_posts()) : the_post();

                                /*
                                 * Include the Post-Format-specific template for the content.
                                 * If you want to override this in a child theme, then include a file
                                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                 */
                                get_template_part('template-parts/content-page');

                                // End the loop.
                            endwhile;

                        // If no content, include the "No posts found" template.
                        else :
                            get_template_part('template-parts/content', 'none');

                        endif;
                        ?>

                    <div class="contact">
                        <?php if ($map_show_hide == 1) {
                            $left_multi_text = wpbucket_return_theme_option('wpbucket_contact_info', '', '');
                            if (!empty($left_multi_text)) {
                                $html = '<div class="keepintouch">';
                                foreach ($left_multi_text as $single_text) {
                                    $infos = explode('*', $single_text);
                                    $html .= '<div class="communication">
                                    <div class="info-body">
                                        <p>' . esc_html($infos[0]) . '</p>
                                        <h5>' . esc_html($infos[1]) . '</h5>
                                    </div>
                                </div>';
                                }
                                $html .= '</div>';
                            } else {
                                $html = '';
                            }
                            ?>
                            <div class="map-area">
                                <?php echo wp_kses( $html, $wpbucket_theme_config['allowed_html_tags'] );  ?>
                                <div id="googleMap2" class="map"></div>
                            </div>
                        <?php } ?>
                        <?php if (WPBUCKET_META_BOX) {
                            echo do_shortcode($value_after_content);
                        } ?>

                    </div>
                </div>
                <div class="col-md-4 sidebar">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
<?php } else {

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
} ?>
<?php
if (WPBUCKET_META_BOX) {
    echo do_shortcode($value_before_footer);
}
get_footer();
?>
