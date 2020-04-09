<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */
?>
               </main>
            </div>
            <?php get_sidebar(); ?>
         </div><!-- .site-content-wrap -->
      </div><!-- #content -->
      <footer id="footer" class="site-footer">
         <div class="site-content-wrap">
            <?php get_sidebar('footer'); ?>
            <div id="footer-socket" class="site-socket">
               <p id="footer-copyright">
                  <?php do_action( 'catalyst_footer_copyright' ); ?>
               </p>
               <?php if ( has_nav_menu( 'footer-social' ) ) : ?>
                  <nav id="footer-social" class="social-media-menu">
                     <?php
                        // Social Media Links.
                        wp_nav_menu( array(
                           'menu_class'     => 'nav-menu',
                           'theme_location' => 'footer-social',
                           'container'      => false,
                           'depth'          => 1,
                           'link_before'    => '<span class="screen-reader-text">',
                           'link_after'     => '</span>',
                        ) );
                     ?>
                  </nav>
               <?php endif; ?>
               <?php if ( has_nav_menu( 'footer' ) ) : ?>
                  <nav id="footer-navigation">
                     <?php
                        // Footer navigation menu.
                        wp_nav_menu( array(
                           'menu_class'     => 'nav-menu',
                           'theme_location' => 'footer',
                           'container'      => false,
                           'depth'          => 1,
                        ) );
                     ?>
                  </nav>
               <?php endif; ?>
            </div>
         </div>
      </footer>
   </div><!-- #body -->
</div><!-- #page -->

<!-- Mobile Navigation -->
<?php if ( has_nav_menu( 'mobile' ) || has_nav_menu( 'mobile-social' ) ) : ?>
   <div id="off-canvas-panel">
      <?php if ( has_nav_menu( 'mobile-social' ) ) : ?>
         <nav id="mobile-social" class="social-media-menu">
            <?php
               wp_nav_menu( array(
                  'menu_class'     => 'nav-menu',
                  'theme_location' => 'mobile-social',
                  'container'      => false,
                  'depth'          => 1,
                  'link_before'    => '<span class="screen-reader-text">',
                  'link_after'     => '</span>',
               ) );
            ?>
         </nav>
      <?php endif; ?>
      <?php if ( has_nav_menu( 'mobile' ) ) : ?>
         <nav id="mobile-navigation">
            <?php
               // Mobile navigation menu.
               wp_nav_menu( array(
                  'menu_class'     => 'nav-menu',
                  'theme_location' => 'mobile',
                  'container'      => false,
                  'depth'          => 2,
               ) );
            ?>
         </nav>
      <?php endif; ?>
   </div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>