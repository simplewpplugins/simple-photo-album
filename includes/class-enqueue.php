<?php 
namespace simpa;

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('simpa\Enqueue')){

	/**
	* Class Enqueue
	* @package simpa
	*/

	class Enqueue {


		/**
		 * @var string
		 */
		var $suffix = '';


		
		/**
		 * Enqueue constructor.
		*/

		function __construct(){

			$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_assets' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );

		}


		/**
		 * Enqueue plugin css & js
		*/

		function frontend_assets(){

			wp_register_style( 'simple-photo-album_styles', SIMPLE_PHOTO_ALBUM_URL.'assets/css/simple-photo-album'.$this->get_asset_sufix().'.css' );

			wp_register_style( 'fancybox', SIMPLE_PHOTO_ALBUM_URL.'assets/css/jquery.fancybox'.$this->get_asset_sufix().'.css' );

			wp_register_script( 'fancybox',SIMPLE_PHOTO_ALBUM_URL.'assets/js/jquery.fancybox'.$this->get_asset_sufix().'.js',array( 'jquery' ),'3.5.7',true );

			wp_register_script( 'simple-photo-album_scripts', SIMPLE_PHOTO_ALBUM_URL.'assets/js/simple-photo-album'.$this->get_asset_sufix().'.js', array( 'jquery' ),'1.0',true );

			if( is_singular('simpa_album') ){

				wp_enqueue_style( 'simple-photo-album_styles' );
				wp_enqueue_style( 'fancybox' );

				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'fancybox' );
				wp_enqueue_script( 'simple-photo-album_scripts' );

			}

		}

		
		/**
		 * Enqueue css and js for admin area.
		*/


		function admin_assets(){

			$screen = get_current_screen();
			
			if( is_object( $screen ) && 'simpa_album' == $screen->post_type ){

				wp_enqueue_style( 'simple-photo-album_admin_styles', SIMPLE_PHOTO_ALBUM_URL.'assets/css/simple-photo-album-admin-style'.$this->get_asset_sufix().'.css' );

				wp_enqueue_script( 'jquery' );

				wp_enqueue_media();
				
				wp_enqueue_script( 'simple-photo-album_main_scripts', SIMPLE_PHOTO_ALBUM_URL.'assets/js/simple-photo-album-admin-script'.$this->get_asset_sufix().'.js', array( 'jquery' ),'1.0',true );

			}

		}


		/**
		 * @return string
		 */

		function get_asset_sufix(){
			
			return $this->suffix;
		}



	}

}