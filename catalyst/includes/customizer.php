<?php
/**
 * Catalyst Customizer functionality
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

/**
 * Register Theme Customizer functionality
 *
 * @since Catalyst 0.0.0
 *
 * @uses catalyst_get_page_layout_options()
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function catalyst_customize_register( $wp_customize ) {
   $wp_customize->add_section( 'catalyst_header', array(
      'title'    => esc_html__( 'Header', 'catalyst' ),
      'priority' => 30,
   ) );
   $wp_customize->add_section( 'catalyst_pages', array(
      'title'    => esc_html__( 'Pages', 'catalyst' ),
      'priority' => 30,
   ) );

   $wp_customize->add_section( 'catalyst_layout', array(
      'title'    => esc_html__( 'Layout', 'catalyst' ),
      'priority' => 32,
   ) );

   $wp_customize->add_section( 'catalyst_footer', array(
      'title'    => esc_html__( 'Footer', 'catalyst' ),
      'priority' => 33,
   ) );

   $wp_customize->add_setting( 'sticky_header', array(
      'default'           => true,
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'stretched_header', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'header_highlight_active', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'header_search', array(
      'default'           => true,
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'top_bar_text', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
   ) );

   $wp_customize->add_setting( 'logo', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'esc_url'
   ) );

   $wp_customize->add_setting( 'floating_logo', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'esc_url'
   ) );

   $wp_customize->add_setting( 'enable_default_banner', array(
      'default'           => true,
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'boxed_mode', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'page_layout', array(
      'default'           => 'sidebar-right',
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_layout'
   ) );

   $wp_customize->add_setting( 'search_results_layout', array(
      'default'           => 'sidebar-right',
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_layout'
   ) );

   $wp_customize->add_setting( 'footer_max_columns', array(
      'default'           => '3',
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_footer_max_columns',
   ) );

   $wp_customize->add_setting( 'footer_copyright', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'wp_kses_post'
   ) );

   $wp_customize->add_setting( 'hide_themefyre_attribution', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_setting( 'site_title', array(
      'default'           => '#000000',
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_hex_color'
   ) );

   $wp_customize->add_setting( 'accent_one', array(
      'default'           => '#FF2A68',
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_hex_color'
   ) );

   $wp_customize->add_setting( 'accent_two', array(
      'default'           => '#FF5E3A',
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_hex_color'
   ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sticky_header', array(
      'label'       => esc_html__( 'Sticky Header', 'catalyst' ),
      'description' => esc_html__( 'The header will stick to the top of the screen as the page is scrolled.', 'catalyst' ),
      'section'     => 'catalyst_header',
      'settings'    => 'sticky_header',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'stretched_header', array(
      'label'       => esc_html__( 'Stretched Header', 'catalyst' ),
      'description' => esc_html__( 'The header content will stretch horizontally to fill all available space. Only applicable when "Boxed Mode" has not been enabled.', 'catalyst' ),
      'section'     => 'catalyst_header',
      'settings'    => 'stretched_header',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_highlight_active', array(
      'label'       => esc_html__( 'Highlight Active Menu Items', 'catalyst' ),
      'description' => esc_html__( 'Highlight active menu items in the header.', 'catalyst' ),
      'section'     => 'catalyst_header',
      'settings'    => 'header_highlight_active',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_search', array(
      'label'       => esc_html__( 'Search in Header', 'catalyst' ),
      'description' => esc_html__( 'Display a search bar in the header.', 'catalyst' ),
      'section'     => 'catalyst_header',
      'settings'    => 'header_search',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'top_bar_text', array(
      'label'       => esc_html__( 'Top bar Text', 'catalyst' ),
      'description' => esc_html__( 'Custom text to placed in the top bar above the header on every page. Please note that this text is hidden on smaller screens such as mobile devices.', 'catalyst' ),
      'section'     => 'catalyst_header',
      'settings'    => 'top_bar_text',
      'type'        => 'text',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
      'label'    => esc_html__( 'Logo Image', 'catalyst' ),
      'description' => esc_html__( 'Any size image will work here, although the height will be forced to 50px causing the width to scale proportionally. Please note that in order for your logo to be retina quality it will need to have a height of at least 100px.', 'catalyst' ),
      'section'  => 'catalyst_header',
      'settings' => 'logo',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'floating_logo', array(
      'label'    => esc_html__( 'Floating Header Logo Image', 'catalyst' ),
      'description' => esc_html__( 'Should be the same size as the standard logo image, will be used on any page where the floating header has been enabled.', 'catalyst' ),
      'section'  => 'catalyst_header',
      'settings' => 'floating_logo',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'enable_default_banner', array(
      'label'       => esc_html__( 'Display Page Titles Automatically', 'catalyst' ),
      'description' => esc_html__( 'Automaticaly display the title of each page in the banner area by default, you will be able to hide the banner area for each page individually using the Catalyst Page Settings meta box.', 'catalyst' ),
      'section'     => 'catalyst_pages',
      'settings'    => 'enable_default_banner',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'boxed_mode', array(
      'label'       => esc_html__( 'Boxed Mode', 'catalyst' ),
      'description' => esc_html__( 'The layout will be constrained within a box, revealing the background on either side.', 'catalyst' ),
      'section'     => 'catalyst_layout',
      'settings'    => 'boxed_mode',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'page_layout', array(
      'label'       => esc_html__( 'Page Layout', 'catalyst' ),
      'description' => esc_html__( 'The default page layout for all content. This can be overriden on a per page basis using the Catalyst Page Settings meta box.', 'catalyst' ),
      'section'     => 'catalyst_layout',
      'settings'    => 'page_layout',
      'type'        => 'select',
      'choices'     => catalyst_get_page_layout_options(),
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'search_results_layout', array(
      'label'       => esc_html__( 'Search Results Layout', 'catalyst' ),
      'description' => esc_html__( 'The page layout for search results pages.', 'catalyst' ),
      'section'     => 'catalyst_layout',
      'settings'    => 'search_results_layout',
      'type'        => 'select',
      'choices'     => catalyst_get_page_layout_options(),
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_max_columns', array(
      'label'       => esc_html__( 'Footer Widgetized Columns', 'catalyst' ),
      'description' => esc_html__( 'Maximum number of columns the widgetized area in the footer should be divided into.', 'catalyst' ),
      'section'     => 'catalyst_footer',
      'settings'    => 'footer_max_columns',
      'type'        => 'select',
      'choices'     => array(
         '1' => '1',
         '2' => '2',
         '3' => '3',
         '4' => '4',
      ),
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_copyright', array(
      'label'       => esc_html__( 'Copyright Text', 'catalyst' ),
      'description' => sprintf( esc_html__( 'Custom copyright text, leave this blank to use the default text: %s.', 'catalyst' ), '&copy;'.date('Y').' '.get_bloginfo('name') ),
      'section'     => 'catalyst_footer',
      'settings'    => 'footer_copyright',
      'type'        => 'text',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'hide_themefyre_attribution', array(
      'label'       => esc_html__( 'Hide Themefyre Attribution', 'catalyst' ),
      'description' => esc_html__( 'Check this box to hide the Themefyre attribution text in the socket area.', 'catalyst' ),
      'section'     => 'catalyst_footer',
      'settings'    => 'hide_themefyre_attribution',
      'type'        => 'checkbox',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_title', array(
      'label'       => esc_html__( 'Site Title', 'catalyst' ),
      'description' => esc_html__( 'Only applicable when a custom logo image is not in use. Will be applied to the default textual site title only.', 'catalyst' ),
      'section'     => 'colors',
      'settings'    => 'site_title',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_one', array(
      'label'    => esc_html__( 'Accent One', 'catalyst' ),
      'section'  => 'colors',
      'settings' => 'accent_one',
   ) ) );

   $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_two', array(
      'label'    => esc_html__( 'Accent Two', 'catalyst' ),
      'section'  => 'colors',
      'settings' => 'accent_two',
   ) ) );
}
add_action( 'customize_register', 'catalyst_customize_register' );

/**
 * Sanitize a boolean value
 *
 * @since Catalyst 0.0.0
 *
 * @param mixed $input The submitted user input
 * @return int
 */
