<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */

defined('ABSPATH') or die("No script kiddies please!");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="<?php bloginfo('charset'); ?>"/>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php
    wp_head();
    ?>
</head>
<body <?php body_class(); ?>>