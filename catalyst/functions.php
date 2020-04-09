<?php
/**
 * Catalyst functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Catalyst 0.0.0
 */
if ( ! isset( $content_width ) ) {
   $content_width = 813;
}

if ( ! function_exists( 'catalyst_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_setup() {

   // Add support for the Themefyre Page Builder plugin.
   add_theme_support( 'themefyre-page-builder', array(
      'content_max_width'   => 1250,
      'scroll_top_offset'   => get_theme_mod('sticky_header', true) ? 70 : 0,
      'content_spacer_size' => 22,
      'theme_google_fonts'  => array(
         'Open Sans' => '300,300italic,400,400italic,600,600italic,700,700italic',
         'Lato'      => '100,300,400,700',
      ),
      'theme_text_styles'   => array(
         'banner-title'         => esc_html__( 'Banner Title', 'catalyst' ),
         'banner-tagline'       => esc_html__( 'Banner Tagline', 'catalyst' ),
         'large-thin'           => esc_html__( 'Large & Thin', 'catalyst' ),
         'large-uppercase-bold' => esc_html__( 'Large, Uppercase & Bold', 'catalyst' ),
         'small-uppercase-bold' => esc_html__( 'Small, Uppercase & Bold', 'catalyst' ),
      ),
   ) );

   // Delcare theme support for WooCommerce
   add_theme_support( 'woocommerce' );

   /*
    * Make theme available for translation.
    * Translations can be filed in the /languages/ directory.
    * If you're building a theme based on catalyst, use a find and replace
    * to change 'catalyst' to the name of your theme in all the template files
    */
   load_theme_textdomain( 'catalyst', get_template_directory() . '/languages' );

   // Add default posts and comments RSS feed links to head.
   add_theme_support( 'automatic-feed-links' );

   /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
   add_theme_support( 'title-tag' );

   /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    */
   add_theme_support( 'post-thumbnails' );
   set_post_thumbnail_size( 1666 );

   // Post preview thumbnail size
   add_image_size( 'catalyst-post-preview', 950, 950, true );

   // This theme uses wp_nav_menu() in two locations.
   register_nav_menus( array(
      'primary'        => esc_html__( 'Primary Menu', 'catalyst' ),
      'secondary'      => esc_html__( 'Secondary Menu', 'catalyst' ),
      'mobile'         => esc_html__( 'Mobile Menu', 'catalyst' ),
      'mobile-social'  => esc_html__( 'Mobile Social Media Menu', 'catalyst' ),
      'top-bar-menu'   => esc_html__( 'Top Bar Menu', 'catalyst' ),
      'top-bar-social' => esc_html__( 'Top Bar Social Media Menu', 'catalyst' ),
      'footer'         => esc_html__( 'Footer Socket Menu', 'catalyst' ),
      'footer-social'  => esc_html__( 'Footer Social Media Menu', 'catalyst' ),
   ) );

   /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
   add_theme_support( 'html5', array(
      'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
   ) );

   /*
    * Setup the WordPress core custom background feature.
    *
    * See: http://codex.wordpress.org/Custom_Backgrounds
    */
   add_theme_support( 'custom-background', array(
      'default-color' => '#333333',
   ) );

   /*
    * This theme styles the visual editor to resemble the theme style,
    * specifically font, icons, and colors.
    */
   add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', catalyst_fonts_url() ) );
}
endif;
add_action( 'after_setup_theme', 'catalyst_setup' );

/**
 * Returns the version number for Catalyst
 *
 * @since Catalyst 0.0.0
 *
 * @return int
 */
function catalyst_get_version() {
   $catalyst = wp_get_theme( 'catalyst' );
   return $catalyst->get( 'Version' );
}

/**
 * Register widget areas.
 *
 * @since Catalyst 0.0.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function catalyst_widgets_init() {
   register_sidebar( array(
      'name'          => esc_html__( 'Sidebar', 'catalyst' ),
      'id'            => 'catalyst-sidebar',
      'description'   => esc_html__( 'Add widgets here to appear in the sidebar.', 'catalyst' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
   ) );

   register_sidebar( array(
      'name'          => esc_html__( 'Search Results Sidebar', 'catalyst' ),
      'id'            => 'catalyst-search-sidebar',
      'description'   => esc_html__( 'Add widgets here to appear in the sidebar of the search results page. If this widget area is left empty then the default sidebar will be used instead.', 'catalyst' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
   ) );

   register_sidebar( array(
      'name'          => esc_html__( 'Footer', 'catalyst' ),
      'id'            => 'catalyst-footer',
      'description'   => esc_html__( 'Add widgets here to appear in the footer. The footer will automatically be arranged into columns depending on the number of widgets that are added here.', 'catalyst' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
   ) );
}
add_action( 'widgets_init', 'catalyst_widgets_init' );

/**
 * Modify the ouput of the body`s class list.
 *
 * @since Catalyst 0.0.0
 *
 * @uses catalyst_get_layout()
 *
 * @param array $classes Existing class list
 * @return array
 */
function catalyst_body_class( $classes ) {
   $page_settings = catalyst_get_page_settings();

   if ( ! in_array('no-js', $classes) ) {
      $classes[] = 'no-js';
   }

   if ( ! in_array('catalyst', $classes) ) {
      $classes[] = 'catalyst';
   }

   // Sidebar layout class
   $classes[] = catalyst_get_layout();

   // Enable boxed mode
   if ( get_theme_mod( 'boxed_mode' ) ) {
      $classes[] = 'boxed';
   }

   // Enable custom logo support
   if ( get_theme_mod( 'logo' ) ) {
      $classes[] = 'logo-image';

      // Enable custom floating logo support
      if ( get_theme_mod( 'floating_logo' ) ) {
         $classes[] = 'floating-logo-image';
      }
   }

   // Enable floating header when applicable
   if ( in_array( $page_settings['floating_header'], array('enabled', 'enabled-shadow', 'enabled-glassy', 'enabled-border') ) ) {
      $classes[] = 'floating-header';
      if ( 'enabled-shadow' === $page_settings['floating_header'] ) {
         $classes[] = 'floating-header-shadow';
      }
      else if ( 'enabled-glassy' === $page_settings['floating_header'] ) {
         $classes[] = 'floating-header-glassy';
      }
      else if ( 'enabled-border' === $page_settings['floating_header'] ) {
         $classes[] = 'floating-header-border';
      }
   }

   // Enable the sticky header when applicable
   if ( get_theme_mod('sticky_header', true) ) {
      $classes[] = 'sticky-header';
   }

   // Enable the stretched header when applicable
   if ( get_theme_mod('stretched_header') && ! get_theme_mod('boxed_mode') ) {
      $classes[] = 'stretched-header';
   }

   // When the top bar is active
   if ( catalyst_is_top_bar_active() ) {
      $classes[] = 'top-bar';
   }

   // When the banner is active
   if ( catalyst_is_banner_active() ) {
      $classes[] = 'banner';
      if ( $page_settings['banner_title'] || $page_settings['banner_tagline'] ) {
         $classes[] = 'banner-title';
      }
      if ( $page_settings['banner_menu'] ) {
         $classes[] = 'banner-menu';
      }
      if ( $page_settings['banner_image'] ) {
         $classes[] = 'banner-image';
      }
   }

   return $classes;
}
add_filter( 'body_class', 'catalyst_body_class', 10 );

/**
 * Modify the ouput of post class list.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $classes Existing class list
 * @return array
 */
function catalyst_post_class( $classes ) {
   if ( has_post_thumbnail() ) {
      $classes[] = 'post-thumbnail';
   }

   return $classes;
}
add_filter( 'post_class', 'catalyst_post_class', 10 );


if ( ! function_exists( 'catalyst_fonts_url' ) ) :
/**
 * Returns the URL containing which Google Fonts to load
 *
 * @since Catalyst 0.0.0
 */
function catalyst_fonts_url() {
   $fonts_url = '';
   $fonts     = array();

   /*
    * Translators: If there are characters in your language that are not supported
    * by Open Sans, translate this to 'off'. Do not translate into your own language.
    */
   if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'catalyst' ) ) {
      $fonts[] = 'Open Sans:400,300,300italic,400italic,600,600italic,700,700italic';
   }

   /*
    * Translators: If there are characters in your language that are not supported
    * by Lato, translate this to 'off'. Do not translate into your own language.
    */
   if ( 'off' !== _x( 'on', 'Lato font: on or off', 'catalyst' ) ) {
      $fonts[] = 'Lato:400,100,300,700';
   }

   if ( $fonts ) {
      $fonts_url = add_query_arg( array(
         'family' => urlencode( implode( '|', $fonts ) ),
      ), '//fonts.googleapis.com/css' );
   }

   return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_assets() {

   // Load the Google fonts stylesheet.
   wp_enqueue_style( 'catalyst-fonts', catalyst_fonts_url(), false, catalyst_get_version() );

   // Load the Genericons stylesheet.
   wp_enqueue_style( 'genericons', trailingslashit(get_template_directory_uri()) . 'genericons/genericons.css', array(), '3.2' );

   // Load the theme stylesheet.
   wp_enqueue_style( 'catalyst-style', trailingslashit(get_template_directory_uri()) . 'css/theme.css', false, catalyst_get_version() );

   // RTL stylesheet
   if ( is_rtl() ) {
      wp_enqueue_style( 'catalyst-style-rtl', trailingslashit(get_template_directory_uri()) . 'css/rtl.css', false, catalyst_get_version() );
   }

   // Load the theme script file
   wp_enqueue_script( 'catalyst-script', trailingslashit(get_template_directory_uri()) . 'js/theme.js', array( 'jquery', 'underscore', 'masonry' ), catalyst_get_version(), true );

   // Comments reply script
   if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
   }
}
add_action( 'wp_enqueue_scripts', 'catalyst_assets', 10 );

