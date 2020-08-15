<?php

/* ---------------------------------------------------------
 * Ations
 *
 * Class for registering filters
  ---------------------------------------------------------- */

class Wpbucket_Theme_Filters
{

    static $hooks = array();

    /**
     * Initialize filters
     */
    static function init()
    {

        /**
         * Array of filter hooks
         *
         * Usage:
         *
         * 'filter_name' => array(
         *      'callback' => array( priority, accepted_args )
         * )
         *
         * When 'callback' value is empty (non-array) or any of values ommited,
         * default priority and accepted args will be used
         *
         * e.g.
         * priority = 10
         * accepted_args = 1
         */
        static::$hooks = array(
            // WORDPRESS FILTERS
            'admin_body_class' => array(
                'Wpbucket_Theme_Filters::wpbucket_admin_body_class'
            ),
            'body_class' => array(
                'Wpbucket_Theme_Filters::wpbucket_body_class'
            ),
            'excerpt_length' => array(
                'Wpbucket_Theme_Filters::wpbucket_excerpt_length'
            ),
            'wp_page_menu_args' => array(
                'Wpbucket_Theme_Filters::wpbucket_page_menu_args'
            ),
            'comment_form_defaults' => array(
                'Wpbucket_Theme_Filters::wpbucket_get_comment_form'
            ),
            'tiny_mce_before_init' => array(
                'Wpbucket_Theme_Filters::wpbucket_add_tinymce_tables'
            ),
            'pre_get_posts' => array(
                'Wpbucket_Theme_Filters::wpbucket_aadd_custom_post_type_to_query'
            ),
            'override_load_textdomain' => array(
                'Wpbucket_Theme_Filters::wpbucket_override_load_textdomain' => array(5, 3)
            ),
            // THEME AND FRAMEWORK FILTERS
            'vcpt_register_custom_post_types' => array(
                'Wpbucket_Theme_Filters::wpbucket_register_custom_post_types'
            ),
            'wpbucket_blog_style' => array(
                'Wpbucket_Theme_Filters::wpbucket_search_page_blog_style'
            ),
            'masterslider_disable_auto_update' => array(
                'Wpbucket_Theme_Filters::wpbucket_disable_master_slider_update_notifications'
            ),
            'wp_list_categories' => array(
                'Wpbucket_Theme_Filters::wpbucket_wp_list_categories'
            ),
            'get_archives_link' => array(
                'Wpbucket_Theme_Filters::wpbucket_get_archives_link'
            ),
            'get_search_form' => array(
                'Wpbucket_Theme_Filters::wpbucket_get_search_form'
            ),
			'the_password_form'=>array(
				'Wpbucket_Theme_Filters::wpbucket_get_password_protect_form'
			),
            'user_contactmethods'=>array('Wpbucket_Theme_Filters::wpbucket_add_user_social_link')
        );

        if (shortcode_exists('ssba')) {
            static::$hooks['ssba_html_output'] = array(
                'Wpbucket_Theme_Filters::remove_ssba_from_content' => array(10, 2)
            );
        }

        // register filters
        wpbucket_register_hooks(static::$hooks, 'filter');
    }

    /**
     * Filter post types configuration where we register
     * post types that are needed in theme
     *
     * @param array $post_types_config Array with post types
     * @return array Array with configuration
     */
    static function wpbucket_register_custom_post_types($post_types_config)
    {

        $post_types_config = array(
            'pi_portfolio' => array(
                'cpt' => '0',
                'taxonomy' => '0'
            ),
            'pi_services' => array(
                'cpt' => '0',
                'taxonomy' => '0'
            )
        );

        return $post_types_config;
    }

    /**
     * Title customization
     *
     * @global int $page
     * @global int $paged
     * @global object $post
     * @param string $title
     * @param string $sep
     * @return string
     */
    static function wpbucket_wp_title($title, $sep)
    {
        if (is_feed()) {
            return $title;
        }

        global $page, $paged, $post;

        $title_name = get_bloginfo('name', 'display');
        $site_description = get_bloginfo('description', 'display');

        if ($site_description && (is_home() || is_front_page())) {
            $title = "$title_name $sep $site_description";
        } elseif (is_page()) {
            $title = get_the_title($post->ID);
            if (($paged >= 2 || $page >= 2) && !is_404()) {
                $title .= " $sep " . sprintf(esc_html__('Page %s', 'yowel'), max($paged, $page));
            }
        } elseif (($paged >= 2 || $page >= 2) && !is_404()) {
            $title = "$title_name $sep " . sprintf(esc_html__('Page %s', 'yowel'), max($paged, $page));
        } elseif (is_author()) {
            $author = get_queried_object();
            $title = $author->display_name;
        } elseif (is_search()) {
            $title = 'Search results for: ' . get_search_query() . '';
        }

        return $title;
    }

