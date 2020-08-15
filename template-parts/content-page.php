<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: pranontheme
 * Website: http://webpentagon.com/
 */
global $wpbucket_theme_config;
$image_url = Wpbucket_Helpers::wpbucket_get_image_url(get_the_ID());

if (!empty($image_url)) {

    $featured_image = wpbucket_thumb($image_url, Wpbucket_Helpers::wpbucket_get_theme_related_image_sizes('blog_single')); //resize & crop the image
} else {
    $featured_image = '';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="about_author">
    <?php if ($featured_image != '') { ?>
        <img src="<?php echo esc_url($image_url) ?>" alt="<?php echo esc_attr(get_the_title(get_the_ID())); ?>">
    <?php } ?>
    <div class="full_content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'yowel') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'yowel') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));

        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'yowel'),
                get_the_title()
            ),
            '<div class="entry-footer"><span class="edit-link">',
            '</span></div><!-- .entry-footer -->'
        );

        
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        
        ?>
    </div>
    </div>
</article>