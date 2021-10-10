<?php 
/**
 * Stažení dat z webu
 * 
 * @author Wedesin
 */ 
namespace ticker\admin\api\call;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'getRestApiRequestWDS' ) )
{
    
	class getRestApiRequestWDS
	{
		private $api_url;
		private $taxpluginsnews_id = 7;
		private $taxplugins_id = 5;
	//	private $coin = 'bitcoin';
	private $api_urll;

		
  
		public function __construct()
		{ 
			// URl pro získaní dat
			$this->api_url = 'https://api.coingecko.com/api/v3/simple/price';
			$this->api_urll = 'https://api.coingecko.com/api/v3/coins/';
		}

		/**
		 *  ziskaní url 
		 *
		 * @param type (CPT)
		 * 
		 * @author Wedesin
		 * @return string
		 */ 

		private function get_urlu($coin) {
		return $this->api_urll . $coin;
			//return $this->api_urll .'?ids='.$coin.'&vs_currencies='.$fiat.'&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=true';
				//return $this->api_url . $type . '/?'.$type.'_type='.$this->taxpluginsnews_id.'&per_page=1';
				
			
		}

		private function get_url($coin, $fiat='usd') {
		
			return $this->api_url .'?ids='.$coin.'&vs_currencies='.$fiat.'&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=true';
				//return $this->api_url . $type . '/?'.$type.'_type='.$this->taxpluginsnews_id.'&per_page=1';
				
			
		}
		/**
		 * odesladni jazyku  a typu
		 *
		 * @param lang,type (jazyk, a typ přispěvku)
		 * 
		 * @author Wedesin
		 * @return string
		 */ 

		public function get_data($fiat, $coin) {
			$data = $this->rest_api_post($fiat, $coin);
			return $data;
		}
	
		/**
		 *  Rest API přispěvků
		 *
		 * @param type,lang 
		 * 
		 * @author Wedesin
		 * @return string
		 */

		private function rest_api_post($fiat,$coin){
		//	$coin = 'bitcoin';
		//	$fiat = 'eur';
			try {
			// Přimé napojení Rest API na ziskanou URL 
			   $response = wp_remote_get( $this->get_urlu($coin) );
            
            //$response = wp_remote_get ('https://min-api.cryptocompare.com/data/price?fsym='.$crypto.'&tsyms='.$fiat.'');
         //   $response = wp_remote_get ('https://api.coingecko.com/api/v3/simple/price?ids='.$coin.'&vs_currencies='.$fiat.'&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=true');
			} catch (Error $e) {
                echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';
            }

			// Ukončí pokud se vyskytne error vrátí prazdno
			if ( !$response || is_wp_error( $response ) || !is_array( $response ) ) {
				
				return '';
			}

			// Získá Data
			$posts = json_decode( wp_remote_retrieve_body( $response ) );

			$array = [];
	        // Pokud je $posts prazdný vrátí prazdný pole
			if ( !empty( $posts ) ) {	
			// Data Pro kazdý Posts 
				
					$array[] = array (
						'name'      => ( isset($posts->name) && !empty($posts->name) ? $posts->name : 'Currency') ,
						'market_cap'      => ( isset($posts->market_data->market_cap->$fiat) && !empty($posts->market_data->market_cap->$fiat) ? $posts->market_data->market_cap->$fiat : '') ,
						'price_change_percentage_24h'   => ( isset($posts->market_data->price_change_percentage_24h) && !empty($posts->market_data->price_change_percentage_24h) ? $posts->market_data->price_change_percentage_24h : '') ,
						'price'      => ( isset($posts->market_data->current_price->$fiat) && !empty($posts->market_data->current_price->$fiat) ? $posts->market_data->current_price->$fiat : '') ,
						'icon'      => ( isset($posts->image->thumb) && !empty($posts->image->thumb) ? $posts->image->thumb : '') ,
						
					);

				
			} 
			//echo $coin;
		//	preprint($posts->market_data->current_price->usd);
		//	preprint($post->usd);
		//	preprint($posts);
			return $array;	
		}
		/**
		 *  Rest API Obrazků
		 *
		 * @param img_id
		 * 
		 * @author Wedesin
		 * @return string
		 */

		private function rest_api_img( $img_id ){
			// defautní type pro media
			$type = 'media';
			try {
			// Přimé napojení Rest API na ziskanou URL 
				$img_response = wp_remote_get( $this->get_url($type,$img_id) );
			} catch (Error $e) {
				echo "Při stažení posledního příspěvku došlo k chybě " . $e->getMessage() . '.';
			}
	 		// Ukončí pokud se vyskytne error a vrátí prazdno
			if ( !$img_response || is_wp_error( $img_response ) || !is_array( $img_response ) ) {
				return '';
			}
			// Pokud $img_response['body'] je vyplnený a není prazdný poté se decoduje a vratí URL obrazku 
				if (isset($img_response['body']) && !empty($img_response['body']) ) { 
					$api_img = json_decode( $img_response['body'] ); 
					if ($api_img->media_details->sizes->medium->source_url){ 		
						return $api_img->media_details->sizes->medium->source_url;
					} else {
								
						return '';
					}

				}
				
			return '';
				
		}

	}

}



