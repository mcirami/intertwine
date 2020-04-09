<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
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
      get_template_part( 'content', get_post_format() );

   // End the loop.
   endwhile;

   catalyst_pagination();

// If no content, include the "No posts found" template.
else :
   get_template_part( 'content', 'none' );
endif;

get_footer();