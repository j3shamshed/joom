<?php

/*
 * ---------------------------------------------------------
 * Redux
 *
 * ReduxFramework Config File
 * ----------------------------------------------------------
 */
if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "wpbucket_options";

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name' => 'wpbucket_options',
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type' => 'menu',
    // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true,
    // Show the sections below the admin menu item or not
    'menu_title' => esc_html__('Theme Options', 'yowel'),
    'page_title' => esc_html__('Theme Options', 'yowel'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key' => 'AIzaSyBsN1cG-NVXTUyefbmSlbv5NxMWyDzD8Nw',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography' => true,
    // Use a asynchronous font on the front end or font string
    // 'disable_google_fonts_link' => true, // Disable this in case you want to create your own google fonts loader
    'admin_bar' => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50,
    // Choose an priority for the admin bar menu
    'global_variable' => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    // Show the time the page took to load, etc
    'update_notice' => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => false,
    // Enable basic customizer support
    // 'open_expanded' => true, // Allow you to start the panel in an expanded way initially.
    // 'disable_save_warn' => true, // Disable the save warning when a user changes a field
    // OPTIONAL -> Give you extra features
    'page_priority' => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => "",
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon' => '',
    // Specify a custom URL to an icon
    'last_tab' => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug' => '_vlc_options',
    // Page slug used to denote the panel
    'save_defaults' => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show' => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true,
    // Shows the Import/Export panel when not used as a field.
    // CAREFUL -> These options are for advanced use only
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit' => '', // Disable the footer credit of Redux. Please leave if you can help it.
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'system_info' => false
);

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args ['share_icons'] [] = array(
    'url' => 'https://github.com/pixel-industry/',
    'title' => 'Visit us on GitHub',
    'icon' => 'el-icon-github'
);
// 'img' => '', // You can use icon OR img. IMG needs to be a full URL.

$args ['share_icons'] [] = array(
    'url' => 'https://www.facebook.com/themebasket',
    'title' => 'Like us on Facebook',
    'icon' => 'el-icon-facebook'
);
$args ['share_icons'] [] = array(
    'url' => 'https://twitter.com/themebasket',
    'title' => 'Follow us on Twitter',
    'icon' => 'el-icon-twitter'
);
$args ['share_icons'] [] = array(
    'url' => 'http://www.linkedin.com/company/themebasket',
    'title' => 'Find us on LinkedIn',
    'icon' => 'el-icon-linkedin'
);
$args ['share_icons'] [] = array(
    'url' => 'http://dribbble.com/themebasket',
    'title' => 'Our Work on Dribbble',
    'icon' => 'el-icon-dribbble'
);

Redux::setArgs($opt_name, $args);

/*
 *
 * ---> START SECTIONS
 *
 */

// ACTUAL DECLARATION OF SECTIONS

