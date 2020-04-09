<?php
/**
 * WooCommerce compatibility, only included when WooCommerce is active.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

// Remove default WooCommerce sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Remove default WooCommerce content wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

// Remove default WooCommerce breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// Remove WooCommerce catalog ordering ability
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Remove `Add to cart` buttons from product archives
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

// Remove rating from product loops
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// Replace default pagination with the Catalyst pagination
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'catalyst_pagination', 10 );

/**
 * Prevents the theme from automatically applying custom settings to the banner area
 * for WooCommerce archive pages
 *
 * @since Catalyst 0.0.0
 *
 * @param array $settings The current page settings being used
 * @return bool
 */
function catalyst_woocommerce_maybe_remove_archive_filter( $settings ) {
   if ( is_woocommerce() ) {
      remove_filter( 'catalyst_page_settings', 'catalyst_archive_page_settings', 10 );
   }
   return $settings;
}
add_filter( 'catalyst_page_settings', 'catalyst_woocommerce_maybe_remove_archive_filter', 5 );

/**
 * Hides the WooCommerce results count when the shop home page is being viewed.
 *
 * @since Catalyst 0.0.0
 *
 * @param bool $show Show.hide the page title
 * @return bool
 */
function catalyst_woocommerce_maybe_hide_result_count() {
   if ( is_shop() || is_product_category() || is_product_tag() || ( is_search() && is_woocommerce() ) ) {
      remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
   }
}
add_action( 'woocommerce_before_shop_loop', 'catalyst_woocommerce_maybe_hide_result_count', 5 );

/**
 * Hides the WooCommerce page title when the shop home page is being viewed.
 *
 * @since Catalyst 0.0.0
 *
 * @param bool $show Show.hide the page title
 * @return bool
 */
function catalyst_woocommerce_maybe_hide_page_title( $show ) {
   if ( is_shop() || is_product_category() || is_product_tag() || ( is_search() && is_woocommerce() ) ) {
      return false;
   }
   return $show;
}
add_filter( 'woocommerce_show_page_title', 'catalyst_woocommerce_maybe_hide_page_title', 5 );

/**
 * Modify the ouput of post class list.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $classes Existing class list
 * @return array
 */
function catalyst_woocommerce_post_class( $classes ) {
   if ( 'product' === get_post_type() ) {
      $classes = array_diff($classes, array('boxed-entry'));
   }
   return $classes;
}
add_filter( 'post_class', 'catalyst_woocommerce_post_class', 10 );

/**
 * Modify the number of products displayed per page on shop archive pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param int $per_page Existing number of products per page
 * @return array
 */
function catalyst_woocommerce_products_per_page( $per_page ) {
   if ( $custom_per_page = get_theme_mod( 'woocommerce_shop_per_page', 16 ) ) {
      $per_page = $custom_per_page;
   }
   return $per_page;
}
add_filter( 'loop_shop_per_page', 'catalyst_woocommerce_products_per_page', 20 );

/**
 * Modify the ouput of the layout class of WooCommerce related pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $location The current widget area to use for the sidebar
 * @return string
 */
function catalyst_woocommerce_page_layout( $layout ) {
   if ( is_product() ) {
      $layout = get_theme_mod( 'woocommerce_product_layout', $layout );
   }
   else if ( is_woocommerce() || is_cart() || is_checkout() ) {
      $layout = get_theme_mod( 'woocommerce_layout', $layout );
   }
   return $layout;
}
add_filter( 'catalyst_page_layout', 'catalyst_woocommerce_page_layout', 10 );

/**
 * Modify the list of screens that the page settings meta box should be
 * applied to in order to incorporate products.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $screens The current list of enabled screens
 * @return array
 */
function catalyst_woocommerce_page_settings_screens( $screens ) {
   $screens[] = 'product';
   return $screens;
}
add_filter( 'catalyst_page_settings_screens', 'catalyst_woocommerce_page_settings_screens', 10 );

/**
 * Ensure that on shop archive pages the appropriate post ID is being used
 * to set up the page settings.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $post_id The current post ID being used
 * @return int
 */
