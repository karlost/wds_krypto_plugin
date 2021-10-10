<?php 
namespace components\log\wedesinLogSettings;
use components\log;

//přidáme další soubory
//include_once( TM_PATHKRYPTO . 'components/log/log-content.php'); 
include_once( TM_PATHKRYPTO . 'components/log/log-functions.php'); 

if( ! class_exists( 'logSetupWDS') )
{

	class logSetupWDS
	{

		public function __construct()
		{
            add_action( 'init',  [$this, 'new_folder_wds_log'] );
            add_action( 'admin_menu',  [$this, 'admin_page_wds_log'] );
        }

		/**
         * Přidává stránku s log výpisem do adminu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function admin_page_wds_log() {
            add_menu_page(
                __( 'Wedesin Log', TM ),
                __( 'WDS Log', TM ),
                'manage_options',
                'wds-logs',
                array( $this, 'my_admin_page_contents' ),
                'dashicons-archive',
                65
            );
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
                <nav class="nav-tab-wrapper">
                    <?php 
                        do_action('wds_plugin_log_header_content');
                    ?>
                </nav>
                <div class="tab-content">
                    <?php 
                        do_action('wds_plugin_log_tab_content');
                    ?>
                </div>

            </div>
            <?php
        }

        /**
         * Zkontroluje a případně vytvoří složku pro logy
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function new_folder_wds_log() {

            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/wds-logs';
            if (! is_dir($upload_dir)) {
                mkdir( $upload_dir, 0700 );
            }

            $upload_dir_user = $upload_dir . '/'.TM_IDKRYPTO;
            if (! is_dir($upload_dir_user)) {
                mkdir( $upload_dir_user, 0700 );
            }

        }

    }

    new logSetupWDS;

}
