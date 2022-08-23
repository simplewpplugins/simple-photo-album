<?php 
namespace simpa;

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('simpa\Helper')){

	
	/**
	* Class Helper
	* @package simpa
	* includes common items
	* @access simple_photo_album()->helper()->method_name();
	*/

	class Helper {

		public $options = [];


		function get_album_cover_id( $post = null ) {
		    $post = get_post( $post );
		    if ( ! $post ) {
		        return false;
		    }
		 
		    $thumbnail_id = (int) get_post_meta( $post->ID, '_album_cover', true );

		    return (int) apply_filters( 'album_cover_id', $thumbnail_id, $post );
		}
		

		function has_album_cover( $post = null ) {

		    $thumbnail_id  = $this->get_album_cover_id( $post );

		    $has_thumbnail = (bool) $thumbnail_id;

		    return (bool) apply_filters( 'has_album_cover', $has_thumbnail, $post, $thumbnail_id );

		}


		function get_option( $option_key = false ){

			if( ! $option_key ){

				return false;

			}

			$default_options = simple_photo_album()->action()->default_options;

			if( ! isset( $this->options[ $option_key ] )){
				$this->options[ $option_key ] = get_option( $option_key, $default_options[$option_key] );
			}

			if( isset( $this->options[ $option_key ] ) ){

				return $this->options[ $option_key ];

			}

			return false;

		}



	}

}