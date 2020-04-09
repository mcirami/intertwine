<?php
/**
 * Template Name: Grid - Display direct descendants as grid
 *
 * The template for displaying grid pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

global $post;

get_header();

// Check for posts
if ( have_posts() ) :

   // Start the loop.
   while ( have_posts() ) : the_post();

      // Include the page content template.
      // Only if there is content to show
      if ( trim( get_the_content() ) ) {
         get_template_part( 'content', 'page' );
      }

      // Get all descedant pages
      $posts = get_pages( array(
         'hierarchical' => false,
         'parent' => get_the_ID(),
      ) );
      if ( $posts && ! is_wp_error( $posts ) ) {
         ?>
            <div class="template-grid-descendants">
            <ul>
         <?php
         foreach ( $posts as $post ) {
            setup_postdata( $post );
            ?>
               <li>
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
               </li>
            <?php
         }
         wp_reset_postdata();
         ?>
            </ul>
            </div>
         <?php
      }

      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) {
         comments_template();
      }

   // End the loop.
   endwhile;

// If no content, include the "No posts found" template.
else :
   get_template_part( 'content', 'none' );
endif;

get_footer();