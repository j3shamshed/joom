<?php
/* ---------------------------------------------------------
 * Enqueue
 *
 * Class for including Javascript and CSS files
  ---------------------------------------------------------- */

class Wpbucket_Enqueue
{
    public static $css;
    public static $js;
    public static $admin_css;

    /**
     * Configuration array for stylesheet that will be loaded
     */
    static function wpbucket_load_css()
    {

        // array with CSS file to load

        static::$css = array(
            'wpbucket-iconmoon-icon' => 'css/fonts/icomoon/css/demo.css',
            'wpbucket-fontawesome' => 'css/fonts/font-awesome/css/font-awesome.css',
            'wpbucket-bootstrap' => 'css/bootstrap.css',
            'wpbucket-owl-carousel' => 'css/owl.carousel.css',
            'wpbucket-owl-carousel-default' => 'css/owl.theme.default.css',
            'parent-style' => array('style.css', 'wpbucket-bootstrap'),
            'wpbucket-menu' => 'css/menu.css',
        );


        // enqueue files
        Wpbucket_Enqueue::wpbucket_enqueue_css();
    }

    /**
     * Configuration array for Javascript files that will be loaded
     */
    static function wpbucket_load_js()
    {

        // hookname => array(filename, dependency_hook, load_in_footer)
        // url to file should be relative to the theme root directory
        // default: load_in_footer = TRUE
        static::$js = array(
            'wpbucket-bootstrap' => 'js/bootstrap.min.js',
            'wpbucket-owl-carousel' => 'js/owl.carousel.js',
            'wpbucket-menu' => 'js/menu.js',
            'wpbucket-custom' => 'js/custom.js'
        );

        if (is_page_template('contact-page.php') || is_page_template('contact-page-no-sidebar.php')) {
            static::$js['wpbucket-map'] = 'js/map.js';
        }

        // We add some JavaScript to pages with the comment form 
        // to support sites with threaded comments (when in use).         
        if (is_singular() && get_option('thread_comments')) {
            static::$js['comment-reply'] = '';
        }

        // enqueue files
        Wpbucket_Enqueue::wpbucket_enqueue_js();
    }

    /**
     * Enqueue Javascript and CSS file to admin
     */
    static function wpbucket_load_admin_css_js()
    {

        // array with admin css files
        static::$admin_css = array(
            'font-awesome' => WPBUCKET_TEMPLATEURL.'/css/fonts/font-awesome/css/font-awesome.css',
        );

        // enqueue files
        Wpbucket_Enqueue::wpbucket_enqueue_admin_css_js();
    }

    /**
     * Enqueue CSS files
     */
    static function wpbucket_enqueue_css()
    {

        // concate full url to file by add url prefix to css dir
        static::$css = array_map('wpbucket_enqueue_css_prefix', static::$css);

        // allow modifiying array of css files that will be loaded
        static::$css = apply_filters('wpbucket_css_files', static::$css);

        // loop through files and enqueue
        foreach (static::$css as $key => $value) {

            // if value is array it means dependency and $media might be set
            if (is_array($value)) {
                $file       = isset($value[0]) ? $value[0] : '';
                $dependency = isset($value[1]) ? $value[1] : '';
                $media      = isset($value[2]) ? $value[2] : 'all';
                wp_enqueue_style($key, $file, $dependency, '', $media);
            } else {
                wp_enqueue_style($key, $value, '', '');
            }
        }
    }
    /*
     * Enqueue Google fonts
     * */

    static function wpbucket_load_fonts()
    {
        $fonts_url = '';

        /**
         * Translators: If there are characters in your language that are not
         * supported by Libre Franklin, translate this to 'off'. Do not translate
         * into your own language.
         */
        $libre_franklin = _x('on', 'Lato font: on or off', 'yowel');

        if ('off' !== $libre_franklin) {
            $font_families = array();

            $font_families[] = 'Lora:400,400i,700|Karla:300,400,500,700,900|Arizonia';

            $query_args = array(
                'family' => urlencode(implode('|', $font_families)),
                'subset' => urlencode(''),
            );

            $fonts_url = add_query_arg($query_args,
                'https://fonts.googleapis.com/css');
        }

        wp_enqueue_style('wpbucket-fonts', esc_url_raw($fonts_url), array(),
            null);
    }

    /**
     * Enqueue Javascript files
     */
    static function wpbucket_enqueue_js()
    {
        global $wpbucket_theme_config;
        // concate full url to file by add url prefix to js dir
        static::$js = array_map('wpbucket_enqueue_js_prefix', static::$js);

        // allow modifiying array of javascript files that will be loaded
        static::$js = apply_filters('wpbucket_js_files', static::$js);

        // Enqueue Javascript
        wp_enqueue_script('jquery');

        //ENQUE MAP SCRIPT
        $map_key = wpbucket_return_theme_option('wpbucket_map_api_key', '',
            'AIzaSyBEDfNcQRmKQEyulDN8nGWjLYPm8s4YB58');
        wp_register_script('googlemaps',
            'https://maps.google.com/maps/api/js?key='.esc_attr($map_key).'&libraries=places');
        wp_enqueue_script('googlemaps');

        // loop through files and enqueue
        foreach (static::$js as $key => $value) {

            // if value is array it means dependency and $in_footer might be set
            if (is_array($value)) {
                $file       = isset($value[0]) ? $value[0] : '';
                $dependency = isset($value[1]) ? $value[1] : '';
                $in_footer  = isset($value[2]) ? $value[2] : true;

                wp_enqueue_script($key, $file, $dependency, '', $in_footer);
            } else {
                wp_enqueue_script($key, $value, '', '', true);
            }
        }
        if (wp_script_is('wpbucket-theme-map', 'enqueued')) {
            wp_localize_script('wpbucket-theme-map', 'wpbucketAjax',
                array('themeUrl' => WPBUCKET_TEMPLATEURL));
        }
        if (wp_script_is('wpbucket-main', 'enqueued')) {
            $socials = apply_filters('wpbucket_social_array',
                $wpbucket_theme_config['social_links']);
            wp_localize_script('wpbucket-main', 'wpbucketObject',
                array('ajaxurl' => admin_url('admin-ajax.php'), 'socials' => $socials));
        }
        wp_enqueue_media();
    }

    /**
     * Enqueue Javascript and CSS file to admin
     */
    static function wpbucket_enqueue_admin_css_js()
    {

        // allow modifiying array of css files that will be loaded
        static::$admin_css = apply_filters('wpbucket_admin_css_files',
            static::$admin_css);

        // loop through array of admin css files and load them
        foreach (static::$admin_css as $key => $value) {

            wp_enqueue_style($key, $value);
        }
    }

    /**
     * Make certain options available on front-end
     */
    static function wpbucket_localize_script()
    {
        
    }
}