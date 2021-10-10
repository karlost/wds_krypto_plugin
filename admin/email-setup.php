<?php 
namespace tickersec\email;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}



if( ! class_exists( 'setupEmail' ) )
 
{

	class setupEmail
	{
		
		public function __construct(){
            //add_action('init', [$this, 'get_emails_appearance']);
		}
        public function get_emails_appearance() {
            
            $form_name = 'emails_settings';
            $settings = [];
            $params = [
                'footer_bg_color', 'footer_color', 'header_logo', 'reply_to_text', 'reply_to_email'
            ];
            foreach ($params as $param) {
                if ( wds_get_option($this->wds_meta_name($form_name, $param)) ) {
                    $settings[$param] = wds_get_option( $this->wds_meta_name($form_name, $param) );
                }
            }
            return $settings;


        }
        function wds_meta_name( $form_prefix, $meta_name ) {

            return '_wds_'.TM_IDKRYPTO.'_'.  $form_prefix. '_' .$meta_name;
    
        }
    }
	
} 
