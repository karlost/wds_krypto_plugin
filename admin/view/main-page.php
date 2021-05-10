<?php 

if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if( ! class_exists( 'PluginNameMainPageWDS' ) )

{
    class PluginNameMainPageWDS

	{
		//hook functions

		public function __construct()
		{
            add_action( 'admin_menu',  [$this, 'admin_main_page_wds'] );
        }

        /**
         * Přidává stránku nastavení wedesin pluginů do adminu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function admin_main_page_wds() {
            if (isset( $GLOBALS['admin_page_hooks']['wds-plugins']) || !empty ( $GLOBALS['admin_page_hooks']['wds-plugins'] ) ) {
                add_submenu_page(
                    'wds-plugins',
                    'vyvoj',
                    'vyvoj',
                    'manage_options',
                    'wds_vyvoj_slug',
                    array( $this, 'my_admin_page_contents' ),
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
                    </div>
                </section>
            </div>
            <?php
        }

    }
	new PluginNameMainPageWDS;

}

?>