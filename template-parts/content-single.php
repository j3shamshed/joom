<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: pranontheme
 * Website: http://webpentagon.com/
 */

$image_url = Wpbucket_Helpers::wpbucket_get_image_url(get_the_ID());

if (!empty($image_url)) {

    $featured_image = wpbucket_thumb($image_url, Wpbucket_Helpers::wpbucket_get_theme_related_image_sizes('blog_single')); //resize & crop the image
} else {
    $featured_image = '';
}
$query = new WP_Query(array('author' => get_the_author_meta('ID'), 'post__not_in' => array(get_the_ID())));
$archive_year  = get_the_time('Y'); 
$archive_month = get_the_time('m'); 
$archive_day   = get_the_time('d');

?>
<div class="blog-list">
    <article id="post-<?php the_ID(); ?>" <?php post_class('blog_post '); ?>>
        <div class="post_header">
            <h4 class="post_cat"><?php echo esc_html__('Category :', 'yowel'); ?> <?php echo Wpbucket_Partials::wpbucket_get_categories_lists(get_the_ID()); ?></h4>
            <h2 class="post_title"><?php the_title(); ?></h2>
        </div>
        <?php if ($featured_image != '') { ?>
            <div class="post_img">
                <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo esc_url($image_url) ?>"
                                                                  alt="<?php echo esc_attr(get_the_title(get_the_ID())); ?>"></a>
            </div>
        <?php } ?>
        <div class="post_content">
            <div class="full_content">
                <?php
    
                    the_content( sprintf(
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'yowel' ),
                        get_the_title()
                    ) );

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
                ?>
            </div>

            <div class="post_footer">
                <ul class="post_meta">
                    <li><span class="author">
                        <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                        <?php echo esc_html__('By','yowel');?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nickname')); ?>"><?php echo get_the_author(); ?></a></span>
                    </li>
                    <li><span class="date"><a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php echo get_the_date(); ?></a></span></li>
                </ul>

                <?php echo Wpbucket_Partials::wpbucket_generate_social_share_html('multi_social', get_the_ID()); ?>
            </div>
        </div>
    </article>
</div>
<div class="blog_author">
    <?php echo get_avatar(get_the_author_meta('ID'), 130); ?>
    <div class="blog_author_inner">
        <h4><a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nickname')); ?>"><?php echo get_the_author(); ?></a></h4>
        <h6><?php echo get_the_author_meta('expert_on'); ?></h6>
        <p><?php echo get_the_author_meta('description'); ?></p>
        <p><a href="<?php echo get_the_author_meta('user_url'); ?>"><?php echo get_the_author_meta('user_url'); ?></a></p>
        <p><?php echo get_the_author_meta('user_email'); ?></p>
    </div>
</div>
<!--
<div class="divider clearfix"></div>
<div class="like_posts">
    <h4 class="widget_title"><span><?php echo esc_html__('You amy also like', 'yowel'); ?></span></h4>
    <div class="row">
        <?php if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $image_url = Wpbucket_Helpers::wpbucket_get_image_url(get_the_ID());

                if (!empty($image_url)) {
                    $featured_image = wpbucket_thumb($image_url, Wpbucket_Helpers::wpbucket_get_theme_related_image_sizes('blog_single')); //resize & crop the image
                } else {
                    $featured_image = '';
                } ?>
                <div class="col-md-4">
                    <div class="like_post">
                        <?php if ($featured_image != '') { ?>
                            <img src="<?php echo esc_url($featured_image) ?>" alt="img">
                        <?php } ?>
                        <h4><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php the_title(); ?></a></h4>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata(); endif; ?>
    </div>
</div>
-->

<div class="divider clearfix"></div>
<?php
if (comments_open() || get_comments_number()) {
    comments_template();
}
?>
<div class="divider clearfix"></div>
<div class="inner_posts">
    <div class="row">
        <?php $prevPost = get_adjacent_post( false, '', true, 'category' );

        if (is_a( $prevPost, 'WP_Post' )) {
            $args = array(
                'posts_per_page' => 1,
                'include' => $prevPost->ID
            );
            $prevPost = get_posts($args);
            foreach ($prevPost as $post) {
                setup_postdata($post);
                ?>
                <div class="col-md-6">
                    <div class="inner-post prev_post">
                        <?php the_post_thumbnail('thumbnail'); ?>
                        <div class="post_block">
                            <a class="link_to"
                               href="<?php the_permalink(); ?>"><?php echo esc_html__('Previous Post', 'yowel') ?></a>
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </div>
                    </div>
                </div>
                <?php
                wp_reset_postdata();
            } //end foreach
        } // end if

        $nextPost = get_adjacent_post( false, '', false, 'category' );

        if (is_a( $nextPost, 'WP_Post' )) {
            $args = array(
                'posts_per_page' => 1,
                'include' => $nextPost->ID
            );
            $nextPost = get_posts($args);
            foreach ($nextPost as $post) {
                setup_postdata($post);
                ?>
                <div class="col-md-6">
                    <div class="inner-post next_post">
                        <?php the_post_thumbnail('thumbnail'); ?>
                        <div class="post_block">
                            <a class="link_to"
                               href="<?php the_permalink(); ?>"><?php echo esc_html__('Next Post', 'yowel') ?></a>
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </div>
                    </div>
                </div>
                <?php
                wp_reset_postdata();
            } //end foreach
        } // end if
        ?>
    </div>
</div>