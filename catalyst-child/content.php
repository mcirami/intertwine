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

    <?php if ( is_single() && get_post_type() == 'models' && current_user_can( 'manage_options' ) ) : ?>
        <div class="single_model_wrap">
            <?php $headShot = get_field('head_shot');
                    $bodyShot = get_field('body_shot'); ?>

            <div class="model_wrap">
                <div class="title">
                    <?php the_title( '<h3>', '</h3>' ); ?>
                </div>

                <?php if ($headShot || $bodyShot) : ?>
                    <div class="images">
                        <div class="column">
                            <img src="<?php echo $headShot['url'] ?>" alt="">
                        </div>
                        <div class="column">
                            <img src="<?php echo $bodyShot['url'] ?>" alt="">
                        </div>
                    </div><!-- images -->
                <?php endif; ?>

                <div class="model_info">
                    <ul>
                        <li>
                            <label>Email:</label>
                            <p><a href="mailto:<?php echo the_field('email'); ?>"><?php echo the_field('email'); ?></a></p>
                        </li>
                        <li>
                            <label>Phone:</label>
                            <p><?php echo the_field('phone'); ?></p>
                        </li>
                        <li>
                            <label>Gender:</label>
                            <p><?php echo the_field('gender'); ?></p>
                        </li>
                        <li>
                            <label>Ethnicity:</label>
                            <p><?php echo the_field('ethnicity'); ?></p>
                        </li>
                        <li>
                            <label>Birthday:</label>
                            <p><?php echo the_field('birthday'); ?></p>
                        </li>
                        <li>
                            <label>Height:</label>
                            <p><?php echo the_field('height'); ?></p>
                        </li>
                        <li>
                            <label>Body Type:</label>
                            <p><?php echo the_field('body_type'); ?></p>
                        </li>
                        <li>
                            <label>Shoe Size:</label>
                            <p><?php echo the_field('shoe_size'); ?></p>
                        </li>
                        <li>
                            <label>Residence:</label>
                            <p><?php echo the_field('residence'); ?></p>
                        </li>
                    </ul>
                </div><!-- model_info -->
                <div class="desc">
                    <div class="full_width">
                        <label>About:</label>
                        <p><?php echo the_field('description'); ?></p>
                    </div>
                    <div class="full_width">
                        <label>Independent or represented by a non-exclusive modeling/talent agent:</label>
                        <?php $status = get_field('status_check'); ?>
                        <p><?php if ($status) : ?>
                                Yes
                            <?php else : ?>
                                No
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="full_width">
                        <label>Member of SAG, AFTRA or other actors' unions:</label>
                        <?php $member = get_field('member_check'); ?>
                        <p><?php if ($member) : ?>
                                No
                            <?php else : ?>
                                Yes
                            <?php endif;?>
                        </p>
                    </div>
                </div><!-- desc -->
            </div><!-- model_warp -->
            <?php /*if (current_user_can( 'manage_options' )) { */?><!--
                <p><a onclick="return confirm('Are you SURE you want to delete this post?')" href="<?php /*echo get_delete_post_link( $post->ID ) */?>">Delete Model</a></p>
            --><?php /*} */

                echo delete_post();
            ?>

        </div><!-- single_Model_wrap -->
    <?php elseif (get_post_type() == 'models') : ?>

        <div class="no_perm">
            <h3> You Don't have access to view this page. </h3>
        </div>
    <?php else : ?>

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

    <?php endif; ?>

</article>

