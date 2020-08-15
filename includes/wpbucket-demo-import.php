<?php

/* ---------------------------------------------------------
 * Sidebars
 *
 * Class that creates custom sidebar
  ---------------------------------------------------------- */

class Wpbucket_Demo_Import {

	/**
     * Setup all demo data
     */
    static function init()
    {
		add_filter( 'pt-ocdi/import_files', 'Wpbucket_Demo_Import::wpbucket_import_files' );
		add_action( 'pt-ocdi/after_import', 'Wpbucket_Demo_Import::wpbucket_after_import_setup' );
		add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
	}
	
	static function wpbucket_import_files(){
		return array(
			array(
				'import_file_name'           => 'Demo Import yowel',
				'categories'                 => array( 'Category yowel'),
				'import_file_url'            => WPBUCKET_TEMPLATEURL.'/includes/demo-files/demo.xml',
				'import_widget_file_url'     => WPBUCKET_TEMPLATEURL.'/includes/demo-files/widgets.wie',
			   // 'import_customizer_file_url' => 'http://www.your_domain.com/ocdi/customizer.dat',
				'import_redux'               => array(
					array(
						'file_url'    => WPBUCKET_TEMPLATEURL.'/includes/demo-files/themeoption.json',
						'option_name' => 'wpbucket_options',
					),
				),
				'import_preview_image_url'   =>  WPBUCKET_TEMPLATEURL.'/screenshot.png',
			),
		);
	}
	
	static function wpbucket_after_import_setup() {
		    // Assign menus to their locations.
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

		set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
			)
		);

		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home Slider' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );
		
		if ( class_exists( 'RevSlider' ) ) {
           $slider_array = array(
              WPBUCKET_THEME_DIR."/includes/demo-files/news-gallery5.zip",
              WPBUCKET_THEME_DIR."/includes/demo-files/news-gallery51.zip",
              WPBUCKET_THEME_DIR."/includes/demo-files/youtube-hero.zip",
              WPBUCKET_THEME_DIR."/includes/demo-files/classic-carousel8.zip",
              );
 
           $slider = new RevSlider();
        
           foreach($slider_array as $filepath){
             $slider->importSliderFromPost(true,true,$filepath);  
           }
        
           echo ' Slider processed';
      }
	}

}
Wpbucket_Demo_Import::init();