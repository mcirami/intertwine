<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

   <header class="entry-header">
      <a href="<?php the_permalink(); ?>" rel="bookmark">
         <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
         <p class="entry-permalink"><?php the_permalink(); ?></p>
      </a>
   </header>

   <?php if ( has_excerpt() ) : ?>
      <div class="entry-summary">
         <?php the_excerpt(); ?>
      </div>
   <?php endif; ?>

</article>