<div class="simpa-albums-container">
	
	<?php for( $i=0; $i < count( $data); $i++ ): 

			$cover_id = $data[$i]['cover_id'];

			if( ! $cover_id ){
				continue;
			}

			$album_id = absint( $data[$i]['id']);
			$album_title = get_the_title( $album_id );
			$cover_id = absint( $data[$i]['cover_id'] );
			$cover_url = $data[$i]['cover'];
			$cover_alt = get_post_meta( $cover_id, '_wp_attachment_image_alt', true);
			$images_count = $data[$i]['images_count'];
			$album_link = get_the_permalink( $album_id );
		?>

		<div class="simpa-album-block">
			<a class="simpa-album-link" href="<?php echo esc_url( $album_link ); ?>" data-id="<?php echo esc_attr( $album_id); ?>">
				<div class="simpa-album-cover">
					<img alt="<?php echo esc_attr( $cover_alt ); ?>" src="<?php echo esc_url( $cover_url ); ?>"/>
				</div>
				<div class="simpa-album-detail">
					<div class="simpa-album-title"> <span><?php echo esc_html( $album_title ); ?></span> </div>
					<small class="simpa-album-photo-count">
						<?php 
						 echo sprintf( _n( '%s photo', '%s photos', absint( $images_count ),'simple-photo-album'),$images_count );
						 ?>
					</small>
				</div>
			</a>	
		</div>

	<?php endfor; ?>

</div>