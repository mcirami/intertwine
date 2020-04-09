<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */
?>

<section class="no-results not-found">
   <?php if ( is_search() ) : ?>
      <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'catalyst' ); ?></p>
      <?php get_search_form(); ?>
   <?php else : ?>
      <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'catalyst' ); ?></p>
      <?php get_search_form(); ?>
   <?php endif; ?>
</section>