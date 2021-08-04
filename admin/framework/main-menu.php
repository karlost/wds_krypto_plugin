<?php 

if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if( ! class_exists( 'mainMenuWDS' ) )
{
    class mainMenuWDS
	{
		//hook functions
		public function __construct()
		{
            add_action( 'admin_menu',  [$this, 'main_menu_callback'] );
        }

        /**
         * Přidává stránku nastavení wedesin pluginů do adminu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function main_menu_callback() {

            if (!isset( $GLOBALS['admin_page_hooks']['wds-plugins']) || empty( $GLOBALS['admin_page_hooks']['wds-plugins'] ) ) {
                add_menu_page(
                    __( 'WDS Plugins', TM ),
                    __( 'WDS Plugins', TM ),
                    'manage_options',
                    'wds-plugins',
                    array( $this, 'my_admin_page_contents' ),
                    'dashicons-admin-generic',
                    65
                );
        
            }
            
        }


        /**
         * Zobrazení hlavní admin stránky v adminu wordpressu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        function my_admin_page_contents() {
            ?>
            <div class="wrap">

                <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
                <section>
                    <div class="plugins-list">
                    <?php
                        $this->wds_plugins_menu();
                    ?>
                    </div>
                </section>
            </div>
            <?php
        }

        /**
         * Plugins menu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        function wds_plugins_menu() { 
            global $submenu;
            ?>
            <div class="plugins-list">
                <?php
                if (isset($submenu['wds-plugins']) && !empty($submenu['wds-plugins'])){
                    $submenu_list = $submenu['wds-plugins']; ?>
                    <ul class="wds-plugins-list">
                        <?php
                        foreach ($submenu_list as $key) {
                            if ( isset($key[2]) && !empty($key[2]) && isset($key[2]) && !empty($key[3]) ) {
                                echo '<li><a href="'.menu_page_url($key[2], false).'">'.$key[3].'</a></li>';
                            }
                        } ?>
                    </ul>
                    <?php

                }

                ?>
            </div>
            <?php
        }

    }
	new mainMenuWDS;
}
