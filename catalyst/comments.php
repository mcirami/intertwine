<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
   return;
} ?>

<div id="comments" class="comments-area">

   <?php if ( have_comments() ) : ?>
      <h2 class="comments-title">
         <?php printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'catalyst' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?>
      </h2>
      <?php catalyst_comment_nav('comment-navigation-top'); ?>
      <ol class="comment-list">
         <?php
            wp_list_comments( array(
               'style'       => 'ol',
               'short_ping'  => true,
               'avatar_size' => 60,
            ) );
         ?>
      </ol>
      <?php catalyst_comment_nav('comment-navigation-bottom'); ?>
   <?php endif; ?>

   <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
      <p class="no-comments">
         <?php esc_html_e( 'Comments are closed.', 'catalyst' ); ?>
      </p>
   <?php endif; ?>

   <?php comment_form(); ?>

</div>