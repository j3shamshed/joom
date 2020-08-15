<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */

if (post_password_required()) : ?>
    <p class="nopassword"><?php esc_html_e('This post is password protected. Enter the password to view any comments.', 'yowel'); ?></p>

    <?php
    /*
     * Stop the rest of comments.php from being processed,
     * but don't kill the script entirely -- we still have
     * to fully load the template.
     */
    return;


endif;
?>
<?php if (have_comments()) : ?>
    <div class="comment-sec">
        <h4 class="widget_title">
            <span><?php echo Wpbucket_Helpers::wpbucket_get_comments_number(get_the_ID(), true); ?></span></h4>
        <div class="blog-comments">
            <ul class="comment-area">
                <?php
                /*
                 * Loop through and list the comments.
                 */
                wp_list_comments(array(
                    'callback' => 'Wpbucket_partials::wpbucket_render_comments'
                ));
                ?>
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
                    <div class="comments-pagination comment">
                        <?php paginate_comments_links(); ?>
                    </div>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php
elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :
    ?>
    <p class="nocomments"><?php esc_html_e('Comments are closed.', 'yowel'); ?></p>
<?php
endif; ?>
<div class="divider clearfix"></div>

<div class="comment_form">
        <?php

        $args = array(
            'id_form' => 'commentform',
            'class_form' => 'contact-form row',
            'id_submit' => 'submit',
            'class_submit' => 'btn',
            'name_submit' => 'submit',
            'title_reply' => __('Leave a comment', 'yowel'),
            'title_reply_to' => __('Leave a comment to %s', 'yowel'),
            'title_reply_before' => '<h4 class="widget_title"><span>',
            'title_reply_after' => '</span></h4>',
            'cancel_reply_link' => __('Cancel Reply', 'yowel'),
            'label_submit' => __('Leave a reply', 'yowel'),
            'format' => 'xhtml',

            'must_log_in' => '<p class="must-log-in col-md-12">' .
                sprintf(
                    __('You must be <a href="%s">logged in</a> to post a comment.', 'yowel'),
                    wp_login_url(apply_filters('the_permalink', get_permalink()))
                ) . '</p>',

            'logged_in_as' => '<p class="logged-in-as col-md-12">' .
                sprintf(
                    __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'yowel'),
                    admin_url('profile.php'),
                    $user_identity,
                    wp_logout_url(apply_filters('the_permalink', get_permalink()))
                ) . '</p>',

            'comment_notes_before' => '',
            'submit_button' => '<div class="col-md-12"><div class="submit-btn">
            <input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />
        </div></div>'

        );
        comment_form($args);
        ?>
</div>