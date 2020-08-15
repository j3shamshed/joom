<?php
/**
 * Copyright (c) 25/01/2017.
 * Theme Name: wpblog
 * Author: pranontheme
 * Website: http://webpentagon.com/
 */
defined('ABSPATH') or die("No script kiddies please!");
$header_social_html = Wpbucket_Partials::wpbucket_generate_header_social_html('header_social_icons');
global $wpbucket_theme_config;
?>
<header id="header" class="header_one">

    <div class="navigation">

        <nav id="flexmenu">
            <div class="nav-inner">
                <div class="logo">
                    <?php
                    echo Wpbucket_Partials::wpbucket_generate_logo_html();
                    ?>
                </div>
                <div id="mobile-toggle" class="mobile-btn"></div>
                <?php
                echo Wpbucket_Partials::wpbucket_generate_menu_html();
                ?>
                <!--                    <div class="quick-button">
                                        <a href="#" class="short-nav">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </a>
                                    </div>-->
                <?php
                if (get_theme_mod('wpbucket_button_show_hide_control') == 0) {
                    $href  = esc_url(get_theme_mod('wpbucket_button_url_control'));
                    $color = esc_attr(get_theme_mod('wpbucket_button_bg_color_control'));
                    $text  = esc_html(get_theme_mod('wpbucket_button_text_control'));
                    ?>
                    <div class="menu-button"><a href="<?php echo esc_url($href) ?>" title="<?php echo esc_attr($text) ?>"><?php echo esc_html($text); ?></a></div>
                    <?php if ($color != '#1539E9') { ?>
                        <style>
                            .menu-button a{
                                background-color: <?php echo esc_attr($color)?>;
                            }
                        </style>
                        <?php
                        }
                        }
                        ?>
            </div>

        </nav>


    </div>
</header>
<!--end page-header-->