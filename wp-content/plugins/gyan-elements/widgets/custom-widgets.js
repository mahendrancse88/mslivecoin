(function ($) {	$(document).ready(function(){

	 "use strict";

    $(document).on("click", ".image-upload-button-remove", function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.siblings('.image-upload-value').val('');
        $this.siblings('.image-preview').html('');
     });

    $(document).on("click", ".image-upload-button", function (e) {
       e.preventDefault();
       var $this = $(this);


       // Create the media frame.
       var file_frame = wp.media.frames.file_frame = wp.media({
          title: 'Select or upload image',
          library: {        // remove these to show all
             type: 'image'  // specific mime
          },
          button: {
             text: 'Select'
          },
          multiple: false   // Set to true to allow multiple files to be selected
       });

       // When an image is selected, run a callback.
       file_frame.on('select', function () {
          // We set multiple to false so only get one image from the uploader

          var attachment = file_frame.state().get('selection').first().toJSON();
          $this.siblings('input[type="hidden"]').val(attachment.url);
          let img = '<img src="'+attachment.url+'" style="max-width:100px;height:auto;margin:20px 0;">';
          $this.siblings('.image-preview').html(img);
       });

       // Finally, open the modal
       file_frame.open();
    });

}); })(jQuery);