<?php
/**
 * Template Name: Model Signup
 *
 * The template for displaying Model Form page.
 *
 *
 * @package boiler
 */

acf_form_head();

get_header();

?>

<div class="signup_wrap">
    <div class="info_column">
        <div class="row add">
            <div class="icon_wrap">
                <img src="<?php echo bloginfo('template_url'); ?>-child/images/icon-add.png" />
            </div>
            <div class="text_wrap">
                <h3>Sign Up</h3>
                <p>Fill out our form to be considered for future shoots. We need all types of people so don’t be shy!</p>
            </div>
        </div>
        <div class="row booked">
            <div class="icon_wrap">
                <img src="<?php echo bloginfo('template_url'); ?>-child/images/icon-checkmark.png" />
            </div>
            <div class="text_wrap">
                <h3>Get Booked</h3>
                <p>When a shoot is planned we’ll contact you with details. If our role calls for your look then consider yourself booked.</p>
            </div>
        </div>
        <div class="row shoot">
            <div class="icon_wrap">
                <img src="<?php echo bloginfo('template_url'); ?>-child/images/icon-camera.png" />
            </div>
            <div class="text_wrap">
                <h3>Shoot</h3>
                <p>Show up. Shoot. Have fun. Get paid. We thought you’d like the sound of that.</p>
            </div>
        </div>
        <!--<div class="row">
            <div class="icon_wrap">
                <img src="<?php /*echo bloginfo('template_url'); */?>-child/images/icon-picture.png" />
            </div>
            <div class="text_wrap">
                <h3>Receive Your Photos</h3>
                <p>After the shoot we’ll send you the photos for your portfolio or personal use. Free of charge, of course.</p>
            </div>
        </div>-->
    </div>
    <?php

    acf_form(array(
        'post_id'		=> 'new_post',
        'post_title'	=> true,
        'post_content'	=> false,
        'new_post'		=> array(
            'post_type'		=> 'models',
            'post_status'	=> 'publish'
        ),
        'return'		=> home_url('/thank-you/'),
        'submit_value'	=> 'Submit'
    ));

    ?>
</div><!-- signup_wrap -->

<script>
    jQuery(document).ready(function($) {
        if ($('.acf-field--post-title')) {

            $('.acf-field--post-title .acf-label label').replaceWith("<label for=\"acf-_post_title\">Name <span class=\"acf-required\">*</span></label>");
        }
    });
</script>

<?php get_footer(); ?>
