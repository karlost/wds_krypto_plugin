<?php

/**
 * class description
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
class ScriptsStyles extends setupWDS {

  /**
   * 
   * Constructor
   *
   * @date	21/1/21
   * @since	1.0
   *
   * @return	void
   */
  public function __construct()
  {
    parent::__construct();

    //scripty
    add_action( 'wp_enqueue_scripts', [$this, 'add_scripts']);

    //scripty v administraci
    add_action( 'admin_enqueue_scripts', [$this, 'add_admin_scripts'] );

  }

  /**
   * empty function description
   *
   * @param none
   * 
   * @author Wedesin
   * @return true/false
   */ 

  public function add_scripts( ) {

    //Register style
    $star_style = filemtime(  WDS_PATH . 'assets/styles/star-rating.css' );
    wp_enqueue_style( 'star-comments', WDS_URL . 'assets/styles/star-rating.css', array( ), $star_style, 'all' );

    //register gavascript
    $star_script = filemtime(  WDS_PATH . 'assets/scripts/star-rating.js' );
    wp_enqueue_script( 'star-comments', WDS_URL . 'assets/scripts/star-rating.js', array( 'jquery' ), $star_script, true );
    
  }

  public function add_admin_scripts( ) {

    //Register style
    $admin_style = filemtime(  WDS_PATH . 'assets/styles/wds-admin.css' );
    wp_enqueue_style( 'star-comments', WDS_URL . 'assets/styles/wds-admin.css', array( ), $admin_style, 'all' );
	
    wp_enqueue_style( 'fonts-gstatic', 'https://fonts.gstatic.com' );
    wp_enqueue_style( 'font-Lato', 'https://fonts.googleapis.com/css2?family=Lato:ital@0;1&display=swap' );

    wp_enqueue_style( 'wp-color-picker' );

    //register javascript
    $admin_script = filemtime(  WDS_PATH . 'assets/scripts/wds-admin.js' );
    wp_enqueue_script( 'star-comments', WDS_URL . 'assets/scripts/wds-admin.js', array( 'jquery' ), $admin_script, true );
    
    //WP media uploader
    wp_enqueue_media();

    //color picker scripts
    $colorpicker_script = filemtime(  WDS_PATH . 'assets/scripts/wp-color-picker-alpha.min.js' );
    wp_enqueue_script( 'wp-color-picker-alpha', WDS_URL . 'assets/scripts/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), $colorpicker_script, true );

    wp_add_inline_script(
      'wp-color-picker-alpha',
      'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
    );

    //Selectize.js
    $selectize_script = filemtime(  WDS_PATH . 'assets/scripts/selectize.js' );
    wp_enqueue_script( 'selectize', WDS_URL . 'assets/scripts/selectize.js', array( 'jquery' ), $selectize_script, true );

    $selectize_style = filemtime(  WDS_PATH . 'assets/styles/selectize.css' );
    wp_enqueue_style( 'selectize', WDS_URL . 'assets/styles/selectize.css', array( ), $selectize_style, 'all' );
    
  }

}
