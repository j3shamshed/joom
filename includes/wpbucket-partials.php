<?php
/*
 * ---------------------------------------------------------
 * Partials
 *
 * Class for functions that return text / HTML content
 * ----------------------------------------------------------
 */

class Wpbucket_Partials
{

    /**
     * Echo logo image HTML
     *
     * @global bool $vlc_is_retina
     * @param array $args
     * @return string
     */
    static function wpbucket_get_logo_image_html($args = array())
    {
        global $vlc_is_retina;

        $website_name = get_bloginfo('name');
        $logo_width   = '';
        $styles       = '';

        $logo        = wpbucket_return_theme_option('logo', 'url');
        $retina_logo = wpbucket_return_theme_option('retina_logo', 'url');

        if ($vlc_is_retina && !empty($retina_logo)) {
            $logo       = $retina_logo;
            $logo_width = wpbucket_return_theme_option('logo', 'width');
        } else if (!empty($logo)) {
            $logo_width = wpbucket_return_theme_option('logo', 'width');
        } else {
            $logo       = WPBUCKET_TEMPLATEURL."/images/logo.png";
            $logo_width = "138";
        }

        if (!empty($args) && $args ['float']) {
            $float  = $args ['float'];
            $styles = "style='float: {$float};'";
        }

        $logo = esc_url_raw($logo);
        if (has_custom_logo()) {
            $custom_logo_id = get_theme_mod('custom_logo');
            $logo           = wp_get_attachment_image_src($custom_logo_id,
                'full');
            $logo           = $logo[0];
        }



        $logo_img = "<img src='{$logo}' alt='{$website_name}'/>";

        return $logo_img;
    }

    /**
     * Returns HTML for logo
     *
     * @return string
     */
    static function wpbucket_generate_logo_html()
    {
        ob_start();
        ?>
        <!-- .logo start -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-logo">
            <?php
            echo static::wpbucket_get_logo_image_html();
            ?>
        </a>
        <!-- logo end -->
        <?php
        return ob_get_clean();
    }
    /*
     * Return Social Icons From Theme options
     *
     */

    static function wpbucket_generate_header_social_html($key)
    {
        $header_social     = wpbucket_return_theme_option($key, 'icon', '');
        $header_social_url = wpbucket_return_theme_option($key, 'text', '');
        if (isset($header_social)) {
            $html = '<div class="language">
                    <ul>';
            foreach ($header_social as $index => $icon) {
                $html .= '<li><a href="'.esc_url($header_social_url[$index]).'" class="circle-icon"><i class="'.esc_attr($icon).'"></i></a></li>';
            }
            $html .= '</ul></div>';
        } else {
            $html = '';
        }

        return $html;
    }
    /*
     * Return Social Share Option From Theme options
     *
     */

    /**
     * Footer Logo
     *
     * */
    static function wpbucket_get_footerlogo_image_html($args = array())
    {
        global $vlc_is_retina;

        $website_name     = get_bloginfo('name');
        $footerlogo_width = '';
        $styles           = '';

        $footerlogo        = wpbucket_return_theme_option('footerlogo', 'url');
        $retina_footerlogo = wpbucket_return_theme_option('retina_footerlogo',
            'url');

        if ($vlc_is_retina && !empty($retina_footerlogo)) {
            $footerlogo       = $retina_footerlogo;
            $footerlogo_width = wpbucket_return_theme_option('footerlogo',
                'width');
        } else if (!empty($footerlogo)) {
            $footerlogo_width = wpbucket_return_theme_option('footerlogo',
                'width');
        } elseif (get_theme_mod('wpbucket_footer_logo_control')) {
            $footerlogo = get_theme_mod('wpbucket_footer_logo_control');
        } else {
            $footerlogo       = WPBUCKET_TEMPLATEURL."/images/logo-footer.png";
            $footerlogo_width = "138";
        }

        if (!empty($args) && $args ['float']) {
            $float  = $args ['float'];
            $styles = "style='float: {$float};'";
        }

        $footerlogo = esc_url_raw($footerlogo);

        $footerlogo_img = "<img src='{$footerlogo}' alt='{$website_name}'/>";

        return $footerlogo_img;
    }

    /**
     * Returns HTML for footerlogo
     *
     * @return string
     */
    static function wpbucket_generate_footerlogo_html()
    {
        ob_start();
        ?>
        <!-- .footerlogo start -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-logo">
            <?php
            echo static::wpbucket_get_footerlogo_image_html();
            ?>
        </a>
        <!-- footerlogo end -->
        <?php
        return ob_get_clean();
    }

