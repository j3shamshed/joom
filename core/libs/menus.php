<?php

/* ---------------------------------------------------------
 * Menu Walker
 *
 * Custom Menu Walker with addition of icons.
  ---------------------------------------------------------- */
if (!class_exists('Wpbucket_Theme_Menu_Walker')) {


    class Wpbucket_Theme_Menu_Walker extends Walker_Nav_Menu
    {
        /**
         * Start Level.
         *
         * @see Walker::start_lvl()
         * @since 3.0.0
         *
         * @access public
         * @param mixed $output Passed by reference. Used to append additional content.
         * @param int   $depth (default: 0) Depth of page. Used for padding.
         * @param array $args (default: array()) Arguments.
         * @return void
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul role=\"menu\" class=\"sub-menu\" >\n";
        }
        /**
         * Start El.
         *
         * @see Walker::start_el()
         * @since 3.0.0
         *
         * @access public
         * @param mixed $output Passed by reference. Used to append additional content.
         * @param mixed $item Menu item data object.
         * @param int   $depth (default: 0) Depth of menu item. Used for padding.
         * @param array $args (default: array()) Arguments.
         * @param int   $id (default: 0) Menu item ID.
         * @return void
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            /**
             * Dividers, Headers or Disabled
             * =============================
             * Determine whether the item is a Divider, Header, Disabled or regular
             * menu item. To prevent errors we use the strcasecmp() function to so a
             * comparison that is not case sensitive. The strcasecmp() function returns
             * a 0 if the strings are equal.
             */
            if ( 0 === strcasecmp( $item->attr_title, 'divider' ) && 1 === $depth ) {
                $output .= $indent . '<li role="presentation" class="divider">';
            } elseif ( 0 === strcasecmp( $item->title, 'divider' ) && 1 === $depth ) {
                $output .= $indent . '<li role="presentation" class="divider">';
            } elseif ( 0 === strcasecmp( $item->attr_title, 'dropdown-header' ) && 1 === $depth ) {
                $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
            } elseif ( 0 === strcasecmp( $item->attr_title, 'disabled' ) ) {
                $output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
            }elseif ( 0 === strcasecmp( $item->title, 'search' ) ) {
                $output .= $indent . '<li class="search-holder">
		        	<span class="search-button" onclick="openNav()">
		        		<i class="fa fa-search" aria-hidden="true"	></i>
		        	</span>';
            }else {
                $class_names = $value = '';
                $classes = empty( $item->classes ) ? array() : (array) $item->classes;
                $classes[] = 'menu-item-' . $item->ID;
                $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
                if ( $args->has_children ) {
                    $class_names .= ' dropdown'; }
                if ( in_array( 'current-menu-item', $classes, true ) ) {
                    $class_names .= ' active'; }
                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
                $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
                $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
                $output .= $indent . '<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"' . $id . $value . $class_names . '>';
                $atts = array();
                if ( empty( $item->attr_title ) ) {
                    $atts['title']  = ! empty( $item->title )   ? strip_tags( $item->title ) : '';
                } else {
                    $atts['title'] = $item->attr_title;
                }
                $atts['target'] = ! empty( $item->target )	? $item->target	: '';
                $atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
                // If item has_children add atts to a.
                if ( $args->has_children && 0 === $depth ) {
                    $atts['href']   		= ! empty( $item->url ) ? $item->url : '#'; //'#';
                    //$atts['data-toggle']	= 'dropdown';
                    //$atts['class']			= 'dropdown-toggle';
                    $atts['aria-haspopup']	= 'true';
                } else {
                    $atts['href'] = ! empty( $item->url ) ? $item->url : '';
                }
                $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
                $attributes = '';
                foreach ( $atts as $attr => $value ) {
                    if ( ! empty( $value ) ) {
                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                    }
                }
                $item_output = $args->before;
                /*
                 * Glyphicons/Font-Awesome
                 * ===========
                 * Since the the menu item is NOT a Divider or Header we check the see
                 * if there is a value in the attr_title property. If the attr_title
                 * property is NOT null we apply it as the class name for the glyphicon.
                 */
                if ( ! empty( $item->attr_title ) ) :
                    $pos = strpos( esc_attr( $item->attr_title ), 'glyphicon' );
                    if ( false !== $pos ) :
                        $item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></span>&nbsp;';
                    else :
                        $item_output .= '<a' . $attributes . '><i class="fa ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></i>&nbsp;';
                    endif;
                else :
                    $item_output .= '<a' . $attributes . '>';
                endif;
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                //$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
                $item_output .= ( $args->has_children && 0 === $depth ) ? '</a>' : '</a>';
                $item_output .= $args->after;
                $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
        }
        /**
         * Traverse elements to create list from elements.
         *
         * Display one element if the element doesn't have any children otherwise,
         * display the element and its children. Will only traverse up to the max
         * depth and no ignore elements under that depth.
         *
         * This method shouldn't be called directly, use the walk() method instead.
         *
         * @see Walker::start_el()
         * @since 2.5.0
         *
         * @access public
         * @param mixed $element Data object.
         * @param mixed $children_elements List of elements to continue traversing.
         * @param mixed $max_depth Max depth to traverse.
         * @param mixed $depth Depth of current element.
         * @param mixed $args Arguments.
         * @param mixed $output Passed by reference. Used to append additional content.
         * @return null Null on failure with no changes to parameters.
         */
        public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
            if ( ! $element ) {
                return; }
            $id_field = $this->db_fields['id'];
            // Display this element.
            if ( is_object( $args[0] ) ) {
                $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); }
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
        /**
         * Menu Fallback
         * =============
         * If this function is assigned to the wp_nav_menu's fallback_cb variable
         * and a menu has not been assigned to the theme location in the WordPress
         * menu manager the function with display nothing to a non-logged in user,
         * and will add a link to the WordPress menu manager if logged in as an admin.
         *
         * @param array $args passed from the wp_nav_menu function.
         */
        public static function fallback( $args ) {
            if ( current_user_can( 'edit_theme_options' ) ) {
                /* Get Arguments. */
                $container = $args['container'];
                $container_id = $args['container_id'];
                $container_class = $args['container_class'];
                $menu_class = $args['menu_class'];
                $menu_id = $args['menu_id'];
                if ( $container ) {
                    echo '<' . esc_attr( $container );
                    if ( $container_id ) {
                        echo ' id="' . esc_attr( $container_id ) . '"';
                    }
                    if ( $container_class ) {
                        echo ' class="' . sanitize_html_class( $container_class ) . '"'; }
                    echo '>';
                }
                echo '<ul';
                if ( $menu_id ) {
                    echo ' id="' . esc_attr( $menu_id ) . '"'; }
                if ( $menu_class ) {
                    echo ' class="' . esc_attr( $menu_class ) . '"'; }
                echo '>';
                echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="' . esc_attr__('Add Menu','yowel') . '">' . esc_html__( 'Add a menu', 'yowel' ) . '</a></li>';
                echo '</ul>';
                if ( $container ) {
                    echo '</' . esc_attr( $container ) . '>'; }
            }
        }
    }

}

