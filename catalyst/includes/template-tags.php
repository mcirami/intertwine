<?php
/**
 * Custom template tags for Catalyst
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

if ( ! function_exists( 'catalyst_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $extra_class Additional class to be added
 */
function catalyst_comment_nav( $extra_class = '' ) {
   if ( ! get_comment_pages_count() > 1 || ! get_option( 'page_comments' ) ) {
      return;
   }
   ?>
      <nav class="navigation comment-navigation <?php echo esc_attr( $extra_class ); ?>">
         <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'catalyst' ); ?></h2>
         <div class="nav-links">
            <?php
            echo get_previous_comments_link( esc_html__( 'Older Comments', 'catalyst' ) );
            if ( get_previous_comments_link( esc_html__( 'Older Comments', 'catalyst' ) ) && get_next_comments_link( esc_html__( 'Newer Comments', 'catalyst' ) ) ) {
               echo '<span class="nav-links-spacer"></span>';
            }
            echo get_next_comments_link( esc_html__( 'Newer Comments', 'catalyst' ) );
            ?>
         </div>
      </nav>
   <?php
}
endif;

if ( ! function_exists( 'catalyst_get_link_format_url' ) ) :
/**
 * Return the post URL.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Catalyst 0.0.0
 *
 * @see get_url_in_content()
 *
 * @return string
 */