    /**
     * Blog content search form
     *
     * @return string
     */
    static function wpbucket_get_content_serch_form()
    {
        $form = '<form class="search-form" action="'.esc_url(home_url('/')).'">
                                <input type="text" name="s" class="form-control" placeholder="Search">
                                <button type="submit" class="form-control form-control-submit"></button>
                                <span class="search-label"><i class="icon icon-search"></i></span>
                            </form>';
        return $form;
    }

    /**
     * Renders main menu in header.
     * apply_filters('wpbucket_main_menu_location', 'primary')
     * @return type string
     */
    static function wpbucket_generate_menu_html()
    {
        ob_start();

        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu' => 'Primary Menu',
            'depth' => 11,
            'container' => '',
            'container_class' => '',
            'container_id' => '',
            'menu_class' => 'main-menu',
            'fallback_cb' => 'Wpbucket_Theme_Menu_Walker::fallback',
            'walker' => new Wpbucket_Theme_Menu_Walker (),
        ));

        return ob_get_clean();
    }

    /**
     * Renders footer menu in footer.
     *
     * @return type string
     */
    static function wpbucket_generate_footer_menu()
    {
        ob_start();
        wp_nav_menu(array(
            'theme_location' => 'footer',
            'container' => false,
            'depth' => 11,
            'items_wrap' => '<ul id="%1$s" class="main-menu">%3$s</ul>',
            'walker' => new Wpbucket_Theme_Footer_Menu_Walker (),
            'fallback_cb' => false,
        )); // argument added to distinguish regular menu with responsive
        return ob_get_clean();
    }

    /**
     * Paginate function for Blog and Portfolio
     *
     * @global object $wp_query
     * @global object $wp_rewrite
     * @param string $location
     */
    static function wpbucket_pagination($location)
    {
        global $wp_query, $wp_rewrite, $wpbucket_theme_config;

        $pages      = '';
        $pagination = '';
        $max        = $wp_query->max_num_pages;

        // if variable paged isn't set
        if (!$current = get_query_var('paged')) $current = 1;

        // set parameters
        $args = array(
            'base' => str_replace('%wpbucket_lol%',
                1 == $current ? '' : "?paged=%#%", "?paged=%#%"),
            'format' => '?paged=%#%',
            'total' => $max,
            'current' => $current,
            'show_all' => true,
            'type' => 'array',
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'prev_next' => false,
            'mid_size' => 3,
            'end_size' => 1
        );
        if ($location == 'portfolio') {
            $args ['base'] = @add_query_arg('page', '%#%');

            // check if permalinks are used
            if ($wp_rewrite->using_permalinks())
                    $args ['base']     = user_trailingslashit(trailingslashit(remove_query_arg('s',
                            get_pagenum_link(1))).'page/%#%/', 'paged');
            if (!empty($wp_query->query_vars ['s']))
                    $args ['add_args'] = array(
                    's' => get_query_var('s')
                );
        }

        $previous_label = esc_html__('&#60; Previous', 'yowel');
        $next_label     = esc_html__('Next &#62;', 'yowel');

        // previous and next links html
        $prev_page_link = $current == 1 ? "<li class=\"disabled previous\"><a  href='#' > <i class=\"arrow_left\"></i></a></li>"
                : "<li><a  href='".get_pagenum_link($current - 1)."'> <i class=\"arrow_left\"></i></a></li>";
        $next_page_link = $current == $max ? "<li class=\"disabled next\"><a  href='#' > <i class=\"arrow_right\"></i></a></li>"
                : "<li><a  href='".get_pagenum_link($current + 1)."'> <i class=\"arrow_right\"></i></a></li>";

        // get page link
        $pagination_links = paginate_links($args);
        // loop through pages
        if (!empty($pagination_links)) {
            foreach ($pagination_links as $index => $link) {

                $link = str_replace('</span>', '</a>', $link);
                $link = str_replace('<span', '<a', $link);

                $pagination .= "<li ".(($index + 1) == $current ? ">" : ">").$link."</li>";
            }
        }

        // if there is more then one page send html to browser
        if ($max > 1) {
            if ($location == 'portfolio' || $location == 'blog_timeline') {
                $container = 'div';
            } else {
                $container = 'ul';
            }

            $pagination_html = "<{$container} class='pagination clearfix'>
                        
                     
                        {$pagination}
                       
                        
                      </{$container}>";

            if ($location == 'portfolio') {
                echo "<div class='row'><div class='col-md-12'>".$pagination_html."</div></div>";
            } else {
                echo wp_kses($pagination_html,
                    $wpbucket_theme_config['allowed_html_tags']);
            }
        }
    }

    /**
     * Echo post author html
     *
     */
    static function wpbucket_post_author_html()
    {

        if (wpbucket_return_theme_option('blog_single_show_author', '', 0) == '1') :
            $about_the_author    = wpbucket_return_theme_option('blog_single_author_section_title');
            $avatar_size         = 100;
            $post_author_id      = get_the_author_meta('ID');
            $post_author_bio     = get_the_author_meta('description');
            $post_author_name    = get_the_author_meta('display_name');
            $post_author_website = get_the_author_meta('user_url');
            ?>
            <section id="about-author">
                <header><h3><?php echo esc_html__('About the Author', 'yowel'); ?></h3></header>
                <div class="post-author">
                    <?php
                    echo get_avatar($post_author_id, $avatar_size);
                    ?>
                    <div class="wrapper">
                        <header><?php echo esc_html($post_author_name) ?></header>
                        <p><?php echo esc_html($post_author_bio) ?></p>
                    </div>
                </div>
            </section>

            <?php
        endif;
    }

    /**
     * Template for comments and pingbacks.
     *
     * @param object $comment
     * @param array $args
     * @param int $depth
     */
    static function wpbucket_render_comments($comment, $args, $depth)
    {
        $GLOBALS ['comment'] = $comment;

        switch ($comment->comment_type) {
            case 'pingback' :
            case 'trackback' :
                ?>
                <div class="post pingback">
                    <p>
                        <?php esc_html_e('Pingback',
                            'yowel');
                        ?><?php comment_author_link(); ?><?php
                        edit_comment_link(esc_html__('Edit', 'yowel'),
                            '<span class="edit-link">', '</span>');
                        ?>
                    </p>
                    <?php
                    break;
                default :
                    ?>

                    <li id="li-comment-<?php comment_ID(); ?>" class="blog-comment-user">

                        <div class="commenter-div">
                            <div class="commenter">
                                <?php
                                $avatar_size = 65;
                                echo get_avatar($comment, $avatar_size, false,
                                    get_comment_author());
                                ?>
                            </div>
                            <div class="comment-block">
                                <h4><?php comment_author(); ?> <span class="reply"><?php
                                        comment_reply_link(array_merge($args,
                                                array('reply_text' => (esc_html__('Reply',
                                                        'yowel').''),
                                                    'depth' => $depth, 'max_depth' => $args['max_depth'])));
                                        ?></span></h4>
                                <h6><span><?php echo comment_time(); ?> .</span> <?php echo get_comment_date(); ?></h6>
                                <p><?php comment_text(); ?></p>
                                <?php
                                if ($comment->comment_approved == '0') {
                                    ?>
                                    <p class='unapproved'><?php
                                        _e('Your comment is awaiting moderation.',
                                            'yowel');
                                        ?></p>
                <?php } ?>
                            </div>
                        </div>
                        <?php
                        break;
                }
            }

            /**
             * Template for comments and pingbacks for review.
             *
             * @param object $comment
             * @param array $args
             * @param int $depth
             */
            static function wpbucket_render_review_comments($comment, $args,
                                                            $depth)
            {
                $GLOBALS ['comment'] = $comment;
                $rate                = get_comment_meta($comment->comment_ID,
                    'wpbucket_rate');
                switch ($comment->comment_type) {
                    case 'pingback' :
                    case 'trackback' :
                        ?>
                    <li class="post pingback">
                        <p>
                            <?php
                            esc_html_e('Pingback', 'yowel');
                            ?><?php comment_author_link(); ?><?php
                            edit_comment_link(esc_html__('Edit', 'yowel'),
                                '<span class="edit-link">', '</span>');
                            ?>
                        </p>
                        <?php
                        break;
                    default :
                        ?>

                    <li id="li-comment-<?php comment_ID(); ?>" class="review">
                        <div class="image">
                            <div class="bg-transfer">  <?php
                                $avatar_size = 70;
                                echo get_avatar($comment, $avatar_size, false,
                                    get_comment_author());
                                ?></div>
                        </div>
                        <div class="description">
                            <figure>
                                <div class="rating-passive" data-rating="<?php echo esc_attr($rate[0]) ?>"
                                     data-scal="<?php
                                     echo esc_attr(wpbucket_return_theme_option('review_scale',
                                             '', 10));
                                     ?>">
                                    <span><?php comment_author(); ?></span>
                                    <span class="stars"></span>
                                </div>
                                <span class="date"><?php echo get_comment_date(); ?></span>
                            </figure>
                            <p> <?php
                                comment_text();
                                ?>
                            </p>
                            <?php
                            if ($comment->comment_approved == '0') {
                                ?>
                                <p class='unapproved'><?php
                                    _e('Your comment is awaiting moderation.',
                                        'yowel');
                                    ?></p>
                        <?php } ?>
                        </div>
                        <?php
                        break;
                }
            }

            /**
             * Template for categories dropdown.
             */
            static function wpbucket_get_categories_dropdown()
            {
                $terms = get_terms(array(
                    'taxonomy' => 'location-category',
                    'hide_empty' => false,
                ));

                if (!is_wp_error($terms)) {
                    $select_html = '<option value="">Category</option>';
                    foreach ($terms as $term) {
                        $select_html .= '<option value="'.esc_attr($term->name).'">'.esc_html($term->name).'</option>';
                    }
                } else {
                    $select_html = '';
                }

                return $select_html;
            }

            /**
             * Template for categories lists.
             *
             * @param $post_id
             * @param $no_icon for fontawesome control
             * @param $taxonomy for custom taxonomy
             */
            static function wpbucket_get_categories_lists($post_id,
                                                          $no_icon = NULL,
                                                          $taxonomy = null)
            {
                if ($taxonomy == null) {
                    $getCats = get_the_category($post_id);
                } else {
                    $getCats = get_the_terms($post_id, $taxonomy);
                }

                if (is_array($getCats)) {
                    $html = '';
                    foreach ($getCats as $key => $cat) {
                        if (count($getCats) == 1 || $key == count($getCats) - 1) {
                            $coma = '';
                        } else {
                            $coma = ', ';
                        }
                        if ($taxonomy == null) {
                            $html .= '<a href="'.get_category_link($cat->term_id).'">'." ".$cat->name.' </a>'.$coma;
                        } else {
                            $html .= '<a href="'.get_term_link($cat->term_id,
                                    $taxonomy).'">'." ".$cat->name.' </a>'.$coma;
                        }
                    }
                } else {
                    $html = "";
                }
                return $html;
            }

            /**
             * Template for tags lists.
             *
             * @param $post_id
             */
            static function wpbucket_get_tags_lists($post_id)
            {
                $getTerms = wp_get_post_terms($post_id);
                $count    = count($getTerms);
                $html     = '';
                if ($count > 0) {
                    $html .= '<h2>'.esc_html__('Features', 'yowel').'</h2><ul class="tags">';
                    foreach ($getTerms as $key => $value) {
                        $html .= '<li> <a href="'.get_tag_link($value->term_id).'">'.trim($value->name).'</a></li>';
                    }
                    $html .= '</ul>';
                }
                return $html;
            }

            /**
             * Template for tags lists.
             *
             * @param $post_id
             */
            static function wpbucket_get_tags_checkbox()
            {
                $terms = get_tags(array(
                    'hide_empty' => true,
                ));

                if (!is_wp_error($terms)) {
                    $select_html = '<ul class="checkboxes">';
                    foreach ($terms as $term) {
                        $select_html .= '<li>
                                        <div class="form-group">
                                            <label class="no-margin"><input type="checkbox" name="wpbucket_submit_features[]" value="'.esc_attr($term->name).'">'.esc_html($term->name).'</label>
                                        </div>
                                    </li>';
                    }
                    $select_html .= '</ul>';
                } else {
                    $select_html = '';
                }

                return $select_html;
            }
            /*
             * Return Social Icons From Theme options
             *
             */

            static function wpbucket_generate_social_html($key)
            {
                $social     = wpbucket_return_theme_option($key, 'icon', '');
                $social_url = wpbucket_return_theme_option($key, 'text', '');
                if (isset($social)) {
                    $html = '<div class="footer_social">
                    <ul class="footer_social_list">';
                    foreach ($social as $index => $icon) {
                        $html .= '<li><a href="'.esc_url($social_url[$index]).'" class="circle-icon"><i class="'.esc_attr($icon).'"></i></a></li>';
                    }
                    $html .= '</ul></div>';
                } else {
                    $html = '';
                }

                return $html;
            }
            /*
             * Return Social Share Option From Theme options
             *
             */

            static function wpbucket_generate_social_share_html($key, $id)
            {
                $url            = array(
                    'fa-facebook' => 'http://www.facebook.com/sharer.php?u=',
                    'fa-google-plus' => 'https://plus.google.com/share?url=',
                    'fa-twitter' => 'https://twitter.com/intent/tweet?url=',
                    'fa-linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=',
                    'fa-pinterest' => 'http://pinterest.com/pin/create/button/?url=',
                );
                $social_classes = wpbucket_return_theme_option($key, '', '');
                $social_active  = wpbucket_return_theme_option('show_social_share',
                    '', '');
                if (isset($social_classes) && $social_active == 1) {
                    $html = '<div class="post_share">
                <ul class="share_list">';
                    foreach ($social_classes as $index => $icon) {
                        if ($icon == 1) {
                            $html .= '<li><a href="'.esc_url($url[$index].get_permalink($id)).'"><i class="fa '.esc_attr($index).'"></i></a></li>';
                        }
                    }
                    $html .= '</ul></div>';
                } else {
                    $html = '';
                }

                return $html;
            }
        }