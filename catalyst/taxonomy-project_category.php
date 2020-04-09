<?php
/**
 * The template for displaying project archive pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

get_header();

catalyst_portfolio_filters();

if ( isset( $wp_query->queried_object->name ) && ! ( catalyst_is_themefyre_portfolio_active() && get_theme_mod( 'portfolio_filters' ) ) ) : ?>
   <header class="page-header portfolio-header">
      <?php the_archive_title( '<h1 class="page-title archive-title">', '</h1>' ); ?>
      <?php the_archive_description( '<div class="page-description">', '</div>' ); ?>
      <?php if ( $result_count = catalyst_get_result_count() ) : ?>
         <p class="page-tagline"><?php echo esc_html( $result_count ); ?></p>
      <?php endif; ?>
   </header>
<?php endif;

// Check for posts
if ( have_posts() ) :

   echo '<div class="post-preview-group">';

   // Start the loop.
   while ( have_posts() ) : the_post();

      // Include the page content template.
      get_template_part( 'content', 'project' );

   // End the loop.
   endwhile;

   echo '</div>';

   catalyst_pagination();

// If no content, include the "No posts found" template.
else :
   get_template_part( 'content', 'none' );
endif;

get_footer();