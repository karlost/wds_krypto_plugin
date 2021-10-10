<?php 

if ( ! defined( 'ABSPATH' ) ) {

  exit;

}



if( ! class_exists( 'sendEmailContentWDS' ) )
 
{

	class sendEmailContentWDS
	{
		public $settings;
		public function __construct(){
			$this->settings = $this->get_settings();
		}
		public function get_settings() {
			$settingsClass = new \pluginslugsec\email\setupEmail;
			$settings = $settingsClass->get_emails_appearance();
			return $settings;
		}

		/*============================================

			Email - new registration (contact seller) 
			
			HOTOVO

		============================================*/
		public function send_license_mail( $mail, $license ) {
			$class_email = new WdsSendEmail($this->settings);
			$subject = __('Licence od Antihackera', WDSLS);
			$title = get_option('_wds_wdslicsys_license_plugin_wds_license_email_title',false);
			$message =  $class_email->email_content( $title, array('test'), 'test'
			);
			/*preprint($message);
			die();*/
			$class_email->send_client_emails( $mail, $subject, $message );
			return true;
		}
	}
	
}
