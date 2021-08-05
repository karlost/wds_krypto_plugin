<?php 
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if( ! class_exists( 'wedesinLog' ) )

{

	class wedesinLog

	{
		//hook functions
		public function __construct()
		{

    }

    /**
     * Zapíše zprávu do logu
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function add_log($file, $event, $message, $note="" ) { 
        $settings = new logSetupWDS;
        $folder = $settings->get_wds_log_folder();
        $filename = $folder . '/'. $file . '.log';
        if(is_array($message) || is_object($message )) {
            $message = json_encode($message); 
        } 
        $file = fopen( $filename,"a");
        $date = date('Y-m-d H:i:s');
        if (empty($note)) $note = '-';

        fwrite($file, $date . " | " . $event . " | " . $message . " | " .$note . "\n". ' || '); 
        fclose($file);
    }

    /**
     * Vytiskne log ze souboru do admina wordpressu
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function get_print_log($file) {
      $type = isset($_GET['tab']) ? $_GET['tab'] : 'default';
      $settings = new logSetupWDS;
      $folder = $settings->get_wds_log_folder();
      $filename = $folder . '/'. $file . '.log';
      if ($filename) {
          $current = file_get_contents($file);
          if ($current){
              include_once( 'views/table-header.php' );
              include_once( 'views/log-table.php' );
              include_once( 'views/table-footer.php' );
          }
      }
  }  
  }

	new wedesinLog;

}