function catalyst_sanitize_bool( $input ) {
   return ( $input );
}

/**
 * Sanitize a layout value
 *
 * @since Catalyst 0.0.0
 *
 * @param mixed $input The submitted user input
 * @return string
 */
function catalyst_sanitize_layout( $input ) {
   return in_array( $input, array( 'sidebar-left', 'sidebar-right', 'centered', 'full-width' ) ) ? $input : 'sidebar-right';
}

/**
 * Sanitize the option for the number of footer columns
 *
 * @since Catalyst 0.0.0
 *
 * @param mixed $input The submitted user input
 * @return string
 */
function catalyst_sanitize_footer_max_columns( $input ) {
   return in_array( $input, array('1','2','3','4') ) ? $input : '3';
}

/**
 * Sanitize a hex value
 *
 * @since Catalyst 0.0.0
 *
 * @param mixed $input The submitted user input
 * @return string
 */
function catalyst_sanitize_hex_color( $input ) {
   if ( '' === $input ) {
      return '';
   }
   if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $input ) ) {
      return $input;
   }
   return null;
}

/**
 * Prepares a string to be output into the CSS
 *
 * @since Catalyst 0.0.0
 *
 * @param mixed $input The submitted user input
 * @return string
 */
function catalyst_esc_css( $input ) {
   return esc_html( $input );
}

