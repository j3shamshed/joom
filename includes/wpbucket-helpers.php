<?php

/*
 * ---------------------------------------------------------
 * Helpers
 *
 * Class for helper functions
 * ----------------------------------------------------------
 */

class Wpbucket_Helpers
{
    /*
     * Return Image Sizes
     * parameter $name_thumbnail
     *
     */

    static function wpbucket_get_theme_related_image_sizes($name_thubnail)
    {

        switch ($name_thubnail) {
            case 'blog_img' :
                $img_width = 750;
                $img_height = 453;
                break;
            case 'blog_single':
                $img_width = 1140;
                $img_height = 650;
                break;
            case 'wpbucket_grid':
                $img_width = 453;
                $img_height = 340;
                break;
            case 'wpbucket_grid_alt':
                $img_width = 360;
                $img_height = 480;
                break;
            case 'wpbucket_ser_alt':
                $img_width = 760;
                $img_height = 506;
                break;
            default:
                $img_width = 372;
                $img_height = 248;
                break;
        }

        return array(
            'width' => $img_width,
            'height' => $img_height
        );
    }

    /*
     * Return Image Url
     * Parameter $post_id
     *
     */

    static function wpbucket_get_image_url($post_id)
    {
        $thumbnail = get_post_thumbnail_id($post_id);
        $image_url = wp_get_attachment_url($thumbnail, 'full');

        return $image_url;
    }

    /*
       * Return Number of comments
       * Parameter $post_id
       *
       */
    static function wpbucket_get_comments_number($postid, $link = false)
    {
        $num_comments = get_comments_number($postid); // get_comments_number returns only a numeric value

        if (comments_open()) {
            if ($num_comments == 0) {
                $comments = __('No Comments', 'yowel');
            } elseif ($num_comments > 1) {
                $comments = $num_comments . __(' Comments', 'yowel');
            } else {
                $comments = __('1 Comment', 'yowel');
            }
            if ($link) {
                $write_comments = $comments;
            } else {
                $write_comments = '<a href="' . get_comments_link() . '">' . $comments . '</a>';
            }

        } else {
            $write_comments = __('Comments are off for this post.', 'yowel');
        }

        return $write_comments;
    }

    /*
       * Return Number of Rating
       * Parameter $post_id
       *
       */
    static function wpbucket_get_rating_number($postid, $link = false)
    {
        $num_comments = get_comments_number($postid); // get_comments_number returns only a numeric value

        if (comments_open()) {
            if ($num_comments == 0) {
                $comments = __('Review', 'yowel');
            } elseif ($num_comments > 1) {
                $comments = $num_comments . __(' Reviews', 'yowel');
            } else {
                $comments = __('1 Review', 'yowel');
            }
            if ($link) {
                $write_comments = $comments;
            } else {
                $write_comments = '<a href="' . get_comments_link() . '">' . $comments . '</a>';
            }

        } else {
            $write_comments = __('Reviews are off for this post.', 'yowel');
        }

        return $write_comments;
    }

    /*
     * AVERAGE REVIEW FOR LOCATION
     *
     * */
    static function wpbucket_average_rating($post_id)
    {
        $total_count = self::wpbucket_get_approved_comment_count($post_id,'no');
        $comments = self::wpbucket_get_comments_by_id($post_id);
        $total = 0;
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $total = $total + get_comment_meta($comment->comment_ID, 'wpbucket_rate', true);
            }
        }
        if ($total_count==0) {
            return 0;
        }else{
            return $total / $total_count;
        }
    }

    /*
     * GET COMMENTS USING ID
     * */
    static function wpbucket_get_comments_by_id($post_id)
    {
        $args = array(
            'post_id' => $post_id,
            'status' => 'approve',
        );
        $comments = get_comments($args);
        return $comments;
    }

    /*GET TOAL APPROVED COMMENT COUNT
     * */
    static function wpbucket_get_approved_comment_count($post_id,$content='yes')
    {
        $comments_count = wp_count_comments($post_id);
        if ($comments_count) {
            $total_count = $comments_count->approved;
        } else {
            $total_count = 0;
        }
        if ($content=='yes' && $total_count==0) {
                return wpbucket_return_theme_option('wpbucket_review_text','','No Review Yet');
        }else{
            return $total_count;
        }
    }

    /*IMAGE UPLOADER*/
    static function wpbucket_handle_attachment($file_handler,$post_id=0,$set_thu=false) {
        // check to make sure its a successful upload
        if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        $attach_id = media_handle_upload( $file_handler, $post_id );

        // If you want to set a featured image frmo your uploads.
        //if ($set_thu) set_post_thumbnail($post_id, $attach_id);
        return $attach_id;
    }
}
