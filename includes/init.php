<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('Simple_Photo_Album')){

    class Simple_Photo_Album {

        static protected $instance = null;

        public $classes = [];

	/**
	* Autoload classes handler
	*
	* @since 1.0
	*
	* @param $class
	*/

        public static function autoload( $class_name ){

            $class_name = str_replace( 'simpa','includes', $class_name );
            $class_name = str_replace( '\\','/', $class_name );
            $array = explode( '/', strtolower( $class_name ) );
            $class_file_name = 'class-'. end( $array ).'.php';
            $array[ count( $array ) - 1 ] = strtolower($class_file_name);
            $class_name = implode('/',$array);

            if( file_exists( SIMPLE_PHOTO_ALBUM_PATH.$class_name ) ){
                require SIMPLE_PHOTO_ALBUM_PATH.$class_name;
            }

        }


	/**
	 * Main Simple_Photo_Album Instance
	 *
	 * Ensures only one instance of Simple_Photo_Album is loaded or can be loaded.
	 *
	* @since 1.1
	* @static
	* @see simple_photo_album()
	* @return Simple_Photo_Album - Main instance
	*/

        public static function instance(){

            if( is_null( self::$instance ) ){
                self::$instance = new self();
            }

            return self::$instance;

        }


	/**
	* Simple_Photo_Album Constructor
	* Calls includes methods
	* @return void
	*/

        function __construct(){
            $this->includes();
        }



	/**
	* Include required core files.
	* @return void
	*/
        function includes(){

            $this->enqueue();
            $this->shortcode();
            $this->action();
	        $this->helper();
            $this->admin();
            $this->customizer();

        }


	/*
		* @return simpa\Enqueue()
	*/


        function enqueue(){

            if( empty($this->classes['enqueue'])){

                $this->classes['enqueue'] = new simpa\Enqueue();

            }

            return $this->classes['enqueue'];
        }


	/*
		* @return simpa\Shortcode()
	*/


        function shortcode(){

            if( empty($this->classes['shortcode'])){

                $this->classes['shortcode'] = new simpa\Shortcode();
            }

            return $this->classes['shortcode'];
        }



	/*
		* @return simpa\Action()
	*/


	function action(){

            if( empty($this->classes['action'])){

                $this->classes['action'] = new simpa\Action();

            }

            return $this->classes['action'];
        }



	/*
		* @return simpa\Helper()
	*/

	function helper(){

            if( empty($this->classes['helper'])){

                $this->classes['helper'] = new simpa\Helper();

            }

            return $this->classes['helper'];
        }


    /*
        * @return simpa\admin\Admin()
    */


        function admin(){

            if( empty($this->classes['admin'])){

                $this->classes['admin'] = new simpa\admin\Admin();

            }

            return $this->classes['admin'];
        }

    /*
        * @return simpa\admin\Customizer()
    */


        function customizer(){

            if( empty($this->classes['customizer'])){

                $this->classes['customizer'] = new simpa\admin\Customizer();

            }

            return $this->classes['customizer'];
        }

	
	/*
	 * include template file
         * @param $template (file name) eg: get_template_part ( 'admin/metabox',['post_id' => $post_id ])
         * @param $args (array) eg: ['id' => $id ]
	*/


        function get_template_part( $template , $args = [] ){


            if( ! empty( $args ) ){

                extract( $args );
            }

            $path = trailingslashit( get_stylesheet_directory() ).'simple-photo-album/'.$template.'.php';

            if( ! file_exists($path)){

                $path = SIMPLE_PHOTO_ALBUM_PATH.'templates/'.$template.'.php';

            }

            $path = apply_filters( 'simple_photo_album_template',$path, $template );

            include $path;

        }




    }

}


 /*
 	* @calls Simple_Photo_Album::autoload()
	* Autoload class files
 */

spl_autoload_register( array( 'Simple_Photo_Album','autoload' ) );


  /*
 	*@return Simple_Photo_Album instance 
 */

if( ! function_exists('simple_photo_album')){

    function simple_photo_album(){

        return Simple_Photo_Album::instance();

    }

}

simple_photo_album();