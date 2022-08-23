<?php 
namespace simpa;

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('simpa\Shortcode')){

	/**
	* Class Shortcode
	* @package simpa
	*/

	class Shortcode {


		/**
		 * Shortcode constructor.
		*/

		function __construct(){

			add_shortcode( 'simple_photo_album', array( $this, 'shortcode_cb' ) );

		}



		function shortcode_cb( $atts = [] ){

			$atts = shortcode_atts( array(
		        'id' => false
		    ), $atts, 'simple_photo_album' );

		    extract( $atts );
		    ob_start();

		    if( ! $id ){
		    	
		    	$this->load_gallery_view();

		    }else{

		    	$album = get_post( absint( $id ) );

		    	if( $album && 'simpa_album' == $album->post_type ){

		    		$this->load_single_album_view( $album );

		    	}else{

		    		simple_photo_album()->get_template_part( 'invalid-album' );
		    	}
		    }

		    $contents = ob_get_contents();
		    ob_end_clean();
		    return $contents;

		}



		function load_gallery_view(){

			// load all albums
		    	$args = array(
		    		'post_type' => 'simpa_album',
		    		'posts_per_page' => -1
		    	);

		    	$query = new \WP_Query( $args );

			    if( $query->have_posts()){

			    	$data = [];

			    	while( $query->have_posts() ): $query->the_post();

			    		$title = get_the_title();

			    		$id = get_the_id();

			    		$images = get_post_meta( $id, '_simpa_photos', true );

			    		$image_count = 0;

			    		if( $images && is_array( $images) && ! empty( $images ) ) {

			    			$image_count = count( $images );

			    		}

			    		$cover_photo_url = '';

						$cover_photo_id = 0;

			    		if( simple_photo_album()->helper()->has_album_cover( $id ) ){

		    				$cover_photo_id = simple_photo_album()->helper()->get_album_cover_id( $id );

		    				$cover_photo_url = \wp_get_attachment_image_src( $cover_photo_id ,'simpa_album_cover' )[0];

		    			}elseif( $image_count ){

								sort($images);

								$cover_photo_id = absint( $images[0] );

		    					$cover_photo_url = \wp_get_attachment_image_src( $cover_photo_id ,'simpa_album_cover' )[0];
						}

			    		$data[] = [
			    			'id' => $id,
			    			'title' => $title,
			    			'cover' => $cover_photo_url,
			    			'cover_id' => $cover_photo_id,
			    			'images_count' => $image_count
			    		];

			    	endwhile;

			    	wp_reset_postdata();

			    	wp_enqueue_style( 'simple-photo-album_styles' );

			    	simple_photo_album()->get_template_part( 'albums', ['data' => $data ] );

			    }else{

			    	simple_photo_album()->get_template_part( 'no-album' );
			    }

		}





		function load_single_album_view( $album ){

					wp_enqueue_style( 'simple-photo-album_styles' );

					wp_enqueue_style( 'fancybox' );

					wp_enqueue_script( 'fancybox' );

					wp_enqueue_script( 'simple-photo-album_scripts' );

					$images =  get_post_meta( $album->ID, '_simpa_photos', true );

					if( $images && is_array( $images ) ){

						sort( $images );

					}else{

						$images = [];

					}

					if( simple_photo_album()->helper()->has_album_cover( $album->ID ) ){

						$cover_photo_id = simple_photo_album()->helper()->get_album_cover_id( $album->ID );

						if( $cover_photo_id && ! in_array( $cover_photo_id, $images ) ){
							$images[] = $cover_photo_id;
						}

					}

					if( empty( $images ) ){

						simple_photo_album()->get_template_part( 'empty-album' );
						
					}else{

			    		simple_photo_album()->get_template_part( 'album', array(
							'id' => $album->ID,
							'photos' => $images
						));

					}

		}



	}

}