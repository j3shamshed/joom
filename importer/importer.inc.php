<?php
//webhosting permission and capability check
$wpbucket_demo_importer_error = 0;
if (isset($_GET['page'])) {

    if (empty($_POST['wpbucket_importing']) && $_GET['page'] == 'wpbucket-demo-importer'
        && current_user_can('administrator')) {


        //is allow_url_fopen setting on in php.ini?
        if (ini_get('allow_url_fopen') != '1' && ini_get('allow_url_fopen') != 'On') {
            $wpbucket_demo_importer_selfcheck[] = esc_html__('The allow_url_fopen setting is turned off in the PHP ini!',
                'yowel');
        } else {
            //can we read a file with wp filesystem?
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH.'/wp-admin/includes/file.php');
                WP_Filesystem();
            }

            if (!$wp_filesystem->get_contents(get_template_directory_uri().'/importer/data.imp')) {
                $wpbucket_demo_importer_selfcheck[] = esc_html__('The script couldn\'t read the data.imp file. Is it there? Does it have the permission to read?',
                    'yowel');
            }
        }


        //can we create directory?
        $uploads_dir = $wp_filesystem->abspath().'/wp-content/uploads';
        if (!$wp_filesystem->is_dir($uploads_dir)) {
            if (!$wp_filesystem->mkdir($uploads_dir)) {
                $wpbucket_demo_importer_selfcheck[] = esc_html__('The script couldn\'t create a directory!',
                    'yowel');
            }
        }


        //can we copy files?
        if (!$wp_filesystem->copy(get_template_directory().'/importer/media/square.png',
                $wp_filesystem->abspath().'/wp-content/uploads/test.jpg')) {
            $wpbucket_demo_importer_selfcheck[] = esc_html__('The script couldn\'t copy a file!',
                'yowel');
        } else {
            $wp_filesystem->delete($wp_filesystem->abspath().'/wp-content/uploads/test.jpg');
        }




        //can we read/write database?
        global $wpdb;
        if (!$wpdb->query('CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'testing (id mediumint(9) NOT NULL AUTO_INCREMENT, test varchar(255), UNIQUE KEY id (id))')) {
            $wpbucket_demo_importer_selfcheck[] = esc_html__('The script is not allowed to write MySQL database!',
                'yowel');
        } else {
            if (!$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'testing')) {
                $wpbucket_demo_importer_selfcheck[] = esc_html__('The script is not allowed to write MySQL database!',
                    'yowel');
            }
        }
    }
}

