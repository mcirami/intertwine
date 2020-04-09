<?php
/**
 * Themefyre Portfolio compatibility, only included when Themefyre Portfolio is active.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */


/**
 * Displays the filters for the portfolio when they are enabled.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_portfolio_filters() {
   global $wp_query;
   if ( catalyst_is_themefyre_portfolio_active() && get_theme_mod( 'portfolio_filters' ) && ! is_project() && is_portfolio() ) {
      $terms = get_terms( 'project_category' );
      if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
         ?>
            <div class="portfolio-filters">
               <ul>
                  <li<?php echo ! is_project_category() ? ' class="is-active"' : ''; ?>><a href="<?php portfolio_page_permalink(); ?>"><?php esc_html_e( 'All', 'catalyst' ); ?></a></li>
                  <?php foreach ( $terms as $term ) {

                     // The $term is an object, so we don't need to specify the $taxonomy.
                     $term_link = get_term_link( $term );

                     // If there was an error, continue to the next term.
                     if ( is_wp_error( $term_link ) ) {
                        continue;
                     }

                     // Check if we are currently viewing this taxonomy
                     $is_active_class = isset( $wp_query->queried_object->term_id ) && $wp_query->queried_object->term_id == $term->term_id ? ' class="is-active"' : '';

                     // We successfully got a link. Print it out.
                     echo '<li'.$is_active_class.'><a href="'.esc_url($term_link).'">'.esc_html($term->name).'</a></li>';
                  } ?>
               </ul>
            </div>
         <?php
      }
   }
}

/**
 * Prevents the theme from automatically applying custom settings to the banner area
 * for Portfolio archive pages
 *
 * @since Catalyst 0.0.0
 *
 * @param array $settings The current page settings being used
 * @return bool
 */
function catalyst_portfolio_maybe_remove_archive_filter( $settings ) {
   if ( is_portfolio() && ! is_project_search() && ! ( is_project_category() && ! get_theme_mod( 'portfolio_filters' ) ) ) {
      remove_filter( 'catalyst_page_settings', 'catalyst_archive_page_settings', 10 );
   }
   return $settings;
}
add_filter( 'catalyst_page_settings', 'catalyst_portfolio_maybe_remove_archive_filter', 5 );

/**
 * Modify the page settings for archive pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $settings The current page settings
 * @return array
 */
function catalyst_portfolio_search_page_settings( $settings ) {
   if ( is_project_search() ) {

      // Grab the title
      $settings['banner_title'] = sprintf( esc_html__( 'Search Results for: %s', 'catalyst' ), get_search_query() );

      // Grab the result count
      $settings['banner_tagline'] = catalyst_get_result_count();
   }
   return $settings;
}
add_filter( 'catalyst_page_settings', 'catalyst_portfolio_search_page_settings', 10 );

/**
 * Adds a sidebar specific to Themefyre Portfolio related pages.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_portfolio_sidebar() {
   register_sidebar( array(
      'name'          => esc_html__( 'Portfolio Sidebar', 'catalyst' ),
      'id'            => 'catalyst-portfolio-sidebar',
      'description'   => esc_html__( 'Add widgets here to appear in the sidebar of pages relating to your portfolio, including single project pages. If this widget area is left empty then the default sidebar will be used instead.', 'catalyst' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
   ) );
}
add_action( 'widgets_init', 'catalyst_portfolio_sidebar' );

/**
 * Makes sure the Themefyre Portfolio specific sidebar is used on Themefyre Portfolio related pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $widget_area The current widget area to use for the sidebar
 * @return string
 */
function catalyst_portfolio_sidebar_widget_area( $widget_area ) {
   if ( is_portfolio() && is_active_sidebar('catalyst-portfolio-sidebar') ) {
      return 'catalyst-portfolio-sidebar';
   }
   return $widget_area;
}
add_filter( 'catalyst_sidebar_widget_area', 'catalyst_portfolio_sidebar_widget_area' );

/**
 * Ensure that on project archive pages the appropriate post ID is being used
 * to set up the page settings.
 *
 * @since Catalyst 0.0.0
 *
 * @param array $post_id The current post ID being used
 * @return int
 */
function catalyst_portfolio_page_settings_post_id( $post_id ) {
   if ( is_portfolio() && ! is_project() && ( $portfolio_id = get_portfolio_page_id() ) && get_page( $portfolio_id ) ) {
      $post_id = $portfolio_id;
   }
   return $post_id;
}
add_filter( 'catalyst_page_settings_post_id', 'catalyst_portfolio_page_settings_post_id', 10 );

/**
 * Modify the ouput of the layout class of Themefyre Portfolio related pages.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $location The current widget area to use for the sidebar
 * @return string
 */
function catalyst_portfolio_page_layout( $layout ) {
   if ( is_project() ) {
      $layout = get_theme_mod( 'portfolio_project_layout', get_theme_mod( 'page_layout', 'sidebar-right' ) );
   }
   else if ( is_portfolio() ) {
      $layout = get_theme_mod( 'portfolio_layout', get_theme_mod( 'page_layout', 'sidebar-right' ) );
   }
   return $layout;
}
add_filter( 'catalyst_page_layout', 'catalyst_portfolio_page_layout', 10 );

/**
 * Register Theme Customizer functionality specific to Themefyre Portfolio.
 *
 * @since Catalyst 0.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function catalyst_portfolio_customize_register( $wp_customize ) {
   $wp_customize->add_section( 'catalyst_portfolio', array(
      'title'    => 'Themefyre Portfolio',
      'priority' => 39,
   ) );

   $wp_customize->add_setting( 'portfolio_layout', array(
      'default'           => get_theme_mod( 'page_layout', 'sidebar-right' ),
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_layout'
   ) );

   $wp_customize->add_setting( 'portfolio_project_layout', array(
      'default'           => get_theme_mod( 'page_layout', 'sidebar-right' ),
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_layout'
   ) );

   $wp_customize->add_setting( 'portfolio_filters', array(
      'transport'         => 'refresh',
      'sanitize_callback' => 'catalyst_sanitize_bool'
   ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_layout', array(
      'label'       => esc_html__( 'Portfolio Layout', 'catalyst' ),
      'description' => esc_html__( 'The page layout for Portfolio archive pages.', 'catalyst' ),
      'section'     => 'catalyst_portfolio',
      'settings'    => 'portfolio_layout',
      'type'        => 'select',
      'choices'     => catalyst_get_page_layout_options(),
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_project_layout', array(
      'label'       => esc_html__( 'Project Layout', 'catalyst' ),
      'description' => esc_html__( 'The page layout for single project pages. This can be overriden on a per project basis using the Catalyst Page Settings meta box.', 'catalyst' ),
      'section'     => 'catalyst_portfolio',
      'settings'    => 'portfolio_project_layout',
      'type'        => 'select',
      'choices'     => catalyst_get_page_layout_options(),
   ) ) );

   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_filters', array(
      'label'       => esc_html__( 'Portfolio Filters', 'catalyst' ),
      'description' => esc_html__( 'Check this box to display a list of filters for your portfolio based on your project categories.', 'catalyst' ),
      'section'     => 'catalyst_portfolio',
      'settings'    => 'portfolio_filters',
      'type'        => 'checkbox',
   ) ) );
}
add_action( 'customize_register', 'catalyst_portfolio_customize_register' );