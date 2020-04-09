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


      if (get_post_type() == 'models' && current_user_can( 'manage_options' )) {

          echo '<div class="below-post">';
          echo '<span class="results_back"><a id="results_back" href="">Back To Results</a></span>';
          // Tag list, when applicable
          $tags_list = get_the_tag_list('', _x(', ', 'Used between list items, there is a space after the comma.', 'catalyst'));
          if ($tags_list) {
              printf('<div class="tags-links"><span class="tags-links-title">%1$s </span>%2$s</div>',
                  _x('Post Tags', 'Used before tag names.', 'catalyst'),
                  $tags_list
              );
          }

          // Previous/next post navigation.
          the_post_navigation(array(
              'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__('Next Post', 'catalyst') . '</span> ' .
                  '<span class="screen-reader-text">' . esc_html__('Next post:', 'catalyst') . '</span> ' .
                  '<span class="post-title">%title</span>',

              'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__('Previous Post', 'catalyst') . '</span> ' .
                  '<span class="screen-reader-text">' . esc_html__('Previous post:', 'catalyst') . '</span> ' .
                  '<span class="post-title">%title</span>',
          ));

          // If comments are open or we have at least one comment, load up the comment template.
          if (comments_open() || get_comments_number()) {
              comments_template();
          }

          echo '</div>';
      } elseif (get_post_type() == 'models' && !current_user_can( 'manage_options' ) ) {
          echo '';
      } else {
          echo '<div class="below-post">';

          // Tag list, when applicable
          $tags_list = get_the_tag_list('', _x(', ', 'Used between list items, there is a space after the comma.', 'catalyst'));
          if ($tags_list) {
              printf('<div class="tags-links"><span class="tags-links-title">%1$s </span>%2$s</div>',
                  _x('Post Tags', 'Used before tag names.', 'catalyst'),
                  $tags_list
              );
          }

          // Previous/next post navigation.
          the_post_navigation(array(
              'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__('Next Post', 'catalyst') . '</span> ' .
                  '<span class="screen-reader-text">' . esc_html__('Next post:', 'catalyst') . '</span> ' .
                  '<span class="post-title">%title</span>',
                    '<span><a href="">Back To Results</a></span>',
              'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__('Previous Post', 'catalyst') . '</span> ' .
                  '<span class="screen-reader-text">' . esc_html__('Previous post:', 'catalyst') . '</span> ' .
                  '<span class="post-title">%title</span>',
          ));

          // If comments are open or we have at least one comment, load up the comment template.
          if (comments_open() || get_comments_number()) {
              comments_template();
          }

          echo '</div>';
      }

       // Include the page content template.
       get_template_part( 'content', get_post_format() );

   // End the loop.
   endwhile;

// If no content, include the "No posts found" template.
else :
   get_template_part( 'content', 'none' );
endif;
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        var results = getCookie("results");
        var pathname = window.location.href;

        pathname = pathname.split('/');

        $('#results_back').attr('href', pathname[0] + '//' + pathname[2] + '/' + pathname[3] + '/' + results);

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length,c.length);
                }
            }
            return "";
        }

    });
</script>


<?php get_footer(); ?>