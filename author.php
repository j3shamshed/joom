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

$image_url = Wpbucket_Helpers::wpbucket_get_image_url(get_the_ID());

if (!empty($image_url)) {

    $featured_image = wpbucket_thumb($image_url, Wpbucket_Helpers::wpbucket_get_theme_related_image_sizes('blog_img')); //resize & crop the image
} else {
    $featured_image = '';
}
$archive_year  = get_the_time('Y'); 
$archive_month = get_the_time('m'); 
$archive_day   = get_the_time('d');
?>
<div class="main-wrapper">
    <div class="container">
    	<div class="blog_author">
            <?php echo get_avatar(get_the_author_meta('ID'), 130); ?>
			<div class="blog_author_inner">
				<h4><?php echo get_the_author(); ?></h4>
				<h6><?php echo get_the_author_meta('expert_on');  ?></h6>
				<p><?php echo get_the_author_meta('description'); ?></p>
				<p><a href="<?php echo get_the_author_meta('user_url'); ?>"><?php echo get_the_author_meta('user_url'); ?></a></p>
				<p><?php echo get_the_author_meta('user_email'); ?></p>
			</div>
        </div>

        <div class="row">
            <div class="col-md-8 main-content blog_has_right_sidebar">
                <div class="blog-list">

	                <div class="author-posts-content">
						<!-- The Loop -->

					    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					        <article id="post-<?php the_ID(); ?>" <?php post_class('blog_post '); ?> >
					            <div class="post_header">
					                <h4 class="post_cat"><?php echo esc_html__('Category :', 'yowel'); ?> <?php echo Wpbucket_Partials::wpbucket_get_categories_lists(get_the_ID()); ?></h4>
					                <h2 class="post_title"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
					            </div>
						        <?php if ($featured_image != '') { ?>
						            <div class="post_img">
						                <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo esc_url($featured_image) ?>"
						                                                                  alt="<?php echo esc_attr(get_the_title(get_the_ID())); ?>"></a>
						            </div>
						        <?php } ?>

						        <div class="post_content">
						            <div class="post_intro">
						                <?php
						                if (preg_match('/<!--more(.*?)?-->/', $post->post_content)) {
						                    the_content();
						                } else {
						                    '<p>' . the_excerpt() . '</p>';
						                }

						                wp_link_pages(array(
						                    'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'yowel') . '</span>',
						                    'after' => '</div>',
						                    'link_before' => '<span>',
						                    'link_after' => '</span>',
						                    'pagelink' => '<span class="screen-reader-text">' . __('Page', 'yowel') . ' </span>%',
						                    'separator' => '<span class="screen-reader-text">, </span>',
						                ));
						                ?>
						            </div>
						            <div class="post_footer">
						                <ul class="post_meta">
						                    <li><span class="date"><a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php echo get_the_date(); ?></a></span></li>
						                </ul>
							            <?php edit_post_link(
							                sprintf(
							                /* translators: %s: Name of current post */
							                    __('Edit<span class="screen-reader-text"> "%s"</span>', 'yowel'),
							                    get_the_title()
							                ),
							                '<div class="entry-footer"><span class="edit-link">',
							                '</span></div><!-- .entry-footer -->'
							            );
							            ?>
							            <?php echo Wpbucket_Partials::wpbucket_generate_social_share_html('multi_social',get_the_ID()); ?>
						            </div>
						        </div>
						    </article>

					    <?php endwhile; else: ?>
					        <p><?php echo esc_html__('No posts by this author.', 'yowel'); ?></p>

					    <?php endif; ?>

						<!-- End Loop -->

	                </div>
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
