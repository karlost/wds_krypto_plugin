<?php 
namespace ticker\admin\api\view;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if (!function_exists('info_krypto')){
    function info_krypto(){
      
      $number_format = new \ticker\admin\api\view\viewAdminBoxWDS;

        $coin = get_option('_wds_krypto_test_form_mini_krypto');
        $fiat = get_option('_wds_krypto_test_form_mini_fiat');
        $rApi = new \ticker\admin\api\call\getRestApiRequestWDS;
        $data = $rApi->get_data($fiat, $coin);
        if($data) {
            
                 
                    foreach ($data as $post) {
                        if($post){
                            $color = $number_format->color_frm_change($post['price_change_percentage_24h']);
                            echo '<p style="color:'.$color.'">'.$post['price'].'</p>';
                            echo $coin;
                            preprint ($post['name']);
                            preprint ($post['market_cap']);
                            preprint ($post['price_change_percentage_24h']);
                            preprint ($post['price']);
                        }
                    }
                
        }
    };

}


