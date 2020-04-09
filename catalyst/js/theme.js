// Ensure availability of the global themefyreCatalyst object
window.themefyreCatalyst = window.themefyreCatalyst || {};

;(function($, _) {
   "use strict";

   // Wait for the document to load before doing anything
   $(document).ready( function() {

      // Enable the search bar in the header
      if ( document.getElementById('open-search') ) {
         $('#open-search').click( themefyreCatalyst.openHeaderSearch );
         $('#header-search-cancel').click( themefyreCatalyst.closeHeaderSearch );
      }

      // Make sure embedded videos are responsive using FitVids
      $('#page').fitVids();

      // If the footer widget area is enabled and contains more widgets than
      // columns, we need to dynamically build the layout using JavaScript
      //
      // See: http://masonry.desandro.com/
      if ( document.getElementById('footer-widgets') && $('#footer-widgets').attr('data-columns') > 1 && $('#footer-widgets .widget').length > $('#footer-widgets').attr('data-columns') ) {
         $(window).resize( themefyreCatalyst.toggleFooterMasonry );
         themefyreCatalyst.toggleFooterMasonry();
      }

      // When the `sticky` header has been enabled.
      //
      // The header will be collapsed slightly as the page is scrolled down.
      if ( $('body').hasClass('sticky-header') ) {
         $(window).scroll( themefyreCatalyst.updateStickyHeader );
         themefyreCatalyst.updateStickyHeader();
      }

      // Scalable & Parallax Banner Titles
      //
      // On pages which utilize the included banner area we scale
      // the text to fit all screen sizes
      if ( $('body').hasClass('banner-title') ) {

         // Setup the scaling title
         $(window).resize( themefyreCatalyst.scaleBannerTitle );
         themefyreCatalyst.scaleBannerTitle();

         // Setup parallax scrolling
         themefyreCatalyst.addBannerParallax();
         $(window).resize( themefyreCatalyst.addBannerParallax );
         $(window).resize( themefyreCatalyst.scrollBannerParallax );
         $(window).scroll( themefyreCatalyst.scrollBannerParallax );
      }

      // Set up `launch mobile menu` button
      //
      // These buttons begin as the traditional menu or `burger` style button
      // then when clicked they use CSS3 animations to transition to an `X` icon
      if ( document.getElementById('mobile-navigation') ) {

         // Pressing the actual button to open/close the mobile menu
         $('#open-mobile-menu').click( function(event) {
            event.preventDefault();
            if ( ! $('body').hasClass('mobile-menu-active') ) {
               themefyreCatalyst.openMobileMenu();
            }
            else {
               themefyreCatalyst.closeMobileMenu();
            }
         });

         // Once the menu is open, anywhere in the body can be clicked to close the menu again
         $('#page').click( function(event) {
            var $target = $(event.target);
            if ( ! $target.is('#open-mobile-menu') && ! $target.closest('#open-mobile-menu').length && $('body').hasClass('mobile-menu-active') ) {
               themefyreCatalyst.closeMobileMenu();
               event.preventDefault();
               return false;
            }
         });

         // Toggling sub menus within the movile navigation
         $('#mobile-navigation').on({
            opensubmenu: function() {
               var $this = $(this), $subMenu = $('.sub-menu', $this), subMenuHeight = $subMenu.children().length*50;
               $this.addClass('sub-menu-active');
               $subMenu.css({
                  height: subMenuHeight,
                  opacity: 1,
               });
            },
            closesubmenu: function() {
               var $this = $(this), $subMenu = $('.sub-menu', $this);
               $this.removeClass('sub-menu-active');
               $subMenu.removeAttr('style');
            },
         }, 'li.menu-item-has-children');


         $('#mobile-navigation').on('click', '.nav-menu > li.menu-item-has-children > a', function(event) {
            event.preventDefault();
            var $li = $(this).parent();
            if ( $li.hasClass('sub-menu-active') ) {
               $li.trigger('closesubmenu');
            }
            else {
               $li.trigger('opensubmenu');
               $li.siblings('.sub-menu-active').trigger('closesubmenu');
            }
         });
      }

      // Set up sub menus in the main navigation area
      var $parentMenuItems = $('#header .site-navigation > ul > .menu-item-has-children');

      $parentMenuItems.on({
         opensubmenu: function() {
            var $this = $(this).addClass('sub-menu-active');
            setTimeout( function() {
               $this.addClass('sub-menu-open');
            }, 5);
            if ( $this.hasClass('mega-menu') ) {
               var $megaMenu = $this.children('.sub-menu'),
                   megaMenuMarginLeft = parseInt( $megaMenu.css('marginLeft') ),
                   megaMenuOffsetLeft = $megaMenu.offset().left,
                   megaMenuOffsetRight = megaMenuOffsetLeft + $megaMenu.outerWidth(),
                   $header = $('#header .header-mega-menu-container'),
                   headerOffsetLeft = $header.offset().left,
                   headerOffsetRight = headerOffsetLeft + $header.outerWidth(),
                   difference;

               /* Apply correct position */
               if ( megaMenuOffsetRight > headerOffsetRight ) {
                  difference = megaMenuOffsetRight - headerOffsetRight;
                  $megaMenu.css( 'marginLeft', ( megaMenuMarginLeft - difference ) + 'px' );
               }
               else if ( megaMenuOffsetLeft < headerOffsetLeft ) {
                  difference = headerOffsetLeft - megaMenuOffsetLeft;
                  $megaMenu.css( 'marginLeft', ( megaMenuMarginLeft + difference ) + 'px' );
               }
            }
         },
         closesubmenu: function() {
            var $this = $(this).removeClass('sub-menu-open');
            setTimeout( function() {
               $this.removeClass('sub-menu-active');
            }, 200);
         },
      });

      $parentMenuItems.hoverIntent({
         over: function() {
            $(this).trigger('opensubmenu');
         },
         out: function() {
            $(this).trigger('closesubmenu');
         },
      });

      // Setup mega menus when applicable
      $parentMenuItems.each( function() {
         var directChildren = $(this).children('.sub-menu').children('li').length,
             subMenus = $('.sub-menu .sub-menu', $(this) ).length;
         if ( 4 > directChildren && 1 < subMenus && 4 > subMenus ) {
            $(this).addClass('mega-menu mega-menu-columns-'+directChildren);
         }
      });

   });

   // Simple check to determine if we`re in RTL mode
   themefyreCatalyst.isRtl = function() {
      return 'rt' === $('html').attr('dir');
   };

   // Check if we`re on a mobile device
   themefyreCatalyst.isMobile = function() {
      if ( 'undefined' === typeof navigator || 'undefined' === typeof navigator.userAgent ) {
         return false;
      }
      return navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/);
   };

   // Can be used to open the search bar in the header
   themefyreCatalyst.openHeaderSearch = function() {
      var isMobile = 992 > $(window).width(),
          $allItems = isMobile ? $('#branding, #header-tools') : $($.merge( $('#branding, #primary-menu > ul > li, #secondary-menu > ul > li').get(), $('#header-tools > *').get() ).reverse()),
          delay = 0;

      $allItems.each( function() {
         var $this = $(this);
         setTimeout( function() {
            $this.addClass('header-item-hiding');
            setTimeout( function() {
               $this.addClass('header-item-hidden');
            }, 5);
         }, delay);
         if ( ! isMobile ) {
            delay += 25;
         }
      });

      $('#header-search-input').val('');
      setTimeout( function() {
         $('body').addClass('header-search-active');
         $('#header-search-input').focus();
         setTimeout( function() {
            $('body').addClass('header-search-visible');
         }, 5);
      }, delay );
   };

   // Can be used to close the search bar in the header
   themefyreCatalyst.closeHeaderSearch = function() {
         $('body').removeClass('header-search-visible');
         setTimeout( function() {
            $('body').removeClass('header-search-active');
         }, 255);

      var isMobile = 992 > $(window).width(),
          $allItems = isMobile ? $('#branding, #header-tools') : $($.merge( $('#branding, #primary-menu > ul > li, #secondary-menu > ul > li').get(), $('#header-tools > *').get() ).reverse()),
          delay = 0;

      setTimeout( function() {
         $allItems.each( function() {
            var $this = $(this);
            setTimeout( function() {
               $this.removeClass('header-item-hidden');
               setTimeout( function() {
                  $this.removeClass('header-item-hiding');
               }, 500);
            }, delay);
            if ( ! isMobile ) {
               delay += 25;
            }
         });
      }, 50);
   };

   // Can be used to open the mobile menu
   themefyreCatalyst.openMobileMenu = function() {
      if ( $('body').hasClass('mobile-menu-active') ) {
         return;
      }
      var $mobileNavigation = $('#mobile-navigation');
      if ( $mobileNavigation.data('animating') ) {
         return;
      }
      $mobileNavigation.data('animating', true);
      $('body').addClass('mobile-menu-active');
      setTimeout( function() {
         $('body').addClass('mobile-menu-open');
         setTimeout( function() {
            $mobileNavigation.data('animating', false);
         }, 260 );
      }, 10 );
   };

   // Can be used to close the mobile menu
   themefyreCatalyst.closeMobileMenu = function() {
      var $body = $('body');
      if ( ! $body.hasClass('mobile-menu-active') ) {
         return;
      }
      var $mobileNavigation = $('#mobile-navigation');
      if ( $mobileNavigation.data('animating') ) {
         return;
      }
      $mobileNavigation.data('animating', true);
      $body.removeClass('mobile-menu-open');
      setTimeout( function() {
         $mobileNavigation.data('animating', false);
         $body.removeClass('mobile-menu-active');
         $('#mobile-navigation .sub-menu-active').trigger('closesubmenu');
      }, 260 );
   };

   // Uses the current scroll position to toggle the sticky header state
   var stickyHeaderActive = false;
   themefyreCatalyst.updateStickyHeader = function() {
      var offsetPoint = 0;

      // Account for the height of the top bar when applicable
      if ( $('body').hasClass('top-bar') && $('#top-bar').is(':visible') ) {
         offsetPoint += $('#top-bar').outerHeight();
      }

      if ( window.pageYOffset > offsetPoint ) {
         if ( ! stickyHeaderActive ) {
            $('body').addClass('sticky-header-active');
            stickyHeaderActive = true;
         }
      }
      else if ( stickyHeaderActive ) {
         $('body').removeClass('sticky-header-active');
         stickyHeaderActive = false
      }
   };

   // Uses the current scroll position to toggle the sticky header state
   themefyreCatalyst.scaleBannerTitle = function() {
      var $banner = $('#banner'), $bannerTitle = $('#banner-title'), currentWidth = $banner.outerWidth(), maxWidth = 1250;

      // Captions have enough room, we`re good
      if ( currentWidth >= maxWidth ) {
         $bannerTitle.css('transform', 'none');
      }

      else {
         $bannerTitle.css('transform', 'scale('+( currentWidth / maxWidth )+')');
      }

      // Set the banner title opacity to 1
      $bannerTitle.css('opacity', '1');
   };

   // Some variables specific to parallax scrolling that we will use later
   themefyreCatalyst.parallaxBannerConfig = null;
   themefyreCatalyst.lastScrollY = 0;
   themefyreCatalyst.loadingPaintParallaxBanner = false;

   // Resets the config for the parallax banner area
   themefyreCatalyst.addBannerParallax = function() {

      themefyreCatalyst.parallaxBannerConfig = null;

      // Do not continue if we`re on a `mobile` device
      if ( themefyreCatalyst.isMobile() ) {
         return;
      }

      var $banner = $('#banner');

      themefyreCatalyst.parallaxBannerConfig = {
         $element: $('#banner-parallax'),
         height: $banner.outerHeight(),
         offsetTop: $banner.offset().top,
         offsetBottom: $banner.outerHeight() + $banner.offset().top,
      };
   }

   // Indexes each element that has parallax scrolling enabled
   themefyreCatalyst.scrollBannerParallax = function() {
      if ( themefyreCatalyst.parallaxBannerConfig && ! themefyreCatalyst.loadingPaintParallaxBanner ) {
         requestAnimationFrame( themefyreCatalyst.paintBannerParallax );
         themefyreCatalyst.lastScrollY = window.pageYOffset;
         themefyreCatalyst.loadingPaintParallaxBanner = true;
      }
   };

   // Updates the parallax banner area as the page is scrolled
   themefyreCatalyst.paintBannerParallax = function() {
      if ( themefyreCatalyst.lastScrollY > themefyreCatalyst.parallaxBannerConfig.offsetTop && themefyreCatalyst.lastScrollY < themefyreCatalyst.parallaxBannerConfig.offsetBottom ) {
         themefyreCatalyst.parallaxBannerConfig.$element.css({
            // transform: 'translateY('+(themefyreCatalyst.lastScrollY-themefyreCatalyst.parallaxBannerConfig.offsetTop)/6+'px)' + 'scale('+(1-(((themefyreCatalyst.lastScrollY-themefyreCatalyst.parallaxBannerConfig.offsetTop)/themefyreCatalyst.parallaxBannerConfig.height)/12))+')',
            opacity: (1-(((themefyreCatalyst.lastScrollY-themefyreCatalyst.parallaxBannerConfig.offsetTop)/themefyreCatalyst.parallaxBannerConfig.height)*2.5)),
         });
      }
      else {
         themefyreCatalyst.parallaxBannerConfig.$element.css({
            // transform: 'none',
            opacity: 1,
         });
      }
      themefyreCatalyst.loadingPaintParallaxBanner = false;
   };

   // Determines if the masonry script should be applied to the footer widgets
   themefyreCatalyst.toggleFooterMasonry = function() {
      if ( 768 < $(window).width() ) {
         themefyreCatalyst.enableFooterMasonry();
      }
      else {
         themefyreCatalyst.disableFooterMasonry();
      }
   };

   // Enables the masonry script for the footer widgets
   themefyreCatalyst.enableFooterMasonry = function() {
      if ( themefyreCatalyst.footerWidgetsMasonryEnabled ) {
         return;
      }
      themefyreCatalyst.footerWidgetsMasonryEnabled = true;
      var container = document.getElementById('footer-widgets');
      imagesLoaded( container, function() {
         themefyreCatalyst.footerWidgetsMasonry = new Masonry( container, {
            isOriginLeft: ! themefyreCatalyst.isRtl(),
            transitionDuration: 0,
         });
      });
   };

   // Disables the masonry script for the footer widgets
   themefyreCatalyst.disableFooterMasonry = function() {
      if ( ! themefyreCatalyst.footerWidgetsMasonryEnabled ) {
         return;
      }
      themefyreCatalyst.footerWidgetsMasonry.destroy();
      themefyreCatalyst.footerWidgetsMasonryEnabled = false;
   };

}(jQuery, _));

