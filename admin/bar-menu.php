<?php
namespace ticker\admin\bar_menu;

add_action('admin_bar_menu', '\ticker\admin\bar_menu\webmaster_admin_bar_menu', 99);



function webmaster_admin_bar_menu() {



   global $wp_admin_bar;


   $coin = get_option('_wds_krypto_test_form_mini_krypto');
   $fiat = get_option('_wds_krypto_test_form_mini_fiat');
   $rApi = new \ticker\admin\api\call\getRestApiRequestWDS;

   $data = $rApi->get_data($fiat, $coin);
        if($data) {
            
                 
                    foreach ($data as $post) {
                        if($post){
                          $icon = $post['icon'];
                          $price = $post['price'];
                          $name = $post['name'];
                          $scolor = new \ticker\admin\api\view\viewAdminBoxWDS; 
                         $color = $scolor->color_frm_change($post['price_change_percentage_24h']);
                        }
                      }
                  
          }

   $menus[] = array(
      'id' => 'krypto',
      'title' => '<img src="'.$icon.'" alt="'.$name.'" width="5" height="5""><b><font size="5" color="'.($color == 'red' ? 'red' : 'green').'">'.$price.'</font></b>',
      'href' => 'http://coingecko.com/',
      'meta' => array(
         'target' => 'blank'
      )
   );


   foreach ( apply_filters( '\ticker\admin\bar_menu\render_webmaster_menu', $menus ) as $menu )
       $wp_admin_bar->add_menu( $menu );

}