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
        $featured_image = wpbucket_thumb($image_url, Wpbucket_Helpers::wpbucket_get_theme_related_image_sizes('blog_img')); //resize & crop the image
    } else {
        $featured_image = '';
    }
    
    if (WPBUCKET_META_BOX) {
        $images = rwmb_meta('wpbucket_image', array('link' => true));
        $style = rwmb_meta('wpbucket_radio');
        $gallery_html = '';
        if ($style == 'default' || $style == '') {
            $gallery_html .= '<div class="post_gallery">
                                    <div class="owl-carousel owl-theme post_gallery_carousel">';
            foreach ($images as $image) {
                $gallery_html .= '<div class="item">
                                            <a href="' . esc_url(get_the_permalink()) . '"><img src="' . esc_url($image['full_url']) . '" alt="img"></a>
                                        </div>';
            }
            $gallery_html .= '</div></div>';
        } else {
            $gallery_html .= '<div class="post_gallery">
                                    <div class="owl-carousel owl-theme post_gallery_tiled">';
            foreach ($images as $image) {
                $gallery_html .= '<div class="item">
                                            <img src="' . esc_url($image['full_url']) . '" alt="img">
                                            <p class="img_caption">' . esc_html($image['caption']) . '</p>
                                        </div>';
            }
            $gallery_html .= '</div></div>';
        }
        
        
    } else {
        $gallery_html = '';
    }
    
    $archive_year = get_the_time('Y');
    $archive_month = get_the_time('m');
    $archive_day = get_the_time('d');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog_post'); ?> >
    <div class="post_header">
        <h4 class="post_cat"><?php echo esc_html__('Category :', 'yowel'); ?> <?php echo Wpbucket_Partials::wpbucket_get_categories_lists(get_the_ID()); ?></h4>
        <h2 class="post_title"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </div>
    <?php if ($gallery_html == '') { ?>
        <?php if ($featured_image != '') { ?>
            <div class="post_img">
                <a href="<?php echo get_the_permalink(); ?>"><img src="<?php echo esc_url($image_url) ?>"
                                                                  alt="<?php echo esc_attr(get_the_title(get_the_ID())); ?>"></a>
            </div>
        <?php } ?>
    <?php } elseif ($gallery_html != '') {
        echo wp_kses( $gallery_html, $wpbucket_theme_config['allowed_html_tags'] ); 
    } ?>
    <div class="post_content">
        <div class="post_intro">
            <?php
                if (preg_match('/<!--more(.*?)?-->/', $post->post_content) || !has_excerpt()) {
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
                <li><span class="author">
                    <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                    <?php echo esc_html__('By','yowel');?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nickname')); ?>"><?php echo get_the_author(); ?></a></span>
                </li>
                <li><span class="date"><a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>"><?php echo get_the_date(); ?></a></span></li>
            </ul>
            
            <?php echo Wpbucket_Partials::wpbucket_generate_social_share_html('multi_social', get_the_ID()); ?>
        </div>
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
    </div>
</article>
