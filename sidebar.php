<?php
/**
 * Copyright (c) 24/10/2016.
 * Theme Name: yowel
 * Author: wpthemebooster
 * Website: https://wpthemebooster.com
 */
$page_sidebar_id = 'blog-sidebar-id';
if (is_active_sidebar($page_sidebar_id)) :
    dynamic_sidebar($page_sidebar_id);
endif;