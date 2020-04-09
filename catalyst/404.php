<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

get_header(); ?>
   <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'catalyst' ); ?></p>
   <?php get_search_form(); ?>
<?php get_footer();