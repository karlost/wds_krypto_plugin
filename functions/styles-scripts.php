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

}
