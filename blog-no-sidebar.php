<?php
/**
 * Created by PhpStorm.
 * User: j3sha
 * Date: 7/15/2018
 * Time: 12:18 PM
 */
/*
 * Template name: Blog No sidebar
 */

defined('ABSPATH') or die("No script kiddies please!");

get_header();
get_template_part('menu-section');
include_once WPBUCKET_THEME_DIR . '/page-title.php';
if (WPBUCKET_META_BOX) {
    $value = rwmb_meta('wpbucket_shortcode_after_header');
    $value_after_content = rwmb_meta('wpbucket_shortcode_after_content');
    $value_before_footer = rwmb_meta('wpbucket_shortcode_before_footer');
    echo do_shortcode($value);
}
?>
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12 main-content">
                    <div class="blog-list">
                        <?php if (have_posts()) :

                            $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

                            $args = array(
                                'posts_per_page' => get_option('posts_per_page'),
                                'paged' => $paged
                            );

                            $wp_query = new WP_Query($args);
                            // Start the loop.
                            while ($wp_query->have_posts()) :
                                $wp_query->the_post();
                                /*
                                * Include the Post-Format-specific template for the content.
                                * If you want to override this in a child theme, then include a file
                                * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                */
                                get_template_part('template-parts/content',get_post_format());

                                // End the loop.
                            endwhile;

                        // If no content, include the "No posts found" template.
                        else :
                            get_template_part('template-parts/content', 'none');

                        endif;
                        ?>
                        <?php if (WPBUCKET_META_BOX) {
                            echo do_shortcode($value_after_content);
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
if (WPBUCKET_META_BOX) {
    echo do_shortcode($value_before_footer);
}
get_footer();
?>