    /**
     * Overrides the load textdomain functionality when 'yowel' is the domain in use.  The purpose of
     * this is to allow theme translations to handle the framework's strings.  What this function does is
     * sets the 'yowel' domain's translations to the theme's.
     *
     * @global type $l10n
     * @param boolean $override
     * @param type $domain
     * @param type $mofile
     * @return boolean
     */
    static function wpbucket_override_load_textdomain($override, $domain, $mofile)
    {

        if ($domain == 'yowel') {
            global $l10n;

            $theme_text_domain = wpbucket_get_theme_textdomain();

            // If the theme's textdomain is loaded, use its translations instead.
            if ($theme_text_domain && isset($l10n[$theme_text_domain]))
                $l10n[$domain] = $l10n[$theme_text_domain];

            // Always override.  We only want the theme to handle translations.
            $override = true;
        }

        return $override;
    }

    /**
     * Add class "wpbucket-portfolio-not-active" to create/edit page screen if
     * Custom Post Types plugin isn't active
     *
     * @global type $pagenow
     * @global type $typenow
     * @param string $classes Body classes to filter
     * @return string All body classes
     */
    static function wpbucket_admin_body_class($classes)
    {
        global $pagenow, $typenow;

        if (is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php') && $typenow == 'page') {
            $classes .= 'wpbucket-cpts-not-active';
        }

        return $classes;
    }

    static function wpbucket_body_class($classes)
    {
        if (is_front_page() || is_page_template( 'frontpage.php' ) ){
            $classes[] = 'homepage';
        }elseif(is_singular('pi_location')){
            $classes[] = 'subpage-detail';
        }
        $classes[]=wpbucket_return_theme_option('wpbucket_navigation_options','','');
        return $classes;
    }

    /**
     * Sets the post excerpt length to 40 words.
     *
     * To override this length in a child theme, remove the filter and add your own
     * function tied to the excerpt_length filter hook.
     *
     * @param int $length
     * @return int
     */
    static function wpbucket_excerpt_length($length)
    {
        return 40;
    }

    /**
     * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
     *
     * @param array $args
     * @return boolean
     */
    static function wpbucket_page_menu_args($args)
    {
        $args['show_home'] = true;
        return $args;
    }

    /**
     * Tags widget customizations
     *
     * @param array $args
     * @return array
     */
    static function wpbucket_tag_cloud_args($args)
    {
        $args['smallest'] = 11;
        $args['largest'] = 11;
        $args['unit'] = "px";
        return $args;
    }

    /**
     * Comment Form styling
     *
     * @param array $fields
     * @return array
     */
    static function wpbucket_get_comment_form($fields)
    {

        // get current commenter data
        $commenter = wp_get_current_commenter();

        // check if field is required
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true' required" : '');

        // change fields style

        $fields['comment_field'] = '<div class="col-md-12"><div class="form-group"><textarea name="comment" class="form-control" id="comment-message" rows="8" tabindex="4" aria-required="true" required placeholder="Comment"></textarea></div></div>';
        $fields['fields']['author'] = '<div class="col-md-4"><div class="form-group">' .
            '<input type="text" name="author" class="form-control" id="comment-name" value="' . esc_attr($commenter['comment_author']) . '" size="22" tabindex="1"' . $aria_req . ' placeholder="Name"/></div></div>';

        $fields['fields']['email'] = '<div class="col-md-4"><div class="form-group">' .
            '<input type="email" name="email" class="form-control" id="comment-email" value="' . esc_attr($commenter['comment_author_email']) . '" size="22" tabindex="2" ' . $aria_req . '  placeholder="Email address"/></div></div>';

        $fields['fields']['url'] = '<div class="col-md-4"><div class="form-group">' .
            '<input type="url" name="url" class="form-control" id="comment-url" value="' . esc_attr($commenter['comment_author_url']) . '" size="22" tabindex="2" ' . $aria_req . '  placeholder="Website address"/></div></div>';
        return $fields;
    }

    /**
     * Intercept Simple Share Buttons Adder output.
     *
     * @param string $content
     * @param bool $using_shortcode
     * @return string
     */
    static function wpbucket_remove_ssba_from_content($content, $using_shortcode)
    {

        if (!$using_shortcode && (is_page() || is_singular('pi_portfolio'))) {
            $content = "<section class='page-content'>"
                . "<section class='container'>"
                . "<div class='row'>"
                . "<div class='col-md-12'>"
                . $content
                . "</div></seection></section>";
        }

        return $content;
    }

    /**
     * Edit Tinymce settings i.e. add custom classes for Tables in Editor
     *
     * @param array $settings Tinymce settings
     * @return array
     */
    static function wpbucket_add_tinymce_tables($settings)
    {
        $new_styles = array(
            array(
                'title' => 'None',
                'value' => ''
            ),
            array(
                'title' => 'Events',
                'value' => 'events-table',
            )
        );
        $settings['table_class_list'] = json_encode($new_styles);
        return $settings;
    }

    /**
     * Set blog style to "Large" for Search results page
     *
     * @param string $style Blog style
     * @return string
     */
    static function wpbucket_search_page_blog_style($style)
    {

        // set Large blog style
        if (is_search()) {
            $style = 'blog-post-large';
        }

        return $style;
    }

    /**
     * Disabled Master Slider update notifications
     * because user needs to have valid purchase code
     *
     * @return string
     */
    static function wpbucket_disable_master_slider_update_notifications()
    {
        return true;
    }

    /**
     * Widget categories and archive count html change
     *
     * @param string $links
     * @return string
     */
    static function wpbucket_wp_list_categories($links)
    {
        $links = str_replace('</a> (', '<span class="cat-count">(', $links, $count);
        if ($count > 0) {
            $links = str_replace(')', ')</span></a>', $links);
        }

        return $links;
    }

    /**
     * Widget archive modification
     *
     * @param string $links
     * @return string
     */
    static function wpbucket_get_archives_link($links)
    {
        $links = str_replace('</a>&nbsp;(', '<span class="cat-count">(', $links, $count);
        if ($count > 0) {
            $links = str_replace(')', ')</span></a>', $links);
        }
        return $links;
    }

    /**
     * Return search form HTML
     * @param bool $echo
     * @return string
     */
    static function wpbucket_get_search_form($echo = true)
    {
        $format = current_theme_supports('html5', 'search-form') ? 'html5' : 'xhtml';
        $format = apply_filters('search_form_format', $format);

        if ('html5' == $format) {

            $form = '<form class="sidebar_search_form" action="' . esc_url(home_url('/')) . '">
                                    <input type="text" name="s" class="form-control" placeholder="Search">
                                    <button type="submit" class="form-control form-control-submit"><i class="icon icon-search"></i></button>
                                </form>';
        } else {
            $form = '<form class="sidebar_search_form" action="' . esc_url(home_url('/')) . '">
                                    <input type="text" name="s" class="form-control" placeholder="Search">
                                    <button type="submit" class="form-control form-control-submit"><i class="icon icon-search"></i></button>
                                </form>';
        }

        return $form;
    }
	
		/**
     * Return search form HTML
     * @param bool $echo
     * @return string
     */
	static function wpbucket_get_password_protect_form(){
		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );

		$o = '<form class="sidebar_search_form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
                                    <input type="password" name="post_password" class="form-control" placeholder="********" id="' . $label . '">
                                    <button type="submit" class="form-control form-control-submit"><i class="icon icon-search"></i></button>
                                </form>';
		return $o;
	}

	/*
	 * add custom post type to query
	 * */
	static function wpbucket_aadd_custom_post_type_to_query($query){
        if ( is_admin() || ! $query->is_main_query() ) {
            return;
        }

        // Check if custom taxonomy is being viewed
        if( is_tax() && empty( $query->query_vars['suppress_filters'] ) )
        {
            $query->set( 'post_type', array(
                'post',
                'page',
                'pi_portfolio'
            ) );
        }
    }


    /*
     * AUTHOR SOCIAL CREDENTIALS
     * */

    static function wpbucket_add_user_social_link($user_contact){
        $user_contact['linkedin']   = __( 'LinkedIn Profile Link', 'yowel');
        $user_contact['twitter'] = __( 'Twitter Profile Link', 'yowel' );
        $user_contact['facebook'] = __( 'Facebook Profile Link', 'yowel' );
        $user_contact['google_plus'] = __( 'Google Plus Profile Link', 'yowel' );
        $user_contact['youtube'] = __( 'Youtube Profile Link', 'yowel' );
        $user_contact['expert_on'] = __( 'Your Expertise', 'yowel' );
        $user_contact['signature'] = __( 'Your Signature', 'yowel' );

        return $user_contact;
    }
}

Wpbucket_Theme_Filters::init();
