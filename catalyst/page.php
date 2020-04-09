<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

get_header();

// Check for posts
if ( have_posts() ) :

   // Start the loop.
   while ( have_posts() ) : the_post();

      // Include the page content template.
      get_template_part( 'content', 'page' );

      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) {
         echo '<div class="below-post">';
         comments_template();
         echo '</div>';
      }

   // End the loop.
   endwhile;

// If no content, include the "No posts found" template.
else :
   get_template_part( 'content', 'none' );
endif;

get_footer();