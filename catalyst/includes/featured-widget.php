<?php

/**
 * Register `Catalyst_Featured_Text_Widget` widget
 *
 * This widget is based entirely on the default text widget, however
 * it is presented on the front end very differently.
 *
 * @since Catalyst 0.0.0
 */
function register_catalyst_featured_text_widget() {
   register_widget('Catalyst_Featured_Text_Widget');
}
add_action( 'widgets_init', 'register_catalyst_featured_text_widget' );

/**
 * Catalyst Featured Text Widget Class
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */
class Catalyst_Featured_Text_Widget extends WP_Widget {

   /**
    * Catalyst_Featured_Text_Widget Constructor.
    *
    * @since Catalyst 0.0.0
    * @access public
    */
   public function __construct() {
      $widget_ops = array(
         'classname' => 'widget_catalyst_featured_text',
         'description' => esc_html__( 'Highlight the text using the theme accent colors.', 'catalyst' ),
      );
      $control_ops = array(
         'width' => 400,
         'height' => 350,
      );
      parent::__construct(
         'catalyst_featured_text', // Widget ID
         esc_html__( 'Catalyst Featured Text', 'catalyst' ), // Widget Name
         $widget_ops, $control_ops
      );
   }

   /**
    * Front-end display of widget.
    *
    * @since Catalyst 0.0.0
    * @access public
    *
    * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget
    * @param array $instance The settings for the particular instance of the widget
    */
   public function widget( $args, $instance ) {

      // This filter is documented in wp-includes/default-widgets.php]
      $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

      // Filter the content of the Text widget.
      $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

      echo apply_filters( 'catalyst_before_widget', $args['before_widget'] );

      if ( ! empty( $title ) ) {
         echo apply_filters( 'catalyst_widget_title', $args['before_title'] . esc_html( $title ) . $args['after_title'] );
      }

      ?>
         <div class="textwidget">
            <?php echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
         </div>
      <?php

      echo apply_filters( 'catalyst_after_widget', $args['after_widget'] );
   }

   /**
    * Back-end widget form.
    *
    * @since Catalyst 0.0.0
    * @access public
    *
    * @see WP_Widget::form()
    *
    * @param array $instance Previously saved values from database.
    */
   public function form( $instance ) {
      $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
      $title = strip_tags( $instance['title'] );
      $text = esc_textarea( $instance['text'] );
      ?>
         <p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'catalyst'); ?></label>
         <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
         <textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>"><?php echo esc_html( $text ); ?></textarea>
         <p><input id="<?php echo esc_attr( $this->get_field_id('filter') ); ?>" name="<?php echo esc_attr( $this->get_field_name('filter') ); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id('filter') ); ?>"><?php esc_html_e('Automatically add paragraphs', 'catalyst'); ?></label></p>
      <?php
   }

   /**
    * Sanitize widget form values as they are saved.
    *
    * @since Catalyst 0.0.0
    * @access public
    *
    * @see WP_Widget::update()
    *
    * @param array $new_instance Values just sent to be saved.
    * @param array $old_instance Previously saved values from database.
    * @return array Updated safe values to be saved.
    */
   public function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance['title'] = strip_tags( $new_instance['title'] );
      if ( current_user_can('unfiltered_html') ) {
         $instance['text'] =  $new_instance['text'];
      }
      else {
         $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
      }
      $instance['filter'] = ! empty( $new_instance['filter'] );
      return $instance;
   }

}