<?php 

if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if( ! class_exists( 'wedesinLogSettings' ) )

{

	class wedesinLogSettings

	{
		//konstruktor
		public function __construct()
		{
            
            //spuštní
            //add_action( 'admin_menu',  [$this, 'admin_page_wds_log'] );
            add_action('wds_plugin_log_tab_content', [$this, 'add_tab'] );

            //testování
            add_action( 'init',  [$this, 'test__log'] );
            add_action( 'init',  [$this, 'test__user_log'] );

        }

        public function test__log() {
            if ( isset($_GET['test_log']) && $_GET['test_log'] == 1  ) {
                $log = new wedesinLog;
                $log->add_log(            
                    'ahoj',
                    'testuji si tu uložení',
                    111,
                    get_current_user_id(),
                    'blabla'
                );

                die('tu');
            }
        }

        public function test__user_log() {
            if ( isset($_GET['test_user_log']) && $_GET['test_user_log'] == 1  ) {
                $log = new wedesinLog;
                $log->add_user_log(            
                    'ahoj',
                    'testuji si tu uložení',
                    111,
                   get_current_user_id(),
                    'blabla', 
                    'šestý parametr'
                );
                die('tu');
            }
        }

        /**
         * Vrátí složku pro logy
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function get_wds_log_folder() {
            $upload_dir = wp_upload_dir();
            $return = $upload_dir['basedir'] . '/wds-logs';
            return $return;
        }
        
        /**
         * Vytiskne log ze souboru do admina wordpressu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function get_print_log() {
            $type = isset($_GET['tab']) ? $_GET['tab'] : 'default';
            switch ($type) {
                case 'log2':
                    $log = new wedesinLogiDoklad;
                    break;
                case 'log3':
                    $log = new wedesinLogPayments;
                    break;          
                default:
                    $log = new wedesinLog;
                    break;
            }
            $file = $log->LogFile;
            if ($file) {
                $current = file_get_contents($file);
                if ($current){
                    include_once( 'templates/table-header.php' );
                    include_once( 'templates/log-table.php' );
                    include_once( 'templates/table-footer.php' );
                }
            }
        }

        public function add_tab( ) {
            echo "sem tu";
        }

    }

	new wedesinLogSettings;

}
