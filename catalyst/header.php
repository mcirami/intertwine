<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Catalyst
 * @since Catalyst 0.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width">
   <link rel="profile" href="http://gmpg.org/xfn/11">
   <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
   <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<script>document.body.className=document.body.className.replace('no-js','js');</script>

<div id="page" class="hfeed site">
   <?php if ( catalyst_is_top_bar_active() ) : ?>
      <div id="top-bar">
         <div class="site-content-wrap">
            <?php if ( get_theme_mod('top_bar_text') ) : ?>
               <p id="top-bar-text"><?php echo get_theme_mod('top_bar_text'); ?></p>
            <?php endif; ?>
            <?php if ( has_nav_menu( 'top-bar-social' ) ) : ?>
               <nav id="top-bar-social" class="social-media-menu">
                  <?php
                     wp_nav_menu( array(
                        'menu_class'     => 'nav-menu',
                        'theme_location' => 'top-bar-social',
                        'container'      => false,
                        'depth'          => 1,
                        'link_before'    => '<span class="screen-reader-text">',
                        'link_after'     => '</span>',
                     ) );
                  ?>
               </nav>
            <?php endif; ?>
            <?php if ( has_nav_menu( 'top-bar-menu' ) ) : ?>
               <nav id="top-bar-navigation">
                  <?php
                     wp_nav_menu( array(
                        'menu_class'     => 'nav-menu',
                        'theme_location' => 'top-bar-menu',
                        'container'      => false,
                        'depth'          => 1,
                     ) );
                  ?>
               </nav>
            <?php endif; ?>
         </div>
      </div>
   <?php endif; ?>
   <header id="header" class="site-header">
      <div class="header-content">
         <div class="site-content-wrap">
            <div class="header-mega-menu-container">

               <div id="branding" class="site-branding">
                  <?php if ( $logo = get_theme_mod( 'logo' ) ) : ?>
                     <a class="site-logo-container" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img height="50" class="site-logo site-default-logo" src="<?php echo esc_attr( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
                        <?php if ( $floating_logo = get_theme_mod( 'floating_logo' ) ) : ?>
                           <img height="50" class="site-logo site-floating-logo" src="<?php echo esc_attr( $floating_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
                        <?php endif; ?>
                        <span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
                     </a>
                  <?php else: ?>
                     <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                  <?php endif; ?>
               </div>

               <?php if ( has_nav_menu( 'primary' ) ) : ?>
                  <nav id="primary-menu" class="site-navigation">
                     <?php
                        // Primary navigation menu.
                        wp_nav_menu( array(
                           'menu_class'     => 'nav-menu',
                           'theme_location' => 'primary',
                           'container'      => false,
                           'depth'          => 3,
                        ) );
                     ?>
                  </nav>
               <?php endif; ?>

               <div id="header-tools">
                  <?php if ( get_theme_mod('header_search', true) ) : ?>
                     <nav id="search-menu" class="hide-if-no-js">
                        <span id="open-search" class="genericon genericon-search"><span class="screen-reader-text"><?php esc_html_e( 'Toggle Search Bar', 'catalyst' ); ?></span></span>
                     </nav>
                  <?php endif; ?>

                  <?php if ( has_nav_menu( 'mobile' ) || has_nav_menu( 'mobile-social' ) ) : ?>
                     <nav id="mobile-menu">
                        <a href="#mobile-navigation" aria-label="<?php esc_attr_e( 'Toggle Navigation', 'catalyst' ); ?>" class="launch-menu-button" id="open-mobile-menu">
                           <span class="lines"></span>
                        </a>
                     </nav>
                  <?php endif; ?>

                  <?php if ( catalyst_is_woocommerce_active() && get_theme_mod('woocommerce_cart_menu', true) && ! is_cart() && WC()->cart->cart_contents_count ) : ?>
                     <div id="cart-menu">
                        <a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'View Cart', 'catalyst' ); ?>">
                           <span class="genericon genericon-cart"></span>
                           <span class="cart-item-count"><?php echo WC()->cart->cart_contents_count; ?></span>
                        </a>
                     </div>
                  <?php endif; ?>
               </div>

               <?php if ( has_nav_menu( 'secondary' ) ) : ?>
                  <nav id="secondary-menu" class="site-navigation">
                     <?php
                        // Primary navigation menu.
                        wp_nav_menu( array(
                           'menu_class'     => 'nav-menu',
                           'theme_location' => 'secondary',
                           'container'      => false,
                           'depth'          => 3,
                        ) );
                     ?>
                  </nav>
               <?php endif; ?>

               <?php if ( get_theme_mod('header_search', true) ) : ?>
                  <form id="header-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                     <label class="screen-reader-text" for="header-search-input"><?php esc_html_e( 'Search for:', 'catalyst' ); ?></label>
                     <input type="text" name="s" id="header-search-input" placeholder="<?php esc_attr_e( 'Search...', 'catalyst' ); ?>" />
                     <button type="button" id="header-search-cancel"><span class="genericon genericon-close-alt"><span class="screen-reader-text"><?php esc_html_e('Cancel search', 'catalyst'); ?></span></span></button>
                     <button type="submit" id="header-search-submit"><span class="genericon genericon-search"><span class="screen-reader-text"><?php esc_html_e('Search', 'catalyst'); ?></span></span></button>
                  </form>
               <?php endif; ?>

            </div>
         </div>
      </div>
   </header>
   <div id="body" class="site-body">
      <?php if ( catalyst_is_banner_active() ) : ?>
         <?php $page_settings = catalyst_get_page_settings(); ?>
         <div id="banner">
            <?php if ( $page_settings['banner_title'] || $page_settings['banner_tagline'] ) : ?>
               <div id="banner-parallax">
                  <div id="banner-title">
                     <?php if ( $page_settings['banner_title'] ) : ?>
                        <h1><?php echo esc_html( $page_settings['banner_title'] ); ?></h1>
                     <?php endif; ?>
                     <?php if ( $page_settings['banner_tagline'] ) : ?>
                        <h2><?php echo esc_html( $page_settings['banner_tagline'] ); ?></h2>
                     <?php endif; ?>
                  </div>
               </div>
            <?php endif; ?>
            <?php if ( $page_settings['banner_menu'] && wp_get_nav_menu_items( $page_settings['banner_menu'] ) ) : ?>
               <div id="banner-menu">
                  <nav class="site-content-wrap">
                     <?php
                        // banner navigation menu.
                        wp_nav_menu( array(
                           'menu'       => $page_settings['banner_menu'],
                           'menu_class' => 'nav-menu',
                           'container'  => false,
                           'depth'      => 1,
                        ) );
                     ?>
                  </nav>
               </div>
            <?php endif; ?>
         </div>
      <?php endif; ?>
      <div id="content" class="site-content">
         <div class="site-content-wrap">
            <div id="primary" class="content-area">
               <main id="main" class="site-main">