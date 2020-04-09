<?php
/**
 * The default template for displaying content
 *
 * Used for index/archive.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <div class="entry-body">
      <?php catalyst_the_post_thumbnail(); ?>
      <header class="entry-header">
         <?php
            if ( is_single() ) :
               the_title( '<h1 class="entry-title">', '</h1>' );
            else :
               the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            endif;
         ?>
      </header>
      <footer class="entry-footer">
         <?php catalyst_entry_meta(); ?>
      </footer>
      <div class="entry-content">
         <?php
            if ( ! is_single() && has_excerpt() ) {
               the_excerpt();
            }
            else {
               the_content( sprintf( esc_html__( 'Continue reading %s', 'catalyst' ), get_the_title() ) );
            }
            if ( is_single() ) {
               catalyst_link_pages();
            }
         ?>
      </div>
   </div>
</article>