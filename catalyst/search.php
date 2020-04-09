<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

get_header();

?>
   <header class="page-header search-header with-divider">
      <?php if ( trim( get_search_query() ) ) : ?>
         <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'catalyst' ), get_search_query() ); ?></h1>
         <?php if ( $result_count = catalyst_get_result_count() ) : ?>
            <p class="page-tagline"><?php echo esc_html( $result_count ); ?></p>
         <?php endif; ?>
      <?php else: ?>
         <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'catalyst' ); ?></h1>
      <?php endif; ?>
   </header>
<?php

// Check for posts
if ( have_posts() && trim( get_search_query() ) ) :

   echo '<div class="search-results">';

   // Start the loop.
   while ( have_posts() ) : the_post();

      // Include the page content template.
      get_template_part( 'content', 'search' );

   // End the loop.
   endwhile;

   echo '</div>';

   catalyst_pagination();

// If no content, include the "No posts found" template.
else :
   get_template_part( 'content', 'none' );
endif;

get_footer();