/**
 * Adds the copyright text to the footer socket.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_footer_copyright() {
   $copyright = get_theme_mod('footer_copyright');
   echo ! empty( $copyright ) ? $copyright : '&copy;'.date('Y').' '.get_bloginfo('name');
}
add_action( 'catalyst_footer_copyright', 'catalyst_footer_copyright', 10 );

/**
 * Adds the Themefyre attribution to the footer socket.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_footer_attribution() {
   if ( ! get_theme_mod('hide_themefyre_attribution') ) {
      printf( esc_html__( ' - %1$s Theme by %2$s', 'catalyst' ), 'Catalyst', '<a href="http://themefyre.com/">Themefyre</a>' );
   }
}
add_action( 'catalyst_footer_copyright', 'catalyst_footer_attribution', 20 );

/**
 * Restyles the banner when the banner background image is enabled.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_banner_custom_background() {
   $page_settings = catalyst_get_page_settings();

   // Make sure the banner background image has been enabled
   if ( ! catalyst_is_banner_active() || empty( $page_settings['banner_image'] ) ) {
      return;
   }

   // Will contain the file name of the banner image in use
   $img_info = wp_get_attachment_image_src( $page_settings['banner_image'], 'full' );
   $img_src  = isset( $img_info[0] ) ? $img_info[0] : '';

   // Make sure there is an image to display
   if ( ! $img_src ) {
      return;
   }

   // Begin our inline CSS
   $inline_css = "#banner{background-image:url($img_src);}";

   // Using CSS padding we can force the height of the banner to scale proportionally with the width
   // we just need to make sure we have access to the image height & width information also, this is
   // only applicable if neither the banner title nor the banner menu has been set.
   if ( ! $page_settings['banner_title'] && ! $page_settings['banner_tagline'] && ( ! $page_settings['banner_menu'] || ! wp_get_nav_menu_items( $page_settings['banner_menu'] ) ) && isset( $img_info[1] ) && $img_info[1] && isset( $img_info[2] ) && $img_info[2] ) {
      $height_ratio = ( $img_info[2] / $img_info[1] ) * 100;
      $inline_css .= "#banner:after{padding-top:$height_ratio%;}";
   }

   // Add the inline stylesheet
   wp_add_inline_style( 'catalyst-style', $inline_css );
}
add_action( 'wp_enqueue_scripts', 'catalyst_banner_custom_background', 30 );

/**
 * On static pages display the page title by default, if enabled
 *
 * @since Catalyst 0.0.0
 *
 * @param array $settings The current page settings
 * @return array
 */
