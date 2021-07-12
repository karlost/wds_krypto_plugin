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

/*******************************
/           DEFINE             *
********************************/
//definice
define( 'WDS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WDS_URL', plugin_dir_url( __FILE__ ) );
//definujeme jméno pro lokalizaci
define( 'TM', 'wds' );
//definujeme ID pluginu ve struktuře našich pluginů
define( 'WDS_ID', 'template' );

/*******************************
/       INCLUDE PARTS          *
********************************/

// Include utility functions
include_once( WDS_PATH . 'global/helpers.php'); 
include_once( WDS_PATH . 'global/styles-scripts.php');  
include_once( WDS_PATH . 'global/sessions.php'); 
include_once( WDS_PATH . 'global/cookies.php'); 

//add admin page
include_once( WDS_PATH . 'admin/framework/main-menu.php');  
include_once( WDS_PATH . 'admin/sub-menu.php');  
include_once( WDS_PATH . 'admin/framework/forms-builder.php'); 
include_once( WDS_PATH . 'admin/framework/forms-core.php');  
include_once( WDS_PATH . 'admin/form_fields.php'); 

//admin views
include_once( WDS_PATH . 'admin/view/main-menu.php'); 
include_once( WDS_PATH . 'admin/view/submenu-content.php'); 
