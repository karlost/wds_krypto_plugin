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

1) přidt do pluginu emaily pluf email templatu
2) přidat do pluginu log
3) informační bloky vpravo
3) do admin rootu přidat funkci na tvorbu formulářů
4) do admini rootu přidat funkci na zpracování formulářů

Při založení nového pluginu je vždy potřeba:
1. Změnit všechny define názvy - TM_PLUGSEC musí zůstat
2.Přejmenovat defaultní classy
3. namespace
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/*******************************
/           DEFINE             *
********************************/

//definice
define( 'TM_PLUGSEC', 'wds_plugins' );
define( 'WDS_PATHSEC', plugin_dir_path( __FILE__ ) );
define( 'WDS_URLSEC', plugin_dir_url( __FILE__ ) );
define( 'WDS_IDSEC', 'template' );

/*******************************
/       INCLUDE PARTS          *
********************************/
//framework
include_once( WDS_PATHSEC . 'framework/styles-scripts.php');  
include_once( WDS_PATHSEC . 'framework/main-menu.php');  
include_once( WDS_PATHSEC . 'framework/log/log-setup.php');  
include_once( WDS_PATHSEC . 'framework/forms-builder.php'); 
include_once( WDS_PATHSEC . 'framework/sessions.php'); 
include_once( WDS_PATHSEC . 'framework/cookies.php'); 
include_once( WDS_PATHSEC . 'framework/forms-core.php');
include_once( WDS_PATHSEC . 'framework/helpers.php'); 
include_once( WDS_PATHSEC . 'framework/forms-core.php');  
//include_once( WDS_PATHSEC . 'framework/emails.php'); 

//add admin page
include_once( WDS_PATHSEC . 'admin/sub-menu.php');  
include_once( WDS_PATHSEC . 'admin/form_fields.php'); 
include_once( WDS_PATHSEC . 'admin/view/main-menu.php'); 
include_once( WDS_PATHSEC . 'admin/view/submenu-content.php'); 

// Include utility functions
//include_once( WDS_PATHSEC . 'components/email-content.php'); 