function catalyst_page_settings_default_banner( $settings ) {
   if ( is_page() && get_theme_mod( 'enable_default_banner', true ) && ! $settings['banner_title'] ) {
      $settings['banner_title'] = esc_html( get_the_title() );
   }
   return $settings;
}
add_filter( 'catalyst_page_settings', 'catalyst_page_settings_default_banner', 20 );

/**
 * Modify the page layout for 404 pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $layout The current widget area to use for the sidebar
 * @return string
 */
function catalyst_404_page_layout( $layout ) {
   if ( is_404() ) {
      return 'full-width';
   }
   return $layout;
}
add_filter( 'catalyst_page_layout', 'catalyst_404_page_layout', 10 );

/**
 * Modify the page settings for 404 pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $settings The current page settings
 * @return array
 */
function catalyst_404_page_settings( $settings ) {
   if ( is_404() ) {
      $settings['banner_title']   = esc_html__( 'Page Not Found', 'catalyst' );
      $settings['banner_tagline'] = esc_html__( 'Oops! That page can&rsquo;t be found.', 'catalyst' );
   }
   return $settings;
}
add_filter( 'catalyst_page_settings', 'catalyst_404_page_settings', 10 );

/**
 * Modify the page layout for 404 pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $layout The current widget area to use for the sidebar
 * @return string
 */
function catalyst_search_results_page_layout( $layout ) {
   if ( is_search() ) {
      return get_theme_mod( 'search_results_layout', 'sidebar-right' );
   }
   return $layout;
}
add_filter( 'catalyst_page_layout', 'catalyst_search_results_page_layout', 10 );