/* ---------------------------------------------------------
 * Footer Menu Walker
 *
 * Custom Responsive Menu Walker.
  ---------------------------------------------------------- */
if (!class_exists('Wpbucket_Theme_Footer_Menu_Walker')) {

    class Wpbucket_Theme_Footer_Menu_Walker extends Walker_Nav_Menu
    {
        /**
         * Starts the list before the elements are added.
         *
         * @see Walker::start_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of menu item. Used for padding.
         * @param array $args An array of arguments. @see wp_nav_menu()
         */
        function start_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"submenu\">\n";
        }

        /**
         * Start the element output.
         *
         * @see Walker::start_el()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param array $args An array of arguments. @see wp_nav_menu()
         * @param int $id Current item ID.
         */
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            global $wp_query;

            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            //$hide_icons = of_get_option('menu_hide_icons', 0);
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : ( array )$item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            //$attributes .= $hide_icons ? ' class="no-icons"' : '';

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= ($depth == 0) ? '<span>' . $item->description . '</span>' : "";
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

}

/* ------------------------------------------------------------------
 * Add menu icon to first level menu items.
  ------------------------------------------------------------------- */
if (!function_exists('wpbucket_add_menu_icon')) {

    function wpbucket_add_menu_icon($item)
    {

        // find selected icons from Theme options and set for each menu item
        if ($item->post_type == 'nav_menu_item' && $item->menu_item_parent == 0) {

            // get icons from theme options
            $menu_icons = wpbucket_return_theme_option('menu_icons');

            // if icons is set, add span element before menu item text
            if (!empty($menu_icons[$item->ID])) {
                $menu_icon = "<span class='nav-icon {$menu_icons[$item->ID]}'></span>";
            } else {
                $menu_icon = '';
            }

            return $menu_icon;
        }
    }

}

add_filter('wpbucket_theme_menu_icon', 'wpbucket_add_menu_icon');