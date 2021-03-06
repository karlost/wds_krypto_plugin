<?php
namespace ticker;
/**
* Plugin Name: WDS krypto  
* Description: Zobrazování cen určité kryptoměny
* Version: 1.0.0
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
1. Změnit všechny define názvy - TM_PLUGKRYPTO musí zůstat
2.Přejmenovat defaultní classy
3. namespace

Co opravit templatě
2) Přidat templatu emailů
3) Kompletně zprovoznit gulpfile
5) Nefungoval rovnou ukládání core metaboxů. 
6) Přidat rovnou classu na tvorbu metaboxů a rovnou jí zprovoznit.
7) Přidat do emailu rovnou funkci send_general_email s parametrem předmětu a obsahu
8) V emailech vyřešit "replyto"
9) Logo v emailu v záhlaví nějak hromadně opravit.

*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/*******************************
/           DEFINE             *
********************************/

//definice
define( 'TM_PLUGKRYPTO', 'wds_krypto' );
define( 'TM_PATHKRYPTO', plugin_dir_path( __FILE__ ) );
define( 'TM_URLKRYPTO', plugin_dir_url( __FILE__ ) );
define( 'TM_IDKRYPTO', 'krypto' );

/*******************************
/       INCLUDE PARTS          *
********************************/
//framework
include_once( TM_PATHKRYPTO . 'framework/styles-scripts.php');  
include_once( TM_PATHKRYPTO . 'framework/main-menu.php');  
include_once( TM_PATHKRYPTO . 'framework/log/log-setup.php');  
include_once( TM_PATHKRYPTO . 'framework/forms-builder.php'); 
include_once( TM_PATHKRYPTO . 'framework/sessions.php'); 
include_once( TM_PATHKRYPTO . 'framework/cookies.php'); 
include_once( TM_PATHKRYPTO . 'framework/forms-core.php');
include_once( TM_PATHKRYPTO . 'framework/helpers.php'); 
 
//add admin page
include_once( TM_PATHKRYPTO . 'admin/sub-menu.php');  
include_once( TM_PATHKRYPTO . 'admin/form_fields.php'); 
include_once( TM_PATHKRYPTO . 'admin/view/main-menu.php'); 
include_once( TM_PATHKRYPTO . 'admin/view/settings-content.php'); 

/*******************************
/       Emaily                 *
********************************/
include_once( TM_PATHKRYPTO . 'framework/emails.php'); 
include_once( TM_PATHKRYPTO . 'admin/email-setup.php');
include_once( TM_PATHKRYPTO . 'components/email-content.php');  

/* KONEC EMAILŮ  - nezapomenout změnit namespace v email-setup a email-content !!!!
*/

// Include utility functions
include_once( TM_PATHKRYPTO . 'admin/info-box/volaniapi.php');
include_once( TM_PATHKRYPTO . 'admin/info-box/zobrazeni.php');  
include_once( TM_PATHKRYPTO . 'admin/api/volaniapi.php');
include_once( TM_PATHKRYPTO . 'admin/api/zobrazeni.php');
include_once( TM_PATHKRYPTO . 'admin/info-krypto.php');
include_once( TM_PATHKRYPTO . 'admin/bar-menu.php');
//include_once( TM_PATHKRYPTO . 'components/custom-post-types.php');