/**
 * Use the search results sidebar when applicable
 *
 * @since Catalyst 0.0.0
 *
 * @param string $widget_area The current widget area to use for the sidebar
 * @return string
 */
function catalyst_search_results_sidebar_widget_area( $widget_area ) {
   if ( is_search() && is_active_sidebar('catalyst-search-sidebar') ) {
      return 'catalyst-search-sidebar';
   }
   return $widget_area;
}
add_filter( 'catalyst_sidebar_widget_area', 'catalyst_search_results_sidebar_widget_area', 10 );

/**
 * Modify the page settings for archive pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $settings The current page settings
 * @return array
 */
function catalyst_archive_page_settings( $settings ) {
   if ( is_archive() ) {

      // Grab the title
      $settings['banner_title'] = get_the_archive_title();

      // Grab the result count
      $settings['banner_tagline'] = catalyst_get_result_count();
   }
   return $settings;
}
add_filter( 'catalyst_page_settings', 'catalyst_archive_page_settings', 10 );

/**
 * Modify the page settings for blog home pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $post_id The current post ID being used
 * @return int
 */
function catalyst_home_page_settings_post_id( $post_id ) {
   if ( 'page' === get_option( 'show_on_front' ) && ( $posts_page_id = get_option( 'page_for_posts' ) ) && is_home() ) {
      $post_id = $posts_page_id;
   }
   return $post_id;
}
add_filter( 'catalyst_page_settings_post_id', 'catalyst_home_page_settings_post_id', 10 );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_tgmpa_register() {
   $plugins = array(
      array(
         'name'               => 'Themefyre Page Builder', // The plugin name.
         'slug'               => 'themefyre-builder', // The plugin slug (typically the folder name).
         'source'             => get_template_directory().'/plugins/themefyre-builder.zip', // The plugin source.
         'required'           => true, // If false, the plugin is only `recommended` instead of required.
         'version'            => '0.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
         'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
         'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      ),
      array(
         'name'               => 'Themefyre Portfolio', // The plugin name.
         'slug'               => 'themefyre-portfolio', // The plugin slug (typically the folder name).
         'source'             => get_template_directory().'/plugins/themefyre-portfolio.zip', // The plugin source.
         'required'           => true, // If false, the plugin is only `recommended` instead of required.
         'version'            => '0.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
         'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
         'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      ),
   );

   $config = array(
      'id'           => 'catalyst-tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
      'default_path' => '', // Default absolute path to bundled plugins.
      'menu'         => 'tgmpa-install-plugins', // Menu slug.
      'parent_slug'  => 'themes.php', // Parent menu slug.
      'capability'   => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
      'has_notices'  => true, // Show admin notices or not.
      'dismissable'  => true, // If false, a user cannot dismiss the nag message.
      'dismiss_msg'  => '', // If `dismissable` is false, this message will be output at top of nag.
      'is_automatic' => false, // Automatically activate plugins after installation or not.
      'message'      => '', // Message to output right before the plugins table.
   );

   tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'catalyst_tgmpa_register' );

/**
 * Custom widget to highlight widget content.
 *
 * @since Catalyst 0.0.0
 */
require get_template_directory() . '/includes/featured-widget.php';

/**
 * Custom template tags for this theme.
 *
 * @since Catalyst 0.0.0
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Customizer functionality for this theme.
 *
 * @since Catalyst 0.0.0
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Adds a meta box for customizing the page settings.
 *
 * @since Catalyst 0.0.0
 */
if ( is_admin() ) {
   require get_template_directory() . '/includes/page-settings.php';
}

/**
 * Themefyre Portfolio compatibility, only included when Themefyre Portfolio is active.
 *
 * @since Catalyst 0.0.0
 */
if ( catalyst_is_themefyre_portfolio_active() ) {
   require get_template_directory() . '/includes/themefyre-portfolio.php';
}

/**
 * Themefyre Page Builder compatibility, only included when Themefyre Page Builder is active.
 *
 * @since Catalyst 0.0.0
 */
if ( catalyst_is_themefyre_builder_active() ) {
   require get_template_directory() . '/includes/themefyre-builder.php';
}

/**
 * WooCommerce compatibility, only included when WooCommerce is active.
 *
 * @since Catalyst 0.0.0
 */
if ( catalyst_is_woocommerce_active() ) {
   require get_template_directory() . '/includes/woocommerce.php';
}

/**
 * TGM Plugin Activation
 *
 * @since Catalyst 0.0.0
 */
require get_template_directory() . '/includes/class-tgm-plugin-activation.php';
