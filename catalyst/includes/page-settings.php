<?php
/**
 * Adds a meta box for customizing the page settings.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

/**
 * List of post types the page settings meta box has been applied to.
 *
 * @since Catalyst 0.0.0
 *
 * @return array
 */
function catalyst_page_settings_screens() {
   return apply_filters('catalyst_page_settings_screens', array('page', 'post', 'project') );
}

/**
 * Adds the page settings meta box
 *
 * @since Catalyst 0.0.0
 *
 * @param string $post_type The post type of the post being edited.
 */
function catalyst_add_page_settings_meta_box( $post_type ) {
   if ( ! in_array($post_type, catalyst_page_settings_screens() ) ) {
      return;
   }

   add_meta_box(
      'catalyst_page_settings',
      sprintf( esc_html__('%s Page Settings', 'catalyst'), 'Catalyst' ),
      'catalyst_page_settings_meta_box_callback',
      $post_type,
      'side'
   );
}
add_action( 'add_meta_boxes', 'catalyst_add_page_settings_meta_box' );

/**
 * Called upon page load for edit post screens
 *
 * @since Catalyst 0.0.0
 */
function catalyst_page_settings_load_post() {
   $screen = get_current_screen();
   if ( in_array( $screen->id, catalyst_page_settings_screens() ) ) {
      add_action('admin_enqueue_scripts', 'catalyst_page_settings_assets', 10 );
   }
}
add_action( 'load-post.php',     'catalyst_page_settings_load_post' );
add_action( 'load-post-new.php', 'catalyst_page_settings_load_post' );

/**
 * Load requred assets for the page settings meta box
 *
 * @since Catalyst 0.0.0
 */
function catalyst_page_settings_assets() {
   wp_enqueue_style( 'catalyst-page-settings', get_template_directory_uri() . '/css/page-settings.css', false, catalyst_get_version() );
   wp_enqueue_script( 'catalyst-page-settings', get_template_directory_uri() . '/js/page-settings.js', array( 'jquery', 'underscore' ), catalyst_get_version() );

   // Localize general admin media script
   wp_localize_script( 'catalyst-page-settings', 'catalystPageSettingsLocalize', array(
      'set_banner_image' => esc_html__( 'Set Banner Background Image', 'catalyst' ),
      'get_image_error' => esc_html__( 'There was an error retrieving the selected image, please try again later.', 'catalyst' ),
   ) );
}

/**
 * Prints the page settings meta box content
 *
 * @since Catalyst 0.0.0
 *
 * @param WP_Post $post The object for the current post/page.
 */
