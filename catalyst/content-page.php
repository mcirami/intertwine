<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <?php the_content(); ?>
   <?php catalyst_link_pages(); ?>
</article>