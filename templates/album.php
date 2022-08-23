<div class="simpa-gallery-container">
	<?php
	for( $i=0;$i < count( $photos ); $i++): 
		 $image_id = absint( $photos[ $i ] );
		 $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		 $caption = wp_get_attachment_caption( $image_id );
		 $title = get_the_title( $image_id );
		$thumbnail = wp_get_attachment_image_src( $image_id,'simpa_gallery_photo' );

		$full_image = wp_get_attachment_image_src( $image_id,'full' );
		$medium_image = wp_get_attachment_image_src( $image_id,'medium' );
		$large_image = wp_get_attachment_image_src( $image_id,'large' );

		$srcset = $full_image[0].' 1600w, '.$large_image[0].' 1200w, '.$medium_image[0].' 640w';

		$group = 'album-'.get_post_field( 'post_name', $id );
	?>
	<div class="item">
		<a data-srcset="<?php echo esc_attr( $srcset); ?>" href="<?php echo esc_url( $full_image[0] ); ?>" class="desc" data-fancybox="<?php echo esc_attr( $group ); ?>" data-title="<?php echo esc_attr( $title ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
		    <img src="<?php echo esc_url( $thumbnail[0] ); ?>" title="<?php echo esc_attr( $title ); ?>" alt="<?php echo esc_attr( $alt ); ?>"/>
		    <div class="simpa-hover-overlay"><span>+</span></div>
		</a>
	</div>
	<?php endfor; ?>
</div>