function catalyst_get_link_format_url() {
   $has_url = get_url_in_content( get_the_content() );
   return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

if ( ! function_exists( 'catalyst_post_preview' ) ) :
/**
 * Display a post preview, must be used within the loop.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_post_preview() {
   $bg_style = '';
   if ( has_post_thumbnail() && $img_info = wp_get_attachment_image_src( get_post_thumbnail_id(), 'catalyst-post-preview' ) ) {
      $bg_style = ' style="background-image:url('.$img_info[0].');"';
   }
   ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('post-preview'); ?>>
         <a href="<?php the_permalink(); ?>" rel="bookmark">
            <div class="post-breview-thumbnail"<?php echo apply_filters( 'catalyst_post_preview_css', $bg_style ); ?>></div>
            <div class="post-preview-caption">
               <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
            </div>
         </a>
      </article>
   <?php
}
endif;

if ( ! function_exists( 'catalyst_pagination' ) ) :
/**
 * Prints pagination links, must be used within the loop.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_pagination() {
   $args = array(
      'prev_text'          => '<span class="screen-reader-text">'.esc_html__( 'Previous Page', 'catalyst' ).' </span><span class="genericon genericon-collapse"></span>',
      'next_text'          => '<span class="screen-reader-text">'.esc_html__( 'Next Page', 'catalyst' ).' </span><span class="genericon genericon-collapse"></span>',
      'before_page_number' => '<span class="meta-nav screen-reader-text">'.esc_html__( 'Page', 'catalyst' ).' </span>',
   );

   the_posts_pagination( $args );
}
endif;

if ( ! function_exists( 'catalyst_link_pages' ) ) :
/**
 * Prints page links, must be used within the loop.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_link_pages() {
   $args = array(
      'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'catalyst' ) . '</span>',
      'after'       => '</div>',
      'link_before' => '<span>',
      'link_after'  => '</span>',
      'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'catalyst' ) . ' </span>%',
      'separator'   => '<span class="screen-reader-text">, </span>',
   );
   wp_link_pages( $args );
}
endif;

/**
 * Returns an array of possible page layouts.
 *
 * @since Catalyst 0.0.0
 *
 * @return array
 */
function catalyst_get_page_layout_options() {
   return array(
      'sidebar-left'  => esc_html__( 'Left sidebar', 'catalyst' ),
      'sidebar-right' => esc_html__( 'Right sidebar', 'catalyst' ),
      'centered'      => esc_html__( 'Centered (no sidebar)', 'catalyst' ),
      'full-width'    => esc_html__( 'Full width (no sidebar)', 'catalyst' ),
   );
}

/**
 * Gets the layout for the current page.
 *
 * @since Catalyst 0.0.0
 *
 * @return string Name of layout being used
 */
function catalyst_get_layout() {
   $layout = apply_filters( 'catalyst_page_layout', get_theme_mod( 'page_layout', 'sidebar-right' ) );

   // Certain post types can override the default layout using page templates
   $page_settings = catalyst_get_page_settings();
   if ( $page_settings['layout'] ) {
      $layout = $page_settings['layout'];
   }

   return $layout;
}

if ( ! function_exists( 'catalyst_get_result_count' ) ) :
/**
 * Prints a short description about the number of posts being displayed.
 *
 * Must be used within the loop.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_get_result_count() {
   global $wp_query;

   $paged    = max( 1, $wp_query->get( 'paged' ) );
   $per_page = $wp_query->get( 'posts_per_page' );
   $total    = $wp_query->found_posts;
   $first    = ( $per_page * $paged ) - $per_page + 1;
   $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );

   if ( 1 == $total ) {
      return esc_html__( 'Showing the single result', 'catalyst' );
   }
   else if ( $total <= $per_page || -1 == $per_page ) {
      return sprintf( esc_html__( 'Showing all %d results', 'catalyst' ), $total );
   }
   else {
      return sprintf( esc_html__( 'Showing %1$d&ndash;%2$d of %3$d results', 'catalyst' ), $first, $last, $total );
   }
}
endif;

if ( ! function_exists( 'catalyst_get_widget_count' ) ) :
/**
 * Gets the number of active widgets in a widget area.
 *
 * @since Catalyst 0.0.0
 *
 * @param string $widget_area Id of widget area
 * @return int Number of active widgets
 */
function catalyst_get_widget_count( $widget_area ) {

   // If the widget area is not active, it does not have any widgets
   if ( ! is_active_sidebar( $widget_area ) ) {
      return 0;
   }

   // If loading from front page, consult $_wp_sidebars_widgets rather than options
   // to see if wp_convert_widget_settings() has made manipulations in memory.
   global $_wp_sidebars_widgets;
   if ( empty( $_wp_sidebars_widgets ) ) {
      $_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
   }

   // Return the number of active widgets if the widget area can be found
   return isset( $_wp_sidebars_widgets[$widget_area] ) ? count( $_wp_sidebars_widgets[$widget_area] ) : 0;
}
endif;

if ( ! function_exists( 'catalyst_the_post_thumbnail' ) ) :
/**
 * Prints the featured image for an entry, if one is present.
 *
 * Must be used within the loop.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_the_post_thumbnail() {
   if ( ! has_post_thumbnail() ) {
      return;
   }

   $size = 'full-width' === catalyst_get_layout() ? 'full' : 'post-thumbnail';

   if ( is_single() ) {
      ?>
         <div class="entry-featured-image">
            <?php the_post_thumbnail( $size ); ?>
         </div>
      <?php
   }
   else {
      $size = 'full-width' === catalyst_get_layout() ? 'full' : 'post-thumbnail';
      $img = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
      echo '<a class="entry-featured-image" href="'.get_permalink().'" style="background-image:url('.$img[0].');"></a>';
   }
}
endif;

/**
 * Determine whether blog/site has more than one category.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function catalyst_categorized_blog() {
   if ( false === ( $all_categories = get_transient( 'catalyst_categories' ) ) ) {

      // Create an array of all the categories that are attached to posts.
      $all_categories = get_categories( array(
         'fields'     => 'ids',
         'hide_empty' => 1,
         'number'     => 2, // We only need to know if there is more than one category.
      ) );

      // Count the number of categories that are attached to the posts.
      set_transient( 'catalyst_categories', count( $all_categories ) );
   }

   return $all_categories > 1;
}

if ( ! function_exists( 'catalyst_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_entry_meta() {
   echo '<ul class="entry-meta">';

   if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
      $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

      if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
         $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
      }

      $time_string = sprintf( $time_string,
         esc_attr( get_the_date( 'c' ) ),
         get_the_date(),
         esc_attr( get_the_modified_date( 'c' ) ),
         get_the_modified_date()
      );

      printf( '<li class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></li>',
         esc_url( get_permalink() ),
         $time_string
      );
   }

   if ( 'post' == get_post_type() ) {
      if ( is_multi_author() || is_single() ) {
         printf( '<li class="byline"><span class="author vcard"><a href="%1$s">%2$s</a></span></li>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            get_the_author()
         );
      }

      $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'catalyst' ) );
      if ( $categories_list && catalyst_categorized_blog() ) {
         printf( '<li class="cat-links">%1$s</li>',
            $categories_list
         );
      }
   }

   if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
      echo '<li class="comments-link">';
      comments_popup_link( esc_html__( 'Leave a comment', 'catalyst' ), esc_html__( '1 Comment', 'catalyst' ), esc_html__( '% Comments', 'catalyst' ) );
      echo '</li>';
   }

   echo '</ul>';
}
endif;

/**
 * Determines if the top bar is active.
 *
 * @since Catalyst 0.0.0
 *
 * @return bool
 */
function catalyst_is_top_bar_active() {
   return has_nav_menu( 'top-bar-social' ) || has_nav_menu( 'top-bar-menu' ) || get_theme_mod('top_bar_text');
}

/**
 * Determines if the Themefyre Page Builder plugin is active.
 *
 * @since Catalyst 0.0.0
 *
 * @return bool
 */
function catalyst_is_themefyre_builder_active() {
   return class_exists( 'Themefyre_Builder' );
}

/**
 * Determines if the Themefyre Portfolio plugin is active.
 *
 * @since Catalyst 0.0.0
 *
 * @return bool
 */
function catalyst_is_themefyre_portfolio_active() {
   return class_exists( 'Themefyre_Portfolio' );
}

/**
 * Determines if the WooCommerce plugin is active.
 *
 * @since Catalyst 0.0.0
 *
 * @return bool
 */
function catalyst_is_woocommerce_active() {
   return class_exists( 'woocommerce' );
}

/**
 * Determines if the floating header is currently enabled.
 *
 * @since Catalyst 0.0.0
 *
 * @return bool
 */
function catalyst_is_header_floating() {
   $page_settings = catalyst_get_page_settings();
   return apply_filters( 'catalyst_is_header_floating', in_array( $page_settings['floating_header'], array('enabled', 'enabled-shadow', 'enabled-glassy', 'enabled-border') ) );
}

/**
 * Determines if the banner area is active for the current page/post.
 *
 * @since Catalyst 0.0.0
 *
 * @return bool
 */
function catalyst_is_banner_active() {
   $page_settings = catalyst_get_page_settings();
   return ! $page_settings['hide_banner'] && ( ! empty( $page_settings['banner_title'] ) || ! empty( $page_settings['banner_tagline'] ) || ! empty( $page_settings['banner_menu'] ) || ! empty( $page_settings['banner_image'] ) );
}

/**
 * Returns an array of arguments for the page settings
 *
 * Using the `catalyst_page_settings_post_id` filter you can easily pull
 * the settings from a specific page.
 *
 * @since Catalyst 0.0.0
 *
 * @return bool
 */
function catalyst_get_page_settings() {
   $post_id = apply_filters( 'catalyst_page_settings_post_id', is_singular() ? get_the_ID() : '' );
   $settings = array(
      'layout'          => get_post_meta( $post_id, '_catalyst_layout', true ),
      'floating_header' => get_post_meta( $post_id, '_catalyst_floating_header', true ),
      'hide_banner'     => get_post_meta( $post_id, '_catalyst_hide_banner', true ),
      'banner_title'    => get_post_meta( $post_id, '_catalyst_banner_title', true ),
      'banner_tagline'  => get_post_meta( $post_id, '_catalyst_banner_tagline', true ),
      'banner_menu'     => get_post_meta( $post_id, '_catalyst_banner_menu', true ),
      'banner_image'    => get_post_meta( $post_id, '_catalyst_banner_image', true ),
   );
   return apply_filters( 'catalyst_page_settings', $settings );
}