function catalyst_page_settings_meta_box_callback( $post ) {

   // Add a nonce field so we can check for it later.
   wp_nonce_field( 'catalyst_page_settings', 'catalyst_page_settings_nonce' );

   $floating_header_options = array(
      'enabled'        => esc_html__( 'Enabled', 'catalyst' ),
      'enabled-shadow' => esc_html__( 'Enabled with shadow background', 'catalyst' ),
      'enabled-glassy' => esc_html__( 'Enabled with glassy background', 'catalyst' ),
      'enabled-border' => esc_html__( 'Enabled with bottom border', 'catalyst' ),
   );

   // Grab the saved values, if there are any
   $layout          = get_post_meta( $post->ID, '_catalyst_layout', true );
   $floating_header = get_post_meta( $post->ID, '_catalyst_floating_header', true );
   $hide_banner     = get_post_meta( $post->ID, '_catalyst_hide_banner', true );
   $banner_title    = get_post_meta( $post->ID, '_catalyst_banner_title', true );
   $banner_tagline  = get_post_meta( $post->ID, '_catalyst_banner_tagline', true );
   $banner_image    = get_post_meta( $post->ID, '_catalyst_banner_image', true );
   $banner_menu     = get_post_meta( $post->ID, '_catalyst_banner_menu', true );

   // Will contain the file name of the banner image in use
   $banner_image_info = wp_get_attachment_image_src( $banner_image, 'medium' );
   $banner_image_src  = isset( $banner_image_info[0] ) ? $banner_image_info[0] : '';

   // If no image was found, reset the image ID value
   if ( ! $banner_image_src ) {
      $banner_image = '';
   }

   ?>
      <!-- Page Layout Setting -->
      <p><strong><?php esc_html_e('Page Layout', 'catalyst'); ?></strong></p>
      <label for="catalyst-layout" class="screen-reader-text"><?php esc_html_e('Page Layout', 'catalyst'); ?></label>
      <select id="catalyst-layout" name="_catalyst_layout">
         <option><?php esc_html_e('(default layout)', 'catalyst'); ?></option>
         <?php foreach ( catalyst_get_page_layout_options() as $option => $name ) : ?>
            <option value="<?php echo esc_attr( $option ); ?>" <?php selected($option,$layout); ?>><?php echo esc_html( $name ); ?></option>
         <?php endforeach; ?>
      </select>

      <!-- Floating Header Setting -->
      <p><strong><?php esc_html_e('Floating Header', 'catalyst'); ?></strong></p>
      <label for="catalyst-floating-header" class="screen-reader-text"><?php esc_html_e('Floating Header', 'catalyst'); ?></label>
      <select id="catalyst-floating-header" name="_catalyst_floating_header">
         <option><?php esc_html_e('(disabled)', 'catalyst'); ?></option>
         <?php foreach ( $floating_header_options as $option => $name ) : ?>
            <option value="<?php echo esc_attr( $option ); ?>" <?php selected($option,$floating_header); ?>><?php echo esc_html( $name ); ?></option>
         <?php endforeach; ?>
      </select>

      <!-- Hide Banner Setting -->
      <p><strong><?php esc_html_e('Hide Banner', 'catalyst'); ?></strong></p>
      <label for="catalyst-hide-banner">
         <input type="checkbox" class="widefat" id="catalyst-hide-banner" name="_catalyst_hide_banner" value="hide" <?php checked( $hide_banner ); ?> />
         <?php esc_html_e('Hide the banner for this page.', 'catalyst'); ?>
      </label>

      <!-- Banner Title Setting -->
      <p><strong><?php esc_html_e('Banner Title', 'catalyst'); ?></strong></p>
      <label for="catalyst-banner-title" class="screen-reader-text"><?php esc_html_e('Banner Title', 'catalyst'); ?></label>
      <input type="text" class="widefat" id="catalyst-banner-title" name="_catalyst_banner_title" value="<?php echo esc_attr( $banner_title ); ?>" />

      <!-- Banner Tagline Setting -->
      <p><strong><?php esc_html_e('Banner Tagline', 'catalyst'); ?></strong></p>
      <label for="catalyst-banner-tagline" class="screen-reader-text"><?php esc_html_e('Banner Tagline', 'catalyst'); ?></label>
      <textarea class="widefat" id="catalyst-banner-tagline" name="_catalyst_banner_tagline"><?php echo esc_html( $banner_tagline ); ?></textarea>

      <!-- Banner Menu Setting -->
      <p><strong><?php esc_html_e('Banner Menu', 'catalyst'); ?></strong></p>
      <label for="catalyst-banner-menu" class="screen-reader-text"><?php esc_html_e('Banner Menu', 'catalyst'); ?></label>
      <p><?php esc_html_e('Custom menu to be displayed within the banner area.', 'catalyst'); ?></p>
      <select id="catalyst-banner-menu" name="_catalyst_banner_menu">
         <option><?php esc_html_e('(no menu)', 'catalyst'); ?></option>
         <?php foreach ( get_terms('nav_menu') as $menu ) : ?>
            <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected($menu->term_id,$banner_menu); ?>><?php echo esc_html( $menu->name ); ?></option>
         <?php endforeach; ?>
      </select>

      <!-- Banner Background Image Setting -->
      <div id="catalyst-banner-image-control" class="hide-if-no-js <?php echo ! $banner_image ? ' no-image' : ''; ?>">
         <p><strong><?php esc_html_e('Banner Background Image', 'catalyst'); ?></strong></p>
         <input type="hidden" value="<?php echo esc_attr( $banner_image ); ?>" id="catalyst-banner-image" name="_catalyst_banner_image" />
         <p>
            <a href="#" id="catalyst-set-banner-image" title="<?php esc_attr_e('Set background image', 'catalyst'); ?>">
               <?php if ( $banner_image ) : ?>
                  <img src="<?php echo esc_url( $banner_image_src ); ?>" />
               <?php endif; ?>
            </a>
         </p>
         <p>
            <a href="#" id="catalyst-remove-banner-image"><?php esc_html_e('Remove background image', 'catalyst'); ?></a>
         </p>
      </div>
   <?php
}

