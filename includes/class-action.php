<?php 
namespace simpa;

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('simpa\Action')){

	/**
	* Class Action
	* @package simpa
	*/

	class Action {


		public $default_options = [];


		/**
		 * Action constructor.
		*/

		function __construct(){

			add_action( 'plugins_loaded', array( $this, 'plugin_i18n' ) );

			register_activation_hook( SIMPLE_PHOTO_ALBUM_PLUGIN, array( $this, 'activation_hook' ) );

			register_deactivation_hook( SIMPLE_PHOTO_ALBUM_PLUGIN, array( $this, 'deactivation_hook' ) );

			$this->default_options = array(

				'cover_width' => 300,
				'cover_height' => 350,
				'photo_width' => 300,
				'photo_height' => 350,
				'album_columns_desktop' => 4,
				'album_columns_tablet' => 3,
				'album_columns_mobile' => 2,
				'album_columns_gap' => '15',
				'photo_columns_desktop' => 4,
				'photo_columns_tablet' => 3,
				'photo_columns_mobile' => 2,
				'photo_columns_gap' => '15',				
			);

			add_action( 'simpa_activation', array( $this, 'add_default_settings') );

			add_action( 'wp_head', array( $this, 'root_define'),0 );

			add_action( 'after_setup_theme', array( $this, 'add_image_sizes') );

			add_filter( 'enter_title_here', array( $this, 'change_title_placeholder' ) );

			add_filter( 'the_content', array( $this, 'filter_single_page_content' ),99 );

		} /* end of __construct */


		
		/**
		 * Load plugin textdomain
		*/

		function plugin_i18n(){

			load_plugin_textdomain( 'simple-photo-album', false, dirname( plugin_basename( SIMPLE_PHOTO_ALBUM_PLUGIN ) ).'/languages/');

		}



		/**
		 * trigger some action on plugin activation
		*/

		function activation_hook(){

			/* Add default options */
			do_action( 'simpa_activation' );

		}



		/**
		 * trigger some action on plugin deactivation
		*/

		function deactivation_hook(){

			do_action( 'simpa_deactivation' );
		}



		/* Add default options */

		function add_default_settings(){

			$simpa_version = get_option( 'simpa_version');

			if( ! $simpa_version ){
				add_option( 'simpa_version', '1.2' );

				foreach( $this->default_options as $key => $value ){
					add_option( $key, $value );
				}
			}


		} /* end add_default_settings */



		/* Define css ::root with plugin settings */

		function root_define(){

			$cover_width = simple_photo_album()->helper()->get_option( 'cover_width' );
			$cover_height = simple_photo_album()->helper()->get_option( 'cover_height' );

			$photo_width = simple_photo_album()->helper()->get_option( 'photo_width' );
			$photo_height = simple_photo_album()->helper()->get_option( 'photo_height' );

			$album_columns_desktop = simple_photo_album()->helper()->get_option( 'album_columns_desktop' );
			$album_columns_tablet = simple_photo_album()->helper()->get_option( 'album_columns_tablet' );
			$album_columns_mobile = simple_photo_album()->helper()->get_option( 'album_columns_mobile' );
			$album_columns_gap = simple_photo_album()->helper()->get_option( 'album_columns_gap' );

			$photo_columns_desktop = simple_photo_album()->helper()->get_option( 'photo_columns_desktop' );
			$photo_columns_tablet = simple_photo_album()->helper()->get_option( 'photo_columns_tablet' );
			$photo_columns_mobile = simple_photo_album()->helper()->get_option( 'photo_columns_mobile' );
			$photo_columns_gap = simple_photo_album()->helper()->get_option( 'photo_columns_gap' );

			$album_columns_gap .='px';
			$photo_columns_gap .='px';

			?>
				<style>
					:root {
				  --album_columns_desktop: repeat(<?php echo esc_html( $album_columns_desktop ); ?>,1fr);
				  --album_columns_tablet: repeat(<?php echo esc_html( $album_columns_tablet ); ?>,1fr);
				  --album_columns_mobile: repeat(<?php echo esc_html( $album_columns_mobile ); ?>,1fr);
				  --album_columns_gutter: <?php echo esc_html( $album_columns_gap ); ?>;
				  --photo_columns_desktop: repeat(<?php echo esc_html( $photo_columns_desktop ); ?>,1fr);
				  --photo_columns_tablet: repeat(<?php echo esc_html( $photo_columns_tablet ); ?>,1fr);
				  --photo_columns_mobile: repeat(<?php echo esc_html( $photo_columns_mobile ); ?>,1fr);
				  --photo_columns_gutter: <?php echo esc_html( $photo_columns_gap ); ?>;
				}
				</style>
			<?php

		} /* end root_define */



		/* Generate image sizes */

		function add_image_sizes(){

			$cover_width = simple_photo_album()->helper()->get_option( 'cover_width' );
			$cover_height = simple_photo_album()->helper()->get_option( 'cover_height' );

			$photo_width = simple_photo_album()->helper()->get_option( 'photo_width' );
			$photo_height = simple_photo_album()->helper()->get_option( 'photo_height' );

			add_image_size( 'simpa_album_cover', absint( $cover_width ), absint( $cover_height ), true );
			add_image_size( 'simpa_gallery_photo', absint( $photo_width ), absint( $photo_height ), true );

		}


		/* Change title field placeholder */

		function change_title_placeholder( $title ){

			$screen = get_current_screen();
   
		     if  ( 'simpa_album' == $screen->post_type ) {
		          $title = __( 'Album title', 'simple-photo-album' );
		     }
		   
		     return $title;

		}



		/* Replace single post content with gallery shortcode */

		function filter_single_page_content( $content ){

			if(is_singular('simpa_album')){

			     $content = do_shortcode('[simple_photo_album id="'.get_the_id().'"]');

			 }

			return $content;

		}



	}

}