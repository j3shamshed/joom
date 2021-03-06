<?php

/* ---------------------------------------------------------
 * Sidebars
 *
 * Class that creates custom sidebar
  ---------------------------------------------------------- */

class Wpbucket_Sidebars {

    /**
     * Register sidebar on page
     */
    static function wpbucket_custom_sidebar() {
        $args_sidebar = array(
            'name' => esc_html__( 'Main Sidebar', 'yowel' ),
            'id' => 'blog-sidebar-id',
            'description' => esc_html__( 'Main Sidebar', 'yowel' ),
            'class' => 'widget',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget_title"><span>',
            'after_title' => '</span></h4>'
        );

        register_sidebar( $args_sidebar );
    }

    /**
     * Register sidebar for footer
     */
    static function wpbucket_footer_sidebar() {

        $number_of_sidebar = wpbucket_return_theme_option( 'footer_widget_areas', '', '4' );

        for ( $i = 1; $i <= $number_of_sidebar; $i++ ) {
            $args_sidebar = array(
                'name' => esc_html__( 'Footer Sidebar', 'yowel' )  . " " . ($i),
                'id' => 'wpbucket-sidebar-' . ($i + 1),
                'description' => esc_html__( 'Footer Sidebar', 'yowel' )  . " " . ($i),
                'class' => '',
                'before_widget' => '<div id="%1$s" class="footer-widget">',
                'after_widget' => '</div>',
                'before_title' => ' <div class="footer-title"><h2>',
                'after_title' => '</h2></div>'
            );

            register_sidebar( $args_sidebar );
        }
    }
    /**
     * Register sidebar for footer
     */
    static function wpbucket_header_sidebar() {

        $number_of_sidebar = wpbucket_return_theme_option( 'header_widget_areas', '', '3' );

        for ( $i = 1; $i <= $number_of_sidebar; $i++ ) {
            $args_sidebar = array(
                'name' => esc_html__( 'Header Sidebar', 'yowel' )  . " " . ($i),
                'id' => 'wpbucket-header-sidebar-' . ($i + 1),
                'description' => esc_html__( 'Header Sidebar', 'yowel' )  . " " . ($i),
                'class' => 'header-widget',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => ' <div class="title"><h3>',
                'after_title' => '</h3></div>'
            );

            register_sidebar( $args_sidebar );
        }
    }

    static function wpbucket_page_sidebar() {
        global $wpdb;

        // create sidebar for pages with left or right sidebar     
        $query = $wpdb->prepare(
                "SELECT DISTINCT ID FROM {$wpdb->posts}
                    INNER JOIN {$wpdb->postmeta}
                      ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
                  WHERE {$wpdb->postmeta}.meta_key = %s
                  AND {$wpdb->postmeta}.meta_value IN (%s, %s)
                  AND {$wpdb->posts}.ID NOT IN (SELECT post_id FROM {$wpdb->postmeta} AS meta WHERE meta.meta_key = %s AND meta.meta_value = %s)", 'pg_sidebar', 'left', 'right', 'pg_sidebar_generator', 'existing' );

        $post_ids = $wpdb->get_results( $query );

        foreach ( ( array ) $post_ids as $id ) {
            $post = get_post( intval( $id->ID ) );

            $sidebar_title = $post->post_title;
            $sidebar_id = "wpbucket-page-sidebar-" . $post->ID;
            register_sidebar( array(
                'name' => $sidebar_title,
                'id' => $sidebar_id,
                'class' => 'aside-widgets',
                'description' => esc_html__( 'An optional widget area for page ', 'yowel' ) . $sidebar_title,
                'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                'after_widget' => "</div>",
                'before_title' => '<div class="title"><h5 class="title-sidebar">',
                'after_title' => '</h5></div>'
            ) );
        }
    }

}