if (isset($_GET['page'])) {

//start importing
    if (!empty($_POST['wpbucket_importing']) && $_GET['page'] == 'wpbucket-demo-importer'
        && current_user_can('administrator')) {

        //copy all media files
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once(ABSPATH.'/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $files = glob(get_template_directory().'/importer/media/*.*');
        foreach ($files as $file) {
            if (!$wp_filesystem->copy($file,
                    $wp_filesystem->abspath().'/wp-content/uploads/'.basename($file))) {
                $wpbucket_demo_importer_error = '1';
            }
        }


        //clear tables
        global $wpdb;
        $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'comments');
        $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'postmeta');
        $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'posts');
        $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_relationships');
        $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_taxonomy');
        $wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'terms');


        //read SQL dump and process each statement
        $data = $wp_filesystem->get_contents(get_template_directory_uri().'/importer/data.imp');
        $sql  = explode('<wpbucket_sep>', $data);

        $current_url = get_site_url();
        foreach ($sql as $statement) {
            if (!empty($statement)) {

                //replace default wp prefix to user's choice if it's not the default one
                if (strstr($statement, 'wp_comments') && $wpdb->prefix != 'wp_') {
                    $statement = str_replace('wp_comments',
                        $wpdb->prefix.'comments', $statement);
                }

                if (strstr($statement, 'wp_postmeta')) {
                    if ($wpdb->prefix != 'wp_') {
                        $statement = str_replace('wp_postmeta',
                            $wpdb->prefix.'postmeta', $statement);
                    }

                    //also replace all our sample paths to the user's actual path
                    $statement = str_replace('http://localhost/joom',
                        $current_url, $statement);
                }

                if (strstr($statement, 'wp_posts')) {
                    if ($wpdb->prefix != 'wp_') {
                        $statement = str_replace('wp_posts',
                            $wpdb->prefix.'posts', $statement);
                    }

                    //also replace all our sample paths to the user's actual path
                    $statement = str_replace('http://localhost/joom',
                        $current_url, $statement);
                }

                if (strstr($statement, 'wp_term_relationships') && $wpdb->prefix
                    != 'wp_') {
                    $statement = str_replace('wp_term_relationships',
                        $wpdb->prefix.'term_relationships', $statement);
                }

                if (strstr($statement, 'wp_term_taxonomy') && $wpdb->prefix != 'wp_') {
                    $statement = str_replace('wp_term_taxonomy',
                        $wpdb->prefix.'term_taxonomy', $statement);
                }

                if (strstr($statement, 'wp_terms') && $wpdb->prefix != 'wp_') {
                    $statement = str_replace('wp_terms', $wpdb->prefix.'terms',
                        $statement);
                }


                //run the query
                if (!$wpdb->query($statement)) {

                    $wpbucket_demo_importer_error = '1';
                }
            }
        }


        //navigation, widgets, other settings
        if ($wpbucket_demo_importer_error != 1) {

            update_option('page_for_posts', '0');
            update_option('page_on_front', '5');
            update_option('show_on_front', 'page');
            update_option('theme_mods_joom',
                unserialize('a:4:{i:0;b:0;s:18:"nav_menu_locations";a:2:{s:7:"primary";i:2;s:6:"footer";i:3;}s:18:"custom_css_post_id";i:-1;s:28:"wpbucket_button_text_control";s:7:"Buy Now";}'));
            update_option('widget_archives',
                unserialize('a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}'));
            update_option('widget_categories',
                unserialize('a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}'));
            update_option('widget_search',
                unserialize('a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}'));
        }


        //if everything went well
        if (empty($wpbucket_demo_importer_error)) {
            $wpbucket_demo_importer_success = '1';
        }
    }
}

//admin page
function wpbucket_demo_importer_page()
{
    global $wpbucket_demo_importer_selfcheck, $wpbucket_demo_importer_success;

    echo '<div class="wrap">
			<h1>'.esc_html__('Demo Content Importer', 'yowel').'</h1>
			';

    if (empty($_POST['wpbucket_importing'])) {
        //welcome message
        echo '<p>'.esc_html__('Here you can import sample content with a single click!',
            'yowel').'<br /><br />
					'.__('<b>WARNING! The importing process will remove your existing posts, pages and media library!<br />
					It\'s recommended to use a fresh, clean wordpress install!</b>', 'yowel').'</p>
					<p>&nbsp;</p>';

        //show button if no error were found in selfcheck
        if (empty($wpbucket_demo_importer_selfcheck)) {
            echo '
						<form method="post">
							<input type="hidden" name="wpbucket_importing" value="1" />
							<input type="submit" name="submit" id="submit" class="button button-primary" value="'.esc_attr__('Import Now!',
                'yowel').'"  />
						</form>';
        }
    } else {
        //user pressed the import button
        if (!empty($wpbucket_demo_importer_success)) {
            //successful import
            echo '<p><b>'.__('Demo content has been successfully imported!',
                'yowel').'</p>';
        } else {
            //something went wrong
            echo '<p><b>'.__('ERROR! Something went wrong!', 'yowel').'</p>';
        }
    }


    //error messages from webhosting check
    if (!empty($wpbucket_demo_importer_selfcheck)) {
        echo '
					<h2 class="title">'.esc_html__('Whooops!', 'yowel').'</h2>
					<p><b>'.esc_html__('One or more problems were found that needs to be fixed before the import!',
            'yowel').'</b></p>
					<ul>';

        foreach ($wpbucket_demo_importer_selfcheck as $err) {
            echo '<li>&bull; '.$err.'</li>';
        }

        echo '</ul>';
    }

    echo '</div>';
}
?>