<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */
defined('ABSPATH') or die("No script kiddies please!");
$footer_show_hide = wpbucket_return_theme_option('footer_show', '', 1);
$social_html      = Wpbucket_Partials::wpbucket_generate_social_html('footer_social_icons');
$images           = explode(',',
    wpbucket_return_theme_option('wpbucket_gallery'));
global $wpbucket_theme_config;
?>
<footer id="footer" class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="footer-bottom">
                    <div class="footer-logo">
                        <?php
                        echo Wpbucket_Partials::wpbucket_generate_footerlogo_html();
                        ?>
                    </div>
                    <div class="copyright"><?php
                        echo apply_filters('the_content',
                            wpbucket_return_theme_option('copyright_right_text',
                                '', 'Gaya UI Kit that can help you design easy
entire websites in Sketch & Photoshop.'));
                        ?></div>
                </div>
            </div>
            <div class="col-md-5">
                  <?php
                echo Wpbucket_Partials::wpbucket_generate_footer_menu();
                ?>
            </div>
        </div>

    </div>

</footer>
<?php wp_footer(); ?>
</body>
</html>