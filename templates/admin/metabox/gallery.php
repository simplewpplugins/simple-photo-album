<table class="form-table">
      <tr><td>
        <a class="photo-add button button-primary" href="#" data-uploader-title="<?php _e( 'Add image(s) to gallery','simple-photo-album' ); ?>" data-uploader-button-text="Add image(s)"><b><?php _e( 'Add Photos','simple-photo-album' ); ?></b></a>

        <ul id="gallery-metabox-list">
        <?php 
            if ($ids) : 
            foreach ( $ids as $key => $value ) : 
                $image = wp_get_attachment_image_src( $value );
              ?>

              <li>
                <input type="hidden" name="_simpa_photos[ <?php echo $key; ?> ]" value="<?php echo esc_attr( $value ); ?>">
                <img class="image-preview" src="<?php echo esc_url( $image[0] ); ?>">
                <span class="controls"><a class="remove-image" href="#">&times;</a></span> 
              </li>

            <?php 
            endforeach; 
            endif; 
        ?>
        </ul>

      </td></tr>
</table>