function catalyst_woocommerce_page_settings_post_id( $post_id ) {
   if ( is_shop() && ! is_search() && $shop_id = get_option( 'woocommerce_shop_page_id' ) ) {
      $post_id = $shop_id;
   }
   return $post_id;
}
add_filter( 'catalyst_page_settings_post_id', 'catalyst_woocommerce_page_settings_post_id', 10 );

/**
 * Ensure that on shop archive pages the banner is configured correctly
 *
 * @since Catalyst 0.0.0
 *
 * @param array $settings The current page settings being used
 * @return int
 */
function catalyst_woocommerce_page_settings( $settings ) {
   if ( is_product_category() || is_product_tag() || ( is_search() && is_woocommerce() ) ) {

      // Grab the title
      ob_start();
      woocommerce_page_title();
      $settings['banner_title'] = trim( strip_tags( ob_get_clean() ) );

      // Grab the result count
      ob_start();
      woocommerce_result_count();
      $settings['banner_tagline'] = trim( strip_tags( ob_get_clean() ) );
   }
   return $settings;
}
add_filter( 'catalyst_page_settings', 'catalyst_woocommerce_page_settings', 10 );

/**
 * Adds a sidebar specific to WooCommerce related pages.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_woocommerce_sidebar() {
   register_sidebar( array(
      'name'          => esc_html__( 'Shop Sidebar', 'catalyst' ),
      'id'            => 'catalyst-woocommerce-sidebar',
      'description'   => esc_html__( 'Add widgets here to appear in the sidebar of shop related pages. If this widget area is left empty then the default sidebar will be used instead.', 'catalyst' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
   ) );

   register_sidebar( array(
      'name'          => esc_html__( 'Product Sidebar', 'catalyst' ),
      'id'            => 'catalyst-woocommerce-product-sidebar',
      'description'   => esc_html__( 'Add widgets here to appear in the sidebar of single WooCommerce product pages. If this widget area is left empty then the shop sidebar will be used instead.', 'catalyst' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
   ) );
}
add_action( 'widgets_init', 'catalyst_woocommerce_sidebar' );

/**
 * Makes sure the WooCommerce specific sidebar is used on WooCommerce related pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $location The current widget area to use for the sidebar
 * @return string
 */
function catalyst_woocommerce_sidebar_widget_area( $widget_area ) {
   if ( ( is_woocommerce() || is_cart() || is_checkout() ) && is_active_sidebar('catalyst-woocommerce-sidebar') ) {
      $widget_area = 'catalyst-woocommerce-sidebar';
   }
   if ( is_product() && is_active_sidebar('catalyst-woocommerce-product-sidebar') ) {
      $widget_area = 'catalyst-woocommerce-product-sidebar';
   }
   return $widget_area;
}
add_filter( 'catalyst_sidebar_widget_area', 'catalyst_woocommerce_sidebar_widget_area' );

/**
 * Register Theme Customizer functionality specific to WooCommerce.
 *
 * @since Catalyst 0.0.0
 *
 * @uses catalyst_get_page_layout_options()
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function catalyst_woocommerce_customize_register( $wp_customize ) {
   $wp_customize->add_section( 'catalyst_woocommerce', array(
      'title'    => 'WooCommerce',
      'priority' => 39,
   ) );

   $wp_customize->add_setting( 'woocommerce_cart_menu', array(
      'default'           => true,
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'woocommerce_layout', array(
      'default'           => get_theme_mod( 'page_layout', 'sidebar-right' ),
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_layout'
   ) );

   $wp_customize->add_setting( 'woocommerce_product_layout', array(
      'default'           => get_theme_mod( 'page_layout', 'sidebar-right' ),
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_layout'
   ) );

   $wp_customize->add_setting( 'woocommerce_shop_per_page', array(
      'default'           => 16,
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_woocommerce_sanitize_shop_per_page'
   ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'woocommerce_cart_menu', array(
      'label'       => esc_html__( 'Header Cart Icon', 'catalyst' ),
      'description' => esc_html__( 'Display a cart icon in the header indicating the number of items currently in the cart. The icon will not be displayed when the cart is empty.', 'catalyst' ),
      'section'     => 'catalyst_woocommerce',
      'settings'    => 'woocommerce_cart_menu',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'woocommerce_layout', array(
      'label'       => esc_html__( 'Shop Layout', 'catalyst' ),
      'description' => esc_html__( 'The default page layout for WooCommerce related pages. This can be overriden on a per page basis using the Catalyst Page Settings meta box.', 'catalyst' ),
      'section'     => 'catalyst_woocommerce',
      'settings'    => 'woocommerce_layout',
      'type'        => 'select',
      'choices'     => catalyst_get_page_layout_options(),
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'woocommerce_product_layout', array(
      'label'       => esc_html__( 'Product Layout', 'catalyst' ),
      'description' => esc_html__( 'The default page layout for all WooCommerce products. This can be overriden on a per product basis using the Catalyst Page Settings meta box.', 'catalyst' ),
      'section'     => 'catalyst_woocommerce',
      'settings'    => 'woocommerce_product_layout',
      'type'        => 'select',
      'choices'     => catalyst_get_page_layout_options(),
   ) ) );

   for ( $i=4; $i<41; $i+=4 ) {
      $perpage_options[$i] = $i;
   }

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'woocommerce_shop_per_page', array(
      'label'       => esc_html__( 'Products Per Page', 'catalyst' ),
      'description' => esc_html__( 'Maximum number of products displayed on shop archive pages.', 'catalyst' ),
      'section'     => 'catalyst_woocommerce',
      'settings'    => 'woocommerce_shop_per_page',
      'type'        => 'select',
      'choices'     => $perpage_options,
   ) ) );
}
add_action( 'customize_register', 'catalyst_woocommerce_customize_register' );

/**
 * Sanitize the option for number of products per page
 *
 * @since Catalyst 0.0.0
 *
 * @param mixed $input The submitted user input
 * @return int
 */
function catalyst_woocommerce_sanitize_shop_per_page( $input ) {
   return intval( $input );
}

/**
 * Adds the inline styles for the accent colors.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_woocommerce_dynamic_styles() {
   $accent_one = get_theme_mod('accent_one', '#FF2A68' );
   $accent_two = get_theme_mod('accent_two', '#FF5E3A' );
   ob_start(); ?>

      /* Header cart icon */
      #cart-menu .cart-item-count {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      #cart-menu a:hover {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }

      /* Color scheme for on sale icon */
      .woocommerce  .product .onsale {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
      }

      /* Sidebar product lists */
      #sidebar ul.product_list_widget li a:hover {
         color: <?php echo catalyst_esc_css( $accent_one ); ?> !important;
      }

      /* Reset button styles */
      .woocommerce a.button,
      .woocommerce button.button,
      .woocommerce a.button:hover,
      .woocommerce button.button:hover,
      .woocommerce a.button.alt,
      .woocommerce button.button.alt,
      .woocommerce a.button.alt:hover,
      .woocommerce button.button.alt:hover {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      .woocommerce a.button:before,
      .woocommerce button.button:before {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
      }
      .woocommerce input.button,
      .woocommerce input.button:hover {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
      }

      /* Remove buttons */
      .woocommerce a.remove:hover,
      .woocommerce .widget_shopping_cart .cart_list li a.remove:hover,
      .woocommerce.widget_shopping_cart .cart_list li a.remove:hover {
         background: <?php echo catalyst_esc_css( $accent_one ); ?> !important;
      }

      /* Price filter widget */
      .woocommerce .widget_price_filter .ui-slider .ui-slider-range {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(left, <?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
         background: linear-gradient(left, <?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_one ); ?>);
      }

      /* Single product price */
      .woocommerce.single-product .entry-summary .price,
      .woocommerce.single-product .entry-summary .price .amount,
      .woocommerce.single-product .entry-summary .price ins .amount {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      .woocommerce.single-product .price del .amount {
         color: #888;
      }

      /* Checkout page */
      .woocommerce-checkout #payment {
         border-top: 2px solid <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
   <?php $inline_css = ob_get_clean();

   // Add the inline stylesheet
   wp_add_inline_style( 'catalyst-style', $inline_css );
}
add_action( 'wp_enqueue_scripts', 'catalyst_woocommerce_dynamic_styles', 20 );