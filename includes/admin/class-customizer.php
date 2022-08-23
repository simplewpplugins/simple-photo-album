<?php 
namespace simpa\admin;

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('simpa\admin\Customizer')){

	/**
	* Class Customizer
	* @package simpa
	*/

	class Customizer {


		/**
		 * Customizer constructor.
		*/

		function __construct(){

			add_action( 'customize_register', array( $this, 'simpa_customize_register' ) );

		}



		function simpa_customize_register( $wp_customize ) {

			// Create our panels

			$wp_customize->add_panel( 'simpa', array(
				'title'          => __('Simple Photo Album', 'simple-photo-album'),
				'description'    => __('Customize photo album settings', 'simple-photo-album'),
			) );
					
			// Create our sections

			$wp_customize->add_section( 'simpa_albums' , array(
				'title'             => __('Albums', 'simple-photo-album'),
				'panel'             => 'simpa',
				'description'       => __('These settings will be used when displaying all albums using <code>[simple_photo_album]</code> shortcode.', 'simple-photo-album'),
			) );

			$wp_customize->add_section( 'simpa_photos' , array(
				'title'             => __('Album Photos', 'simple-photo-album'),
				'panel'             => 'simpa',
				'description'       => __('These settings will be used when displaying individual albums.', 'simple-photo-album'),
			) );
					
			$wp_customize->add_section( 'simpa_advanced' , array(
				'title'             => __('Advanced', 'simple-photo-album'),
				'panel'             => 'simpa',
				'description'       => __('Sizes for image thumbnail generation. <strong>Regeneration of thumbnail is required once you change these settings.</strong> <em style="color:red;">If you are not sure what it is, leave it as default.</em>', 'simple-photo-album'),
			) );
					
			// Create our settings

			/* Albums*/
			$wp_customize->add_setting( 'album_columns_desktop' , array(
				'default'       => '4',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'album_columns_desktop_control', array(
				'label'      => __('No. of ablum columns', 'simple-photo-album'),
				'section'    => 'simpa_albums',
				'settings'   => 'album_columns_desktop',
				'type'       => 'number',
				'description'       => __('Desktop/Laptop','simple-photo-album'),
			) );
					
			$wp_customize->add_setting( 'album_columns_tablet' , array(
				'default'       => '3',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'album_columns_tablet_control', array(
				'label'      => __('No. of ablum columns', 'simple-photo-album'),
				'section'    => 'simpa_albums',
				'settings'   => 'album_columns_tablet',
				'type'       => 'number',
				'description'       => __('Tablet/Ipad','simple-photo-album'),
			) );
					
			$wp_customize->add_setting( 'album_columns_mobile' , array(
				'default'       => '2',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'album_columns_mobile_control', array(
				'label'      => __('No. of ablum columns', 'simple-photo-album'),
				'section'    => 'simpa_albums',
				'settings'   => 'album_columns_mobile',
				'type'       => 'number',
				'description'       => __('Mobile','simple-photo-album'),
			) );

			$wp_customize->add_setting( 'album_columns_gap' , array(
				'default'       => '10',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'album_columns_gap_control', array(
				'label'      => __('Space between columns and rows', 'simple-photo-album'),
				'section'    => 'simpa_albums',
				'settings'   => 'album_columns_gap',
				'type'       => 'number',
				'description'  => __('Gap between 2 album blocks in (px)','simple-photo-album'),
			) );




			/* Photos */
			$wp_customize->add_setting( 'photo_columns_desktop' , array(
				'default'       => '4',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'photo_columns_desktop_control', array(
				'label'      => __( 'No. of photo columns', 'simple-photo-album' ),
				'section'    => 'simpa_photos',
				'settings'   => 'photo_columns_desktop',
				'type'       => 'number',
				'description'  => __( 'Desktop/Tablet','simple-photo-album' ),
			) );
					
			$wp_customize->add_setting( 'photo_columns_tablet' , array(
				'default'       => '3',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'photo_columns_tablet_control', array(
				'label'      => __( 'No. of photo columns', 'simple-photo-album' ),
				'section'    => 'simpa_photos',
				'settings'   => 'photo_columns_tablet',
				'type'       => 'number',
				'description'  => __( 'Tablet', 'simple-photo-album' ),
			) );
					
			$wp_customize->add_setting( 'photo_columns_mobile' , array(
				'default'       => '2',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'photo_columns_mobile_control', array(
				'label'      => __( 'No. of photo columns', 'simple-photo-album' ),
				'section'    => 'simpa_photos',
				'settings'   => 'photo_columns_mobile',
				'type'       => 'number',
				'description'  => __( 'Mobile','simple-photo-album' ),
			) );

			$wp_customize->add_setting( 'photo_columns_gap' , array(
				'default'       => '10',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'photo_columns_gap_control', array(
				'label'      => __( 'Space between columns and rows', 'simple-photo-album' ),
				'section'    => 'simpa_photos',
				'settings'   => 'photo_columns_gap',
				'type'       => 'number',
				'description'  => __( 'Gap between 2 album blocks in (px)','simple-photo-album' ),
			) );


					
			$wp_customize->add_setting( 'cover_width' , array(
				'default'       => '300',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'cover_width_control', array(
				'label'      => __('Cover image width', 'simple-photo-album'),
				'section'    => 'simpa_advanced',
				'settings'   => 'cover_width',
				'type'       => 'number',
				'description'  => __('Displayed in album block. (Size in px)','simple-photo-album'),
			) );
					
			$wp_customize->add_setting( 'cover_height' , array(
				'default'       => '350',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'cover_height_control', array(
				'label'      => __('Cover image height', 'simple-photo-album'),
				'section'    => 'simpa_advanced',
				'settings'   => 'cover_height',
				'type'       => 'number',
				'description'  => __('Displayed in album block. (Size in px)','simple-photo-album'),
			) );


			/* photos thumbnail*/

			$wp_customize->add_setting( 'photo_width' , array(
				'default'       => '300',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'photo_width_control', array(
				'label'      => __('Album photo width', 'simple-photo-album'),
				'section'    => 'simpa_advanced',
				'settings'   => 'photo_width',
				'type'       => 'number',
				'description'  => __('Displayed in individual album view. (Size in px)','simple-photo-album'),
			) );
					
			$wp_customize->add_setting( 'photo_height' , array(
				'default'       => '350',
				'type'          => 'option',
				'transport'     => 'postMessage',
			) );
			$wp_customize->add_control( 'photo_height_control', array(
				'label'      => __('Album photo height', 'simple-photo-album'),
				'section'    => 'simpa_advanced',
				'settings'   => 'photo_height',
				'type'       => 'number',
				'description'  => __('Displayed in individual album view. (Size in px)','simple-photo-album'),
			) );
					
		} /**/



	}

}