Redux::setSection($opt_name, array(
    'icon' => 'el-icon-cogs',
    'title' => esc_html__('Header', 'yowel'),
    'fields' => array(
        array(
            'id' => 'logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Logo', 'yowel'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Upload logo for your website.', 'yowel')
        ),
        array(
            'id' => 'header_social_icons',
            'type' => 'select_text',
            'title' => esc_html__('Social Icons', 'yowel'),
            'subtitle' => esc_html__('Add social icons and respective URLs that will be rendered at footer section.', 'yowel'),
            'icons' => wpbucket_font_awesome_classes(),
            'key_prefix' => 'fa '
        ),
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-tint',
    'title' => esc_html__('Contact Page', 'yowel'),
    'fields' => array(
        array(
            'id' => 'map_area',
            'type' => 'switch',
            'title' => esc_html__('Map Area Show or Hide', 'yowel'),
            'subtitle' => esc_html__('Set map area visibility.', 'yowel'),
            "default" => 1,
            'on' => esc_html__('Show', 'yowel'),
            'off' => esc_html__('Hide', 'yowel')
        ),
        array(
            'id' => 'wpbucket_map_api_key',
            'type' => 'text',
            'title' => esc_html__('Google map api key', 'yowel'),
            'desc' => esc_html__('Write your google map API key.', 'yowel'),
            'required' => array(
                'map_area',
                '=',
                '1'
            ),
        ),
        array(
            'id' => 'wpbucket_contact_info',
            'type' => 'multi_text',
            'title' => esc_html__('Contact Info', 'yowel'),
            'subtitle' => esc_html__('Enter Contact Information. Separated Heading and Description with * sign.', 'yowel'),
            'required' => array(
                'map_area',
                '=',
                '1'
            ),
        ),
    )
));

Redux::setSection($opt_name, array(
    'icon' => 'el-icon-adjust-alt',
    'title' => esc_html__('404', 'yowel'),
    'fields' => array(
        array(
            'id' => '404_main_heading',
            'type' => 'text',
            'title' => esc_html__('404 Heading', 'yowel'),
            'subtitle' => esc_html__('Enter 404 page heading.', 'yowel'),
            'default' => 'Page Not Found'
        ),
        array(
            'id' => '404_description',
            'type' => 'textarea',
            'title' => esc_html__('404 Description', 'yowel'),
            'subtitle' => esc_html__('Enter description text.', 'yowel'),
            'validate' => 'html', // see http://codex.wordpress.org/Function_Reference/wp_kses_post
            'default' => 'THE PAGE YOU ARE LOOKING FOR SEEMS TO BE MISSING'
        ),
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-adjust-alt',
    'title' => esc_html__('Social Share', 'yowel'),
    'fields' => array(
        array(
            'id' => 'show_social_share',
            'type' => 'switch',
            'title' => esc_html__('Set Social share', 'yowel'),
            'subtitle' => esc_html__('Hide or show social share at blog post.', 'yowel'),
            "default" => 0,
            'on' => esc_html__('Show', 'yowel'),
            'off' => esc_html__('Hide', 'yowel')
        ),
        array(
            'id'       => 'multi_social',
            'type'     => 'checkbox',
            'title'    => __('Select social platform', 'yowel'),
            'subtitle' => __('Select social platform whatever you want', 'yowel'),
            //Must provide key => value pairs for multi checkbox options
            'options'  => array(
                'fa-facebook' => 'Facebook',
                'fa-google-plus' => 'Google Plus',
                'fa-twitter' => 'Twitter',
                'fa-linkedin' => 'Linkedin',
                'fa-pinterest' => 'Pinterest'
            ),
            'required' => array(
                'show_social_share',
                '=',
                '1'
            ),
        )
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-adjust-alt',
    'title' => esc_html__('Footer', 'yowel'),
    'fields' => array(
        array(
            'id' => 'footer_show',
            'type' => 'switch',
            'title' => esc_html__('Footer Show or Hide', 'yowel'),
            'subtitle' => esc_html__('Set footer visibility.', 'yowel'),
            "default" => 0,
            'on' => esc_html__('Show', 'yowel'),
            'off' => esc_html__('Hide', 'yowel')
        ),
        array(
            'id' => 'footerlogo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Footer Logo', 'yowel'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Upload footer logo for your website.', 'yowel')
        ),
        array(
            'id' => 'copyright_right_text',
            'type' => 'textarea',
            'title' => esc_html__('Copyright Text', 'yowel'),
            'subtitle' => esc_html__('Enter copyright text.', 'yowel'),
            'validate' => 'html', // see http://codex.wordpress.org/Function_Reference/wp_kses_post
            'default' => '(C) 2018 Your Company, All right reserved'
        ),
        array(
            'id' => 'wpbucket_scroll_to_top',
            'type' => 'switch',
            'title' => esc_html__('Show/Hide Scroll to top', 'yowel'),
            'subtitle' => esc_html__('Show or hide scroll to top button.', 'yowel'),
            "default" => 1,
            'on' => esc_html__('Show', 'yowel'),
            'off' => esc_html__('Hide', 'yowel')
        ),
        array(
            'id' => 'show_newsletter',
            'type' => 'switch',
            'title' => esc_html__('Newsletter', 'yowel'),
            'subtitle' => esc_html__('Set Newsletter Shortcode.', 'yowel'),
            "default" => 0,
            'on' => esc_html__('Show', 'yowel'),
            'off' => esc_html__('Hide', 'yowel')
        ),
        array(         
            'id'       => 'opt-background',
            'type'     => 'background',
            'title'    => __('Body Background', 'yowel'),
            'subtitle' => __('Body background with image, color, etc.', 'yowel'),
            'desc'     => __('Set Background Image or Color.', 'yowel'),
            'output'    => array('.subscribe'),
            'required' => array(
                'show_newsletter',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'formheader',
            'type' => 'text',
            'title' => esc_html__('Form Header', 'yowel'),
            'subtitle' => esc_html__('Enter Form Header', 'yowel'),
            'required' => array(
                'show_newsletter',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'formsubheader',
            'type' => 'text',
            'title' => esc_html__('Form Sub Header', 'yowel'),
            'subtitle' => esc_html__('Enter Form Sub Header', 'yowel'),
            'required' => array(
                'show_newsletter',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'newsletter_shortcode',
            'type' => 'text',
            'title' => esc_html__('Form Shortcode', 'yowel'),
            'subtitle' => esc_html__('Enter Form Shortcode', 'yowel'),
            'required' => array(
                'show_newsletter',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'show_slider',
            'type' => 'switch',
            'title' => esc_html__('Insta Gallery', 'yowel'),
            'subtitle' => esc_html__('Set Insta Gallery visibility. This section shows before footer.', 'yowel'),
            "default" => 0,
            'on' => esc_html__('Show', 'yowel'),
            'off' => esc_html__('Hide', 'yowel')
        ),
        array(         
            'id'       => 'gallery-background',
            'type'     => 'background',
            'title'    => __('Insta Background', 'yowel'),
            'subtitle' => __('Insta background with image, color, etc.', 'yowel'),
            'desc'     => __('Set Background Image or Color.', 'yowel'),
            'output'    => array('.insta-gallery'),
            'required' => array(
                'show_slider',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'instaheader',
            'type' => 'text',
            'title' => esc_html__('Insta Header', 'yowel'),
            'subtitle' => esc_html__('Enter Insta Header', 'yowel'),
            'required' => array(
                'show_slider',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'instasubheader',
            'type' => 'text',
            'title' => esc_html__('Insta Sub Header', 'yowel'),
            'subtitle' => esc_html__('Enter Insta Sub Header', 'yowel'),
            'required' => array(
                'show_slider',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'instabutton',
            'type' => 'text',
            'title' => esc_html__('Insta Button Text', 'yowel'),
            'subtitle' => esc_html__('Enter Insta Button Text', 'yowel'),
            'required' => array(
                'show_slider',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'instaurl',
            'type' => 'text',
            'title' => esc_html__('Insta Button URL', 'yowel'),
            'subtitle' => esc_html__('Enter Insta Button URL', 'yowel'),
            'required' => array(
                'show_slider',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'wpbucket_gallery',
            'type' => 'gallery',
            'title' => esc_html__('Instagram Images', 'yowel'),
            'subtitle' => esc_html__('Select Instagram Images.', 'yowel'),
            'required' => array(
                'show_slider',
                '=',
                '1'
            )
        ),
        array(
            'id' => 'footer_social_icons',
            'type' => 'select_text',
            'title' => esc_html__('Social Icons', 'yowel'),
            'subtitle' => esc_html__('Add social icons and respective URLs that will be rendered at footer section.', 'yowel'),
            'icons' => wpbucket_font_awesome_classes(),
            'key_prefix' => 'fa '
        ),
    )
));


