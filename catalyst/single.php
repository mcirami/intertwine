<?php
/**
 * The template for displaying all single posts and attachments
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

      echo '<div class="below-post">';

      // Tag list, when applicable
      $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'catalyst' ) );
      if ( $tags_list ) {
         printf( '<div class="tags-links"><span class="tags-links-title">%1$s </span>%2$s</div>',
            _x( 'Post Tags', 'Used before tag names.', 'catalyst' ),
            $tags_list
         );
      }

      // Previous/next post navigation.
      the_post_navigation( array(
         'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next Post', 'catalyst' ) . '</span> ' .
            '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'catalyst' ) . '</span> ' .
            '<span class="post-title">%title</span>',
         'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous Post', 'catalyst' ) . '</span> ' .
            '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'catalyst' ) . '</span> ' .
            '<span class="post-title">%title</span>',
      ) );

      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) {
         comments_template();
      }

      echo '</div>';

   // End the loop.
   endwhile;

// If no content, include the "No posts found" template.
else :
   get_template_part( 'content', 'none' );
endif;

get_footer();