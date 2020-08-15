<?php

/* ---------------------------------------------------------
 * Plugins
 *
 * Class with functions related to plugins 
 * necesarry for proper theme work
  ---------------------------------------------------------- */

class Wpbucket_Core_Plugins {

    /**
     * Check if required plugins are loaded
     */
    static function plugins_loaded() {

        if ( !function_exists( 'is_plugin_active' ) ) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        // check if MetaBox plugin is loaded
        if ( class_exists('RWMB_Loader')) {
            define( 'WPBUCKET_META_BOX', true );
        } else {
            define( 'WPBUCKET_META_BOX', false );
        }
    }

}

Wpbucket_Core_Plugins::plugins_loaded();