// ======================================================
//
// requestAnimationFrame polyfill
//
// ======================================================

// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
//
// requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel
//
// MIT license
;(function() {
   var lastTime = 0;
   var vendors = ['ms', 'moz', 'webkit', 'o'];
   for ( var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x ) {
      window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
      window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
   }
   if ( ! window.requestAnimationFrame ) {
      window.requestAnimationFrame = function(callback, element) {
         var currTime = new Date().getTime();
         var timeToCall = Math.max( 0, 16 - (currTime - lastTime) );
         var id = window.setTimeout( function() { callback(currTime + timeToCall ); }, timeToCall);
         lastTime = currTime + timeToCall;
         return id;
      };
   }
   if ( ! window.cancelAnimationFrame ) {
      window.cancelAnimationFrame = function( id ) {
         clearTimeout( id );
      };
   }
}());

// ======================================================
//
// HoverIntent Plugin
//
// ======================================================

/*!
 * hoverIntent v1.8.0 // 2014.06.29 // jQuery v1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2014 Brian Cherne
 */
(function($){$.fn.hoverIntent=function(handlerIn,handlerOut,selector){var cfg={interval:100,sensitivity:6,timeout:0};if(typeof handlerIn==="object"){cfg=$.extend(cfg,handlerIn)}else{if($.isFunction(handlerOut)){cfg=$.extend(cfg,{over:handlerIn,out:handlerOut,selector:selector})}else{cfg=$.extend(cfg,{over:handlerIn,out:handlerIn,selector:handlerOut})}}var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if(Math.sqrt((pX-cX)*(pX-cX)+(pY-cY)*(pY-cY))<cfg.sensitivity){$(ob).off("mousemove.hoverIntent",track);ob.hoverIntent_s=true;return cfg.over.apply(ob,[ev])}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=false;return cfg.out.apply(ob,[ev])};var handleHover=function(e){var ev=$.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t)}if(e.type==="mouseenter"){pX=ev.pageX;pY=ev.pageY;$(ob).on("mousemove.hoverIntent",track);if(!ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}}else{$(ob).off("mousemove.hoverIntent",track);if(ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob)},cfg.timeout)}}};return this.on({"mouseenter.hoverIntent":handleHover,"mouseleave.hoverIntent":handleHover},cfg.selector)}})(jQuery);

// ======================================================
//
// FitVids Plugin
//
// ======================================================

/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

;(function( $ ){
  'use strict';

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        'iframe[src*="player.vimeo.com"]',
        'iframe[src*="youtube.com"]',
        'iframe[src*="youtube-nocookie.com"]',
        'iframe[src*="kickstarter.com"][src*="video.html"]',
        'object',
        'embed'
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(count){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + count;
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );