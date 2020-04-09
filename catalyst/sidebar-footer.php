<?php
/**
 * The footer sidebar containing the footer widget areas
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

// Calculate the number of columns to display (up to 5)
if ( $num_widgets = catalyst_get_widget_count( 'catalyst-footer' ) ) {
   $columns = intval( get_theme_mod( 'footer_max_columns', '3' ) );
   $num_columns = $columns > $num_widgets ? $num_widgets : $columns;
}

// If there is at least one active widget, display the footer sidebar
if ( ! empty( $num_columns ) && $num_columns ) : ?>
   <div id="footer-widgets" class="footer-widget-area widget-area<?php if ( 1 < $num_columns ) echo ' footer-columns-'.$num_columns; ?>" data-columns="<?php echo esc_attr( $num_columns ); ?>">
      <?php dynamic_sidebar( 'catalyst-footer' ); ?>
   </div>
<?php endif;