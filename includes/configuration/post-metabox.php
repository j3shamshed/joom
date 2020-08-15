<?php

/*
 * ---------------------------------------------------------
 * MetaBox
 *
 * Custom fields registration
 * ----------------------------------------------------------
 */

/*
 * --------------------------------------------------------------------
 * MetaBox for Custom Post Types
 * --------------------------------------------------------------------
 */

function wpbucket_register_meta_boxes($meta_boxes)
{

    $meta_boxes [] = array(
        'id' => "wpbucket_portfolio_display",
        'title' => esc_html__('Project Information', 'yowel'),
        'post_types' => array('page','post'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'id'    => 'wpbucket_oembed',
                'name'  => esc_html__('Oembed Code for video format.','yowel'),
                'type'  => 'oembed',
        
                // Input size
                'size'  => 30,
            ),
            array(
                'name'    => esc_html__('Post format gallery style.','yowel'),
                'id'      => 'wpbucket_radio',
                'type'    => 'radio',
                // Array of 'value' => 'Label' pairs for radio options.
                // Note: the 'value' is stored in meta field, not the 'Label'
                'options' => array(
                    'default' => 'Default',
                    'tiled' => 'Tiled',
                ),
                // Show choices in the same line?
                'inline' => false,
            ),
            array(
                'id'               => 'wpbucket_image',
                'name'             => esc_html__('Post format gallery select images.','yowel'),
                'type'             => 'image_advanced',
    
                // Delete image from Media Library when remove it from post meta?
                // Note: it might affect other posts if you use same image for multiple posts
                'force_delete'     => false,
        
                // Maximum image uploads.
                'max_file_uploads' => 10,
        
                // Do not show how many images uploaded/remaining.
                'max_status'       => 'false',
        
                // Image size that displays in the edit page.
                'image_size'       => 'thumbnail',
            ),
            array(
                'name'    => esc_html__('Shortcode after header','yowel'),
                'id'      => 'wpbucket_shortcode_after_header',
                'type'    => 'wysiwyg',
                'raw'     => false,
                'options' => array(
                    'textarea_rows' => 4,
                    'teeny'         => true,
                ),
            ),
            array(
                'name'    => esc_html__('Shortcode after posts or content','yowel'),
                'id'      => 'wpbucket_shortcode_after_content',
                'type'    => 'wysiwyg',
                'raw'     => false,
                'options' => array(
                    'textarea_rows' => 4,
                    'teeny'         => true,
                ),
            ),
            array(
                'name'    => esc_html__('Shortcode before footer','yowel'),
                'id'      => 'wpbucket_shortcode_before_footer',
                'type'    => 'wysiwyg',
                'raw'     => false,
                'options' => array(
                    'textarea_rows' => 4,
                    'teeny'         => true,
                ),
            )
        )
    );

    return $meta_boxes;
}

add_filter('rwmb_meta_boxes', 'wpbucket_register_meta_boxes');
?>
