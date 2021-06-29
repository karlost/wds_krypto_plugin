<?php

/**
* Plugin Name: Šablona pluginů
* Description: ...
* Version: 1.00
* Author: WeDesIn
* Author URI: https://www.wedesin.cz/
* Requires at least: 3.0.
* Tested up to: 5.6
* Text Domain: textdomain
* License: GPL2 or higher
*/

/*

3) do admin rootu přidat funkci na tvorbu formulářů
4) do admini rootu přidat funkci na zpracování formulářů

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

            //definice
            $this->define( 'WDS_PATH', plugin_dir_path( __FILE__ ) );
            $this->define( 'WDS_URL', plugin_dir_url( __FILE__ ) );
            //definoujeme jméno pro lokalizaci
            $this->define( 'TM', 'wds' );

            // Include utility functions
            include_once( WDS_PATH . 'global/helpers.php'); 
            include_once( WDS_PATH . 'global/styles-scripts.php');  
            include_once( WDS_PATH . 'global/sessions.php'); 
            include_once( WDS_PATH . 'global/cookies.php'); 
            
            //add admin page
            include_once( WDS_PATH . 'admin/main-menu.php');  
            include_once( WDS_PATH . 'admin/sub-menu.php');  
            include_once( WDS_PATH . 'admin/forms-builder.php'); 
            include_once( WDS_PATH . 'admin/forms-core.php');  
            
            //admin views
            include_once( WDS_PATH . 'admin/view/main-menu.php'); 
            include_once( WDS_PATH . 'admin/view/submenu-content.php'); 
                        
            $this->styleScript = new ScriptsStyles();

        }

    }

}

new setupWDS;