/**
 * Updates the page settings meta box upon save
 *
 * @since Catalyst 0.0.0
 *
 * @param int $post_id The ID of the post being saved.
 */
function catalyst_update_page_settings_meta_box( $post_id ) {

   // Check if our nonce is set.
   if ( ! isset( $_POST['catalyst_page_settings_nonce'] ) ) {
      return;
   }

   // Verify that the nonce is valid.
   if ( ! wp_verify_nonce( $_POST['catalyst_page_settings_nonce'], 'catalyst_page_settings' ) ) {
      return;
   }

   // If this is an autosave, our form has not been submitted, so we don't want to do anything.
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
   }

   // Check the user's permissions.
   if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) ) {
         return;
      }
   }
   else if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
   }

   // We made it here, which means it`s safe to update the values
   if ( isset( $_POST['_catalyst_layout'] ) ) {
      $allowed = array( 'sidebar-left', 'sidebar-right', 'centered', 'full-width' );
      $layout = in_array( $_POST['_catalyst_layout'], $allowed ) ? $_POST['_catalyst_layout'] : '';
      update_post_meta( $post_id, '_catalyst_layout', $layout );
   }
   if ( isset( $_POST['_catalyst_floating_header'] ) ) {
      $allowed = array( 'enabled', 'enabled-shadow', 'enabled-glassy', 'enabled-border' );
      $floating_header = in_array( $_POST['_catalyst_floating_header'], $allowed ) ? $_POST['_catalyst_floating_header'] : '';
      update_post_meta( $post_id, '_catalyst_floating_header', $floating_header );
   }

   update_post_meta( $post_id, '_catalyst_hide_banner', isset( $_POST['_catalyst_hide_banner'] ) && 'hide' === $_POST['_catalyst_hide_banner'] );

   if ( isset( $_POST['_catalyst_banner_title'] ) ) {
      $banner_title = sanitize_text_field( $_POST['_catalyst_banner_title'] );
      update_post_meta( $post_id, '_catalyst_banner_title', $banner_title );
   }
   if ( isset( $_POST['_catalyst_banner_tagline'] ) ) {
      $banner_tagline = sanitize_text_field( $_POST['_catalyst_banner_tagline'] );
      update_post_meta( $post_id, '_catalyst_banner_tagline', $banner_tagline );
   }
   if ( isset( $_POST['_catalyst_banner_menu'] ) ) {
      $banner_menu = $_POST['_catalyst_banner_menu'] ? intval( $_POST['_catalyst_banner_menu'] ) : '';
      update_post_meta( $post_id, '_catalyst_banner_menu', $banner_menu );
   }
   if ( isset( $_POST['_catalyst_banner_image'] ) ) {
      $banner_image = $_POST['_catalyst_banner_image'] ? intval( $_POST['_catalyst_banner_image'] ) : '';
      update_post_meta( $post_id, '_catalyst_banner_image', $banner_image );
   }
}
add_action( 'save_post', 'catalyst_update_page_settings_meta_box' );