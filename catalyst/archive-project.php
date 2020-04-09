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

if ( catalyst_is_themefyre_portfolio_active() && ( $id = get_portfolio_page_id() ) && get_page( $id ) && $content = get_post_field( 'post_content', $id ) ) : ?>
   <section class="portfolio-page-content">
      <?php echo apply_filters( 'the_content', $content ); ?>
   </section>
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