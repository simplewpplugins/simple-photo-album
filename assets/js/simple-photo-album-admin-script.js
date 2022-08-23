jQuery(function($) {

    var file_frame;

    $(document).on('click','#simpa-album-cover-trigger',function( e ){
        e.preventDefault();
        if (file_frame) file_frame.close();
        file_frame = wp.media.frames.file_frame = wp.media({
            title: $(this).data('uploader-title'),
            button: {
              text: $(this).data('uploader-button-text'),
            },
            multiple: false
          });
          file_frame.on('select', function() {

            var container = $('#simpa-album-cover-metabox-container');
            var img_preview = container.find('.image-preview');
            var input = container.find('#_album_cover' );
            var selection = file_frame.state().get('selection');
        
            selection.map(function(attachment, i) {
              attachment = attachment.toJSON();
              input.val( attachment.id );
              img_preview.html('<img src="'+ attachment.sizes.medium.url +'" width="100%"/>');
            });
          });

          file_frame.open();
    });
    
    $(document).on('click', 'a.photo-add', function(e) {
    
      e.preventDefault();
    
      if (file_frame) file_frame.close();
    
      file_frame = wp.media.frames.file_frame = wp.media({
        title: $(this).data('uploader-title'),
        button: {
          text: $(this).data('uploader-button-text'),
        },
        multiple: true
      });
    
      file_frame.on('select', function() {
        var listIndex = $('#gallery-metabox-list li').index($('#gallery-metabox-list li:last')),
            selection = file_frame.state().get('selection');
    
        selection.map(function(attachment, i) {
          attachment = attachment.toJSON(),
          index      = listIndex + (i + 1);
    
    
    
          $('#gallery-metabox-list').append('<li><input type="hidden" name="_simpa_photos[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.thumbnail.url + '"><span class="controls"><a class="remove-image" href="#">&times;</a></span></li>');
    
        });
      });
    
      makeSortable();
    
      file_frame.open();
    
    });
    
    function resetIndex() {
      $('#gallery-metabox-list li').each(function(i) {
        $(this).find('input:hidden').attr('name', '_simpa_photos['+i+']');
      });
    }
    
    function makeSortable() {
      $('#gallery-metabox-list').sortable({
        opacity: 0.6,
        stop: function() {
          resetIndex();
        }
      });
    }
    
    $(document).on('click', 'a.remove-image', function(e) {
      e.preventDefault();
    
      $(this).parents('li').animate({ opacity: 0 }, 200, function() {
        $(this).remove();
        resetIndex();
      });
    });
    
    makeSortable();
    
    });