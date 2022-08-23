<?php 
namespace simpa\admin;

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('simpa\admin\Admin')){


	/**
	* Class Admin
	* @package simpa\admin
	*/

	class Admin {


		/**
		 * Admin constructor.
		*/
		
		function __construct(){

			/*
				Add post type
			*/
			add_action( 'init', array( $this , 'create_post_type' ) );


			/*
				Admin Columns for simpa_album post type
			*/

			add_filter( 'manage_simpa_album_posts_columns', array( $this, 'add_custom_columns') );

			add_action( 'manage_simpa_album_posts_custom_column',array( $this, 'add_custom_column_data' ), 10, 2 );


			/* Add metaboxes */
			add_action('add_meta_boxes', array( $this,'add_gallery_metabox' ) );

			/* save metabox data */
            add_action('save_post', array( $this , 'gallery_meta_save'));

		} /* end of __construct*/


		public function create_post_type() {
			$labels = array(
					'name'                  => _x( 'Albums', 'Post Type General Name', 'simple-photo-album' ),
					'singular_name'         => _x( 'Album', 'Post Type Singular Name', 'simple-photo-album' ),
					'menu_name'             => __( 'Photo Albums', 'simple-photo-album' ),
					'name_admin_bar'        => __( 'Albums', 'simple-photo-album' ),
					'archives'              => __( 'Album Archives', 'simple-photo-album' ),
					'attributes'            => __( 'Album Attributes', 'simple-photo-album' ),
					'parent_item_colon'     => __( 'Parent Album:', 'simple-photo-album' ),
					'all_items'             => __( 'All Albums', 'simple-photo-album' ),
					'add_new_item'          => __( 'Add Album', 'simple-photo-album' ),
					'add_new'               => __( 'Add Album', 'simple-photo-album' ),
					'new_item'              => __( 'New Album', 'simple-photo-album' ),
					'edit_item'             => __( 'Edit Album', 'simple-photo-album' ),
					'update_item'           => __( 'Update Album', 'simple-photo-album' ),
					'view_item'             => __( 'View Album', 'simple-photo-album' ),
					'view_items'            => __( 'View Album', 'simple-photo-album' ),
					'search_items'          => __( 'Search Album', 'simple-photo-album' ),
					'not_found'             => __( 'Not found', 'simple-photo-album' ),
					'not_found_in_trash'    => __( 'Not found in Trash', 'simple-photo-album' ),
					'featured_image'        => __( 'Album Cover Photo', 'simple-photo-album' ),
					'set_featured_image'    => __( 'Set Album Cover Photo', 'simple-photo-album' ),
					'remove_featured_image' => __( 'Remove Album Cover Image', 'simple-photo-album' ),
					'use_featured_image'    => __( 'Use as Album Cover Image', 'simple-photo-album' ),
					'insert_into_item'      => __( 'Insert into Album', 'simple-photo-album' ),
					'uploaded_to_this_item' => __( 'Uploaded to this item', 'simple-photo-album' ),
					'items_list'            => __( 'Albums list', 'simple-photo-album' ),
					'items_list_navigation' => __( 'Albums list navigation', 'simple-photo-album' ),
					'filter_items_list'     => __( 'Filter Albums list', 'simple-photo-album' ),
				);

				$rewrite = array(
					'slug'                  => 'album',
					'with_front'            => true,
					'pages'                 => true,
					'feeds'                 => true,
				);

				$rewrite = apply_filters( 'simpa_album_slug', $rewrite );
				
				$args = array(
					'label'                 => __( 'Albums', 'simple-photo-album' ),
					'description'           => __( 'Album post type for simple photo album.', 'simple-photo-album' ),
					'labels'                => $labels,
					'supports'              => array( 'title'),
					'hierarchical'          => false,
					'public'                => true,
					'show_ui'               => true,
					'show_in_menu'          => true,
					'menu_position'         => 5,
					'menu_icon'             => 'dashicons-format-gallery',
					'show_in_admin_bar'     => true,
					'show_in_nav_menus'     => true,
					'can_export'            => true,
					'has_archive'           => false,
					'exclude_from_search'   => true,
					'publicly_queryable'    => true,
					'capability_type'       => 'page',
					'rewrite'				=> $rewrite
				);

				register_post_type( 'simpa_album', $args );

		} /* end of create_post_type*/



			/* add admin columns */

			function add_custom_columns( $columns ){

				unset($columns['title']);

				$columns['cover_photo'] = __( 'Cover Photo', 'simple-photo-album' );

				$columns['title'] = __( 'Album Title', 'simple-photo-album' );

				$columns['no_of_photos'] = __( 'No. of Photos', 'simple-photo-album' );

				$columns['shortcode'] = __( 'Shortcode', 'simple-photo-album' );

				return $columns;

			} /* end of add_custom_columns */



			/* add custom column data */

			function add_custom_column_data(  $column, $post_id ){

				switch( $column ){

					case 'cover_photo' :

						$img = '';
						if( simple_photo_album()->helper()->has_album_cover() ){

							$image = wp_get_attachment_image_src( simple_photo_album()->helper()->get_album_cover_id( $post_id), 'thumbnail' );

							if( $image ){

								$img = $image[0];
								$img = '<img src="'.esc_url( $image[0] ).'" width="50"/>';

							}

						}
						echo $img;
						break;

					case 'no_of_photos' :

						$count = 0;

						$images = get_post_meta( $post_id, '_simpa_photos',true );

						if( $images ){

							$count = count( $images );

						}

						echo '<strong>'.esc_html( $count ).'</strong>';

						break;

					case 'shortcode' :

						echo '<code>[simple_photo_album id="'.absint( $post_id ).'"]</code>';

						break;
				}

			} /* end of add_custom_column_data */


			/* add metaboxes */

			function add_gallery_metabox(){

	          add_meta_box( 'simpa-album-cover', __( 'Album Cover', 'simple-photo-album' ), array( $this,'album_covermetabox_ui'), 'simpa_album',  'side', 'high' );

	          add_meta_box( 'simpa-album-metabox', __( 'Photos', 'simple-photo-album' ), array( $this,'gallery_metabox_ui'), 'simpa_album',  'normal', 'high' );
	        
	        }



	        /* load metabox templates for album cover */

	        function album_covermetabox_ui( $post ){

	          simple_photo_album()->get_template_part( 'admin/metabox/album-cover',[ 'post' => $post ] );

	        }

	        /* load metabox templates for galeryr */
	        function gallery_metabox_ui( $post ){
	            
	            $ids = get_post_meta( get_the_id(), '_simpa_photos', true );
	            
	            simple_photo_album()->get_template_part( 'admin/metabox/gallery',[ 'post' => $post, 'ids' => $ids ] );

	        }


	        /* Save custom metabox data */

	        function gallery_meta_save( $post_id  ){


	        	/* Save gallery photos*/
	            if( isset( $_POST['_simpa_photos'] ) ){

	                $photos = $_POST['_simpa_photos'];
	  
	                if(! is_array( $photos)) return;
	  
	                foreach( $photos as $key => $image_id ):
	  
	                  if(! is_numeric( $image_id )) return;
	  
	                endforeach;

	                $photos = array_map( 'absint', $photos );
	  
	                update_post_meta( $post_id, '_simpa_photos', $photos );
	  
	              } else {

	                delete_post_meta( $post_id, '_simpa_photos' );

	              }

	              

	        	/* Save album cover */
	            if( isset($_POST['_album_cover']) && absint( $_POST['_album_cover'] ) > 0 ){

	              update_post_meta( $post_id, '_album_cover', absint( $_POST['_album_cover'] ) );

	            }else{

	              delete_post_meta( $post_id, '_album_cover' );
	              
	            }

	            
	              

	        }




	}

}