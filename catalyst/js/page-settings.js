;(function($, _) {
   "use strict";

   $(document).ready( function() {

      // Hande the `Remove background image` functionality
      $('#catalyst-remove-banner-image').click( function(event) {
         event.preventDefault();
         $('#catalyst-banner-image-control').addClass('no-image');
         $('#catalyst-banner-image').val('');
         $('#catalyst-set-banner-image').html('');
      });

      // Hande the `Select background image` functionality
      var selectImageFrame;
      $('#catalyst-set-banner-image').click( function(event) {
         event.preventDefault();

         // Check if the frame has already been created
         //
         // If it has, simply reopen it and return. THis way the frame HTML can be reused.
         if ( selectImageFrame ) {
            selectImageFrame.open();
            return;
         }

         // Create the media frame initially.
         selectImageFrame = wp.media({
            title: catalystPageSettingsLocalize.set_banner_image,
            button: { text: catalystPageSettingsLocalize.set_banner_image, },
            library: { type: 'image' },
            multiple: false,
            className: 'media-frame catalyst-image-select-frame',
         });

         // When an image is selected, run a callback.
         selectImageFrame.on( 'select', function() {

            // Grab the selected attachment object from the frome and convert it to JSON
            var attachment = selectImageFrame.state().get('selection').first().toJSON();

            var imgId = typeof attachment.id !== 'undefined' ? attachment.id : null, imgSrc = '';
            if ( imgId ) {
               if ( typeof attachment.sizes !== 'undefined' && typeof typeof attachment.sizes.medium !== 'undefined' && typeof typeof attachment.sizes.medium.url !== 'undefined' ) {
                  imgSrc = attachment.sizes.medium.url;
               }
               else if ( typeof attachment.url !== 'undefined' ) {
                  imgSrc = attachment.url;
               }
            }
            if ( imgSrc ) {
               $('#catalyst-banner-image-control').removeClass('no-image');
               $('#catalyst-banner-image').val(imgId);
               $('#catalyst-set-banner-image').html('<img src="'+imgSrc+'" />');
            }
            else {
               alert( catalystPageSettingsLocalize.get_image_error );
            }
         });

         // Finally, open the modal.
         selectImageFrame.open();
      });

   });
}(jQuery, _));