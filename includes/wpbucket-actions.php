<?php
/* ---------------------------------------------------------
 * Actions
 *
 * Class for registering actions
  ---------------------------------------------------------- */

class Wpbucket_Theme_Actions
{
    static $hooks = array();

    /**
     * Setup all theme actions
     */
    static function init()
    {

        do_action('wpbucket_before_actions_setup');

        include_once WPBUCKET_THEME_DIR.'/includes/wpbucket-helpers.php';
        include_once WPBUCKET_THEME_DIR.'/includes/wpbucket-enqueue.php';
        include_once WPBUCKET_THEME_DIR.'/includes/wpbucket-sidebars.php';

        /**
         * Array of action hooks
         *
         * Usage:
         *
         * 'action_name' => array(
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
            'after_setup_theme' => array(
                'Wpbucket_Theme_Actions::wpbucket_content_width',
                'Wpbucket_Theme_Actions::wpbucket_theme_support',
                'Wpbucket_Theme_Actions::wpbucket_register_nav_menu',
                'Wpbucket_Theme_Actions::wpbucket_theme_textdomain',
            ),
            'wp_enqueue_scripts' => array(
                'Wpbucket_Enqueue::wpbucket_load_css',
                'Wpbucket_Enqueue::wpbucket_load_fonts',
                'Wpbucket_Enqueue::wpbucket_load_js',
                'Wpbucket_Enqueue::wpbucket_localize_script',
            ),
            'admin_enqueue_scripts' => array(
                'Wpbucket_Enqueue::wpbucket_load_admin_css_js',
            ),
            'pre_get_posts' => array(
                'Wpbucket_Theme_Actions::wpbucket_portfolio_set_posts_per_page',
            ),
            'wp_ajax_wpbucket_fetch_post_with_id_modal' => array(
                'Wpbucket_Partials::wpbucket_fetch_post_with_id_modal',
            ),
            'wp_ajax_nopriv_wpbucket_fetch_post_with_id_modal' => array(
                'Wpbucket_Partials::wpbucket_fetch_post_with_id_modal',
            ),
            'comment_post' => array(
                'Wpbucket_Theme_Actions::wpbucket_comment_ratings',
            ),
            'pre_get_posts' => array(
                'Wpbucket_Theme_Actions::wpbucket_add_custom_types',
            ),
            'customize_register' => array(
                'Wpbucket_Theme_Actions::wpbucket_customize_register',
            ),
            'customize_preview_init' => array(
                'Wpbucket_Theme_Actions::wpbucket_customize_preview_init',
            ),
            'admin_menu'=>array(
                'Wpbucket_Theme_Actions::wpbucket_add_demo_importer'
            )
        );

        // register actions
        wpbucket_register_hooks(static::$hooks, 'action');
    }

    /**
     * Add Custom Post types into search query for ARCHIVE.PHP file
     */
    static function wpbucket_add_custom_types($query)
    {
        if ($query->is_main_query() && (is_category() || is_tag() && empty($query->query_vars['suppress_filters']))) {
            $query->set('post_type',
                array(
                    'post', 'pi_portfolio'
            ));
            return $query;
        }
    }

    /**
     * Enable all required features for proper theme work
     */
    static function wpbucket_theme_support()
    {
        add_theme_support('align-wide');

        // Add default posts and comments RSS feed links to <head>.
        add_theme_support('automatic-feed-links');

        // title tag
        add_theme_support('title-tag');

        // Add support for a variety of post formats
        add_theme_support('post-formats',
            array('standard', 'aside', 'video', 'audio', 'gallery', 'link', 'image',
                'quote', 'status'));

        // Add support for custom header
        add_theme_support("custom-header");

        //Add support for custom background
        add_theme_support("custom-background");

        // ADD POST THUMBNAIL SUPPORT
        add_theme_support('post-thumbnails');

        // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
        add_theme_support('post-thumbnails',
            array('post', 'pi_portfolio', 'pi_services'));

        //Custom Logo
        $defaults_logo = array(
            'height' => 60,
            'width' => 85,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
        );
        add_theme_support('custom-logo', $defaults_logo);
    }
    /*
     *
     * WIDGWT INITIALIZE
     * */

    static function wpbucket_widget_initialize()
    {
        register_widget('Wpbucket_Widget_Info');
    }

    /**
     * Register all theme menus
     */
    static function wpbucket_register_nav_menu()
    {
        // Registering Main menu
        register_nav_menu('primary', 'Primary Menu');
        register_nav_menu('footer', 'Footer Menu');
    }

    /**
     * Make theme available for translation
     */
    static function wpbucket_theme_textdomain()
    {

        $theme_name = sanitize_title(WPBUCKET_THEME_NAME);

        // Make theme available for translation
        load_theme_textdomain($theme_name, WPBUCKET_THEME_DIR.'/languages');
        $locale      = get_locale();
        $locale_file = WPBUCKET_THEME_DIR."/languages/$locale.php";
        if (is_readable($locale_file)) require_once $locale_file;
    }

    /**
     * Set the content width based on the theme's design and stylesheet.
     */
    static function wpbucket_content_width()
    {

        if (!isset($content_width)) $content_width = 1140;
    }

    /**
     * Portfolio taxonomy archive.
     * Set posts_per_page variable based on value from Theme options.
     *
     * @param object $query
     * @return object
     */
    static function wpbucket_portfolio_set_posts_per_page($query)
    {
        if (!is_admin() && $query->is_tax() && ($query->is_archive())) {
            $taxonomy_vars = $query->query_vars;
            if (isset($taxonomy_vars['portfolio-category'])) $tax           = 'portfolio';

            if (!empty($tax)) {
                $posts_per_page = wpbucket_return_theme_option('portfolio_pagination');
                $query->set('posts_per_page', $posts_per_page);
                $query->set('post_type', "pi_".$tax);
            }
        }

        return $query;
    }
    /*
     * ADD extra fields to review sections
     * */

    static function wpbucket_comment_ratings($comment_id)
    {
        add_comment_meta($comment_id, 'wpbucket_rate', $_POST['wpbucket_rate']);
        add_comment_meta($comment_id, 'wpbucket_review_title',
            $_POST['wpbucket_review_title']);
    }

    /**
     * Theme customize API
     */
    static function wpbucket_customize_register($wp_customize)
    {
        if (!isset($wp_customize)) {
            return;
        }
        $wp_customize->add_section(
            // $id
            'wpbucket_footer_logo_section',
            // $args
            array(
                'title' => __('Footer Logo', 'yowel'),
            // 'description'	=> __( 'Some description for the options in the Home Top section', 'theme-slug' ),
            )
        );

        /**
         * Add 'Home Top Background Image' Setting.
         */
        $wp_customize->add_setting(
            // $id should be same as section
            'wpbucket_footer_logo_control',
            // $args
            array(
                'default' => WPBUCKET_TEMPLATEURL."/images/logo-footer.png",
                'sanitize_callback' => 'esc_url_raw',
                'transport' => 'postMessage'
            )
        );

        /**
         * Add 'Home Top Background Image' image upload Control.
         */
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                // $wp_customize object
                $wp_customize,
                // $id
                'wpbucket_footer_logo_control',
                // $args
                array(
                'settings' => 'wpbucket_footer_logo_control',
                'section' => 'wpbucket_footer_logo_section',
                'label' => __('Footer Logo', 'yowel'),
                'description' => __('Select the image to be used for Footer Logo.',
                    'yowel')
                )
            )
        );

        $wp_customize->add_section(
            // $id
            'wpbucket_button_section',
            // $args
            array(
                'title' => __('Buy now Button', 'yowel'),
                'description' => __('Buy now top righit corrner button can customize here',
                    'yowel'),
            )
        );

        $wp_customize->add_setting('wpbucket_button_text_control',
            array(
                'default' => esc_html__('Buy Now', 'yowel'),
                'transport' => 'postMessage',
                'sanitize_callback' => 'esc_html'
            )
        );

        $wp_customize->add_control('wpbucket_button_text_control',
            array(
                'label' => __('Default Text Control'),
                'description' => esc_html__('Button text', 'yowel'),
                'section' => 'wpbucket_button_section',
                'priority' => 10, // Optional. Order priority to load the control. Default: 10
                'type' => 'text', // Can be either text, email, url, number, hidden, or date
                'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
                'input_attrs' => array(// Optional.
                    'class' => 'wpbucket-custom-class',
                    'style' => 'border: 1px solid rebeccapurple',
                    'placeholder' => __('Button text', 'yowel'),
                ),
            )
        );

        $wp_customize->add_setting('wpbucket_button_url_control',
            array(
                'default' => '#',
                'transport' => 'postMessage',
                'sanitize_callback' => 'esc_url_raw'
            )
        );

        $wp_customize->add_control('wpbucket_button_url_control',
            array(
                'label' => __('Default URL Control'),
                'description' => esc_html__('Button url', 'yowel'),
                'section' => 'wpbucket_button_section',
                'priority' => 10, // Optional. Order priority to load the control. Default: 10
                'type' => 'url', // Can be either text, email, url, number, hidden, or date
                'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
                'input_attrs' => array(// Optional.
                    'class' => 'wpbucket-custom-class',
                    'style' => 'border: 1px solid rebeccapurple',
                    'placeholder' => __('http:\\', 'yowel'),
                ),
            )
        );

        $wp_customize->add_setting('wpbucket_button_show_hide_control',
            array(
                'default' => 0,
                'transport' => 'postMessage',
                'sanitize_callback' => 'esc_html'
            )
        );

        $wp_customize->add_control('wpbucket_button_show_hide_control',
            array(
                'label' => __('Button Show or Hide', 'yowel'),
                'description' => esc_html__('Mark to hide the button', 'yowel'),
                'section' => 'wpbucket_button_section',
                'priority' => 10, // Optional. Order priority to load the control. Default: 10
                'type' => 'checkbox',
                'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
            )
        );

        $wp_customize->add_setting('wpbucket_button_bg_color_control',
            array(
                'default' => '#1539E9',
                'transport' => 'postMessage',
                'sanitize_callback' => 'esc_attr'
            )
        );

        $wp_customize->add_control('wpbucket_button_bg_color_control',
            array(
                'label' => __('Default Button Background Color'),
                'description' => esc_html__('Change button background color','yowel'),
                'section' => 'wpbucket_button_section',
                'priority' => 10, // Optional. Order priority to load the control. Default: 10
                'type' => 'color',
                'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
            )
        );
    }

    /**
     * Live preview initialize
     */
    static public function wpbucket_customize_preview_init()
    {
        wp_enqueue_script(
            'wpbucket-theme-customizer',
            WPBUCKET_TEMPLATEURL.'/js/theme-customizer.js',
            array('customize-preview'), '0.1.0', true
        );
    }

    static public function wpbucket_add_demo_importer(){
        add_theme_page(esc_html__('Demo Importer', 'yowel'), esc_html__('Demo Importer', 'yowel'), 'administrator', 'wpbucket-demo-importer', 'wpbucket_demo_importer_page');
    }
}
Wpbucket_Theme_Actions::init();
