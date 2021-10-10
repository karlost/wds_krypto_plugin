<?php 
namespace ticker\admin\submenu;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if( ! class_exists( 'subMenuWDS' ) )

{
    class subMenuWDS

	{
		//hook functions

		public function __construct()
		{
            add_action( 'admin_menu',  [$this, 'submenus_callback'] );
        }

        /**
         * Přidává stránku nastavení wedesin pluginů do adminu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function submenus_callback() {

            /*https://developer.wordpress.org/reference/functions/add_submenu_page/
            1) slub nadřazené položky menu
            2) titulek stránky
            3) menu stránky
            4) pravomoce
            5) menu slug
            6) callback na přidání obsahu
            */

            $subcontent = new \ticker\admin\submenu\content\submenuContentWDS;

            $submenus = [
                [
                    'wds-plugins',                              
                    __( 'Kryptoměny', TM_PLUGKRYPTO ),                    
                    __('Kryptoměny', TM_PLUGKRYPTO),               
                    'manage_options',                           
                    'krypto',                              
                    [$subcontent, 'my_admin_page_contents'],          
                ]
            ];

            if ( !empty( $submenus ) ) {
                foreach ( $submenus as $submenu ) {
                    add_submenu_page(
                        $submenu[0],
                        $submenu[1],
                        $submenu[2],
                        $submenu[3],
                        $submenu[4],
                        $submenu[5],
                    );
                }
            }             
            
        }

    }

	new \ticker\admin\submenu\subMenuWDS;

}

