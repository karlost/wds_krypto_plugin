<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
  
if( ! class_exists( 'addMetaboxToAdmin' ) )
{
	class addMetaboxToAdmin
	{
        public function __construct()
		{
			//metabox
			add_action( 'add_meta_boxes', [$this,'add_meta_boxes_wds'] );
		}

        public function add_meta_boxes_wds() {
            $args = [];
            if ($args) {
                foreach ($args as $key) {
                    add_meta_box( $key[0], $key[1], $key[2], $key[3], $key[4], $key[5]);
                }
            }
            
        }
    }
    new addMetaboxToAdmin;
}