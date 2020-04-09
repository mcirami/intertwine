<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

// Make sure there is a sidebar
if ( in_array( catalyst_get_layout(), array('sidebar-left', 'sidebar-right') ) ) : ?>
   <div id="sidebar" class="site-sidebar sidebar-widget-area widget-area">
      <?php dynamic_sidebar( apply_filters( 'catalyst_sidebar_widget_area', 'catalyst-sidebar' ) ); ?>
   </div>
<?php endif;