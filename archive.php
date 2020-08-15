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
include_once WPBUCKET_THEME_DIR . '/page-title.php';
?>
<div class="main-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-8 main-content blog_has_right_sidebar">
                <div class="blog-list">
                    <?php if (have_posts()) : ?>

                        <?php
                        // Start the loop.
                        while (have_posts()) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part('template-parts/content-archive');

                            // End the loop.
                        endwhile;

                    // If no content, include the "No posts found" template.
                    else :
                        get_template_part('template-parts/content', 'none');

                    endif;
                    ?>
                </div>
                <div class="pagination-div">
                    <?php echo Wpbucket_Partials::wpbucket_pagination('blog'); ?>
                </div>
            </div>
            <div class="col-md-4 sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<div style="display: none;">

    <?php
    the_tags();
    the_post_thumbnail();
    add_editor_style();
    ?>

</div>
<?php
get_footer();
?>
