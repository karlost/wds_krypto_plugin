<?php 
/**
 * Zobrazení Rest API dat v adminu
 * 
 * @author Wedesin
 */ 
namespace ticker\admin\api\view;

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
	
        public function wedesin_dashboard_widget_display( $fiat,$coin){
			$this->display_box($fiat,$coin);
		}
		/**
		 *  box nastenka 
		 *
		 * @param type (default: plugins)
		 * 
		 * @author Wedesin
		 * @return string
		 */


		function bd_nice_number($n) {
			// first strip any formatting;
			$n = (0+str_replace(",","",$n));
		   
			// is this a number?
			if(!is_numeric($n)) return false;
		   
			// now filter it;
			if($n>1000000000000) return round(($n/1000000000000),1).' trillion';
			else if($n>1000000000) return round(($n/1000000000),1).' billion';
			else if($n>1000000) return round(($n/1000000),1).' million';
			else if($n>1000) return round(($n/1000),1).' thousand';
		   
			return number_format($n);
		}

		function color_frm_change($n) {
			// first strip any formatting;
			//$n = (0+str_replace(",","",$n));
		   
			// is this a number?
			if(!is_numeric($n)) return false;
		   
			// now filter it;
			//if($n>1000000000000) return round(($n/1000000000000),1).' trillion';
			//else if($n>1000000000) return round(($n/1000000000),1).' billion';
			//else if($n>1000000) return round(($n/1000000),1).' million';
			//else if($n>1000) return round(($n/1000),1).' thousand';
					if ($n>0) {
					$color = 'green'; 
				}else {
					$color = 'red';
				}
					return ($color);
				}


		private function display_box( $fiat, $coin) { 
		//	$lang = get_bloginfo('language');
			$rApi = new \ticker\admin\api\call\getRestApiRequestWDS;
			$data = $rApi->get_data($fiat, $coin);
            if($data) {
				echo '<div class="card'.($type == 'plugins' ? ' info' : '').'">';

					if ($coin == 'bitcoin'){ 
						echo 	'<h2 style="margin-top:0">' .__("coin api", WDS_BRANDING).'</h2><br>';
					}
					?>

					<div class="wedesin-widget">
					<?php 
						foreach ($data as $post) {
							if($post){
								echo $coin;
								preprint ($post['name']);
								preprint ($post['market_cap']);
								preprint ($post['price_change_percentage_24h']);
								preprint ($post['price']);
								preprint ($post['icon']);;
								
								preprint($this->color_frm_change($post['price_change_percentage_24h']));
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
	new \ticker\admin\api\view\viewAdminBoxWDS;


