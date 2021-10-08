<?php 
/**
 * Zobrazení Rest API dat v adminu
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
if( ! class_exists( 'viewAdminBoxWDS' ) )
{
    
	class viewAdminBoxWDS
	{

		public function __construct()
		{

		}
		/**
		 *  zobrazeni boxu
		 *
		 * @param none
		 * 
		 * @author Wedesin
		 * @return string
		 */
	
        public function wedesin_dashboard_widget_display($type){
			$this->display_box($type);
		}
		/**
		 *  box nastenka 
		 *
		 * @param type (default: plugins)
		 * 
		 * @author Wedesin
		 * @return string
		 */

		private function display_box($type="plugins") { 
			$lang = get_bloginfo('language');
			$rApi = new getRestApiRequestWDS;
			$data = $rApi->get_data($lang, $type);
            if($data) {
				echo '<div class="card'.($type == 'plugins' ? ' info' : '').'">';

					if ($type == 'pluginsnews'){ 
						echo 	'<h2 style="margin-top:0">' .__("Novinky na webu Plugins DigiHood", WDS_BRANDING).'</h2><br>';
					}
					?>

					<div class="wedesin-widget">
					<?php 
						foreach ($data as $post) {
							if($post){
								
								echo '<h'.($type == 'plugins' ? '2' : '3').' style="'.($type == 'plugins' ? 'margin-top:0' : 'font-size:18px') .'">'.$post['title'].'</h'.($type == 'plugins' ? '2>' : '3>');
								echo (!empty($post['content']) ? '<p>'.$post['content'].'</p>' : '');
								echo (!empty($post['button']) && !empty($post['button']['url']) && !empty($post['button']['text']) ? '<a href="'.$post['button']['url'].'" target="_blank" class="button button-primary">'.$post['button']['text'].'</a>' : '');
							}
						}
					?>
					</div>
					<?php
				echo '</div>';
			}
		}
	}
}

if( is_admin() )
	new viewAdminBoxWDS;


