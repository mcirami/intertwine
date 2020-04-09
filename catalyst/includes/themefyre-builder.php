<?php
/**
 * Themefyre Page Builder compatibility, only included when Themefyre Page Builder is active.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */

/**
 * Registers the included templates with the page builder.
 *
 * @since Catalyst 0.0.0
 *
 * @return array
 */
function catalyst_add_builder_templates() {
   builder_add_template( 'catalyst_home_1', array(
      'name'   => esc_html__( 'Home Version 1', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/home-version-1.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_home_2', array(
      'name'   => esc_html__( 'Home Version 2', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/home-version-2.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_home_3', array(
      'name'   => esc_html__( 'Home Version 3', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/home-version-3.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_home_4', array(
      'name'   => esc_html__( 'Home Version 4', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/home-version-4.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_about', array(
      'name'   => esc_html__( 'About', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/about.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_contact', array(
      'name'   => esc_html__( 'Contact', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/contact.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_faq', array(
      'name'   => esc_html__( 'F.A.Q', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/faq.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_pricing', array(
      'name'   => esc_html__( 'Pricing', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/pricing.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_services', array(
      'name'   => esc_html__( 'Services', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/services.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_testimonials', array(
      'name'   => esc_html__( 'Testimonials', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/testimonials.txt',
      'source' => 'Catalyst',
   ) );

   builder_add_template( 'catalyst_shop_landing', array(
      'name'   => esc_html__( 'Shop Landing Page', 'catalyst' ),
      'desc'   => esc_html__( 'As seen in the Catalyst theme demo', 'catalyst' ),
      'path'   => get_template_directory().'/includes/builder-templates/shop-landing.txt',
      'source' => 'Catalyst',
   ) );
}
add_action( 'init', 'catalyst_add_builder_templates' );

/**
 * Adds the inline styles for the accent colors specific to the Themefyre Page Builder.
 *
 * @since Catalyst 0.0.0
 */
function catalyst_builder_dynamic_styles() {
   $accent_one = get_theme_mod('accent_one', '#FF2A68' );
   $accent_two = get_theme_mod('accent_two', '#FF5E3A' );
   ob_start(); ?>

      /* Icon Boxes */
      .builder-icon-box.icon-location-above:not(.icon-custom-color) .builder-icon-box-icon {
         color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      .builder-icon-box.icon-location-adjacent:not(.icon-custom-color) .builder-icon-box-icon-container {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      /* Ordered Instructions */
      .builder-instructions .builder-instructions-step:not(:last-child):before {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }
      .builder-instructions .builder-instructions-step .builder-step-symbol {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      /* Progress Bars */
      .builder-statistics .builder-statistics-item-bar-value {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(left,<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(left,<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      /* Price Tables */
      .builder-price-table.featured .builder-price-table-footer {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
         background: -webkit-linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
         background: linear-gradient(<?php echo catalyst_esc_css( $accent_one ); ?>, <?php echo catalyst_esc_css( $accent_two ); ?>);
      }

      /* Tab Group */
      @media all and (min-width: 992px) {
         body.js .builder-tab-group .builder-tab-group-tabs li.is-active > a {
            color: <?php echo catalyst_esc_css( $accent_one ); ?>;
         }
      }

      /* Toggle Group */
      .builder-toggle-group .builder-toggle .builder-toggle-title:hover,
      .builder-toggle-group .builder-toggle.is-open .builder-toggle-title {
         border-bottom: 1px solid <?php echo catalyst_esc_css( $accent_one ); ?>;
      }

      /* Timelines */
      .builder-timeline:after {
         background: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      .builder-timeline.alignment-left .builder-timeline-event .builder-timeline-event-meta:after,
      .builder-timeline.alignment-alternate .builder-timeline-event:nth-child(odd) .builder-timeline-event-meta:after {
         border-right-color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }
      .builder-timeline.alignment-right .builder-timeline-event .builder-timeline-event-meta:after,
      .builder-timeline.alignment-alternate .builder-timeline-event:nth-child(even) .builder-timeline-event-meta:after {
         border-left-color: <?php echo catalyst_esc_css( $accent_one ); ?>;
      }

   <?php $inline_css = ob_get_clean();

   // Add the inline stylesheet
   wp_add_inline_style( 'catalyst-style', $inline_css );
}
add_action( 'wp_enqueue_scripts', 'catalyst_builder_dynamic_styles', 20 );