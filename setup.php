<?php

/**
* Plugin Name: Šablona pluginů
* Description: ...
* Version: 1.00
* Author: WeDesIn
* Author URI: https://www.wedesin.cz/
* Requires at least: 3.0.
* Tested up to: 5.6
* Text Domain: doplnit
* License: GPL2 or higher
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'setupWDS' ) )
{

    class setupWDS {

        public $admin;
        public $styleScript;

        /**
         *
         * construct
         *
         * @date	21/1/21
         * @since	1.0
         *
         * @param	string $name The constant name.
         * @param	mixed $value The constant value.
         * @return	void
         */
        public function __construct()
        {
            //init the plugin        
            add_action( 'init', [$this, 'plugin_init'] );
        }

        /**
         * define
         *
         * Defines a constant if doesnt already exist.
         *
         * @date	21/1/21
         * @since	1.0
         *
         * @param	string $name The constant name.
         * @param	mixed $value The constant value.
         * @return	void
         */

        function define( $name, $value = true ) {
            if( !defined($name) ) {
                define( $name, $value );
            }
        }

        /**
         * 
         * Plugin initiation functions
         *
         * @date	21/1/21
         * @since	1.0
         *
         * @return	void
         */
        public function plugin_init( ) {

            $this->define( 'WDS_PATH', plugin_dir_path( __FILE__ ) );
            $this->define( 'WDS_URL', plugin_dir_url( __FILE__ ) );

            // Include utility functions
            include_once( WDS_PATH . 'global/styles-scripts.php');  
            include_once( WDS_PATH . 'admin/functions/admin-setup.php');           

            $this->styleScript = new ScriptsStyles();
            $this->admin = new customizeComments();

        }

    }

}

new setupWDS;