/**
 * Adds the inline styles for the accent colors.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_dynamic_styles() {
   $site_title = get_theme_mod('site_title', '#000000' );
   $accent_one = get_theme_mod('accent_one', '#FF2A68' );
   $accent_two = get_theme_mod('accent_two', '#FF5E3A' );
   ob_start(); ?>

      /* Custom text selection color */
      ::selection {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      ::-moz-selection {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }

      /* Buttons */
      a.button,
      button.button {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      a.button:before,
      button.button:before {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }
      input.button {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      <?php if ( get_theme_mod('header_highlight_active') ) : ?>
         body:not(.floating-header) #header .site-navigation > ul > li.current_page_item > a,
         body:not(.floating-header) #header .site-navigation > ul > li.current_page_item > a:hover,
         body.floating-header.sticky-header-active #header .site-navigation > ul > li.current_page_item > a,
         body.floating-header.sticky-header-active #header .site-navigation > ul > li.current_page_item > a:hover,
         body:not(.floating-header) #header .site-navigation > ul > li.current_page_parent > a,
         body:not(.floating-header) #header .site-navigation > ul > li.current_page_parent > a:hover,
         body.floating-header.sticky-header-active #header .site-navigation > ul > li.current_page_parent > a,
         body.floating-header.sticky-header-active #header .site-navigation > ul > li.current_page_parent > a:hover,
         body:not(.floating-header) #header .site-navigation > ul > li.current_page_ancestor > a,
         body:not(.floating-header) #header .site-navigation > ul > li.current_page_ancestor > a:hover,
         body.floating-header.sticky-header-active #header .site-navigation > ul > li.current_page_ancestor > a,
         body.floating-header.sticky-header-active #header .site-navigation > ul > li.current_page_ancestor > a:hover {
            color: <?php echo catalyst_esc_css( $accent_one ); ?> !important;
         }
      <?php endif; ?>

      /* Sub Menus */
      #header .site-navigation .nav-menu > li > .sub-menu {
         border-top: 2px solid <?php echo catalyst_esc_css( $accent_one ); ?>;
      }

      /* Search Menu Button */
      #search-menu #open-search:hover {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }

      /* Site Title Color */
      #header .site-title {
         color: <?php echo catalyst_esc_css( $site_title ); ?>;
      }

      /* Main section links */
      a {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      a:hover {
         color: <?php echo catalyst_esc_css( $accent_two ); ?>;
      }

      /* Pagination */
      #main .pagination .nav-links > .current,
      #main .page-links > span {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      /* Sidebar widget top borders */
      #sidebar .widget:before {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(left,<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(left,<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      /* Alternating entry borders */
      #main .boxed-entry {
         border-top: 2px solid <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      #main .boxed-entry:nth-child(2n) {
         border-top: 2px solid <?php echo catalyst_esc_css( $accent_two ); ?>;
      }

      /* Alternating widget links hover */
      #sidebar .widget a {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      #sidebar .widget a:hover {
         color: <?php echo catalyst_esc_css( $accent_two ); ?>;
      }
      #sidebar .widget:nth-child(2n) a {
         color: <?php echo catalyst_esc_css( $accent_two ); ?>;
      }
      #sidebar .widget:nth-child(2n) a:hover {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }

      /* Main navigation links */
      #header .site-navigation .nav-menu > li:not(.catalyst-featured):hover > a {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      #header .site-navigation .nav-menu > li.catalyst-featured > a {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      #header .site-navigation .nav-menu > li.catalyst-featured > a:before {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      /* Catalyst Featured Content Widget */
      .widget_catalyst_featured_text {
         background: <?php echo catalyst_esc_css( $accent_one ); ?> !important;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>) !important;
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>) !important;
      }

      /* Off Canvas Panel */
      #off-canvas-panel {
         background: <?php echo catalyst_esc_css( $accent_one ); ?> !important;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>) !important;
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>) !important;
      }

      /* Post Previews */
      #main .post-preview:not(.post-thumbnail) a .post-breview-thumbnail {
         background: <?php echo catalyst_esc_css( $accent_one ); ?> !important;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>) !important;
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>) !important;
      }

   <?php $inline_css = ob_get_clean();

   // Add the inline stylesheet
   wp_add_inline_style( 'catalyst-style', $inline_css );
}
add_action( 'wp_enqueue_scripts', 'catalyst_dynamic_styles', 20 );