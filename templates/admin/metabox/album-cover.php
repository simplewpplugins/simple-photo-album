<div id="simpa-album-cover-metabox-container">

    <div class="image-preview">
        <?php 
       $has_cover = false;
       $button_text = __( 'Set Album Cover Photo', 'simple-photo-album' );
       $alt_button_text = __( 'Change Album Cover Photo', 'simple-photo-album' );
       global $post;

        if( simple_photo_album()->helper()->has_album_cover( $post ) ){

            $has_cover = true;

            $alt_button_text = __( 'Set Album Cover Photo', 'simple-photo-album' );

            $button_text = __( 'Change Album Cover Photo', 'simple-photo-album' );


             if( $cover_id = simple_photo_album()->helper()->get_album_cover_id( $post ) ){

              $image =  wp_get_attachment_image_src( $cover_id,'simpa_album_cover' );

              echo '<img src="'.esc_url( $image[0] ).'" width="100%"/>';

             }
       }

        ?>
    </div>

    <p><a uploader-title="<?php _e( 'Select Album Cover Photo', 'simple-photo-album' ); ?>" uploader-button-text="<?php _e( 'Select', 'simple-photo-album' ); ?>" href="#" id="simpa-album-cover-trigger" data-title="<?php echo esc_attr( $alt_button_text ); ?>"><?php echo esc_html( $button_text ); ?></a></p>

    <input type="hidden" id="_album_cover" name="_album_cover" value="<?php if( $has_cover ){ echo absint( simple_photo_album()->helper()->get_album_cover_id( $post ) ); } ?>">

</div>