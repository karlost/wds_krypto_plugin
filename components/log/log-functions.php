<?php 

if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

if( ! class_exists( 'wedesinLog' ) )

{

	class wedesinLog

	{
    
    public $LogFile;
		//hook functions

		public function __construct()
		{
      $this->LogFile = $this->get_log_dir() .'/'. WDS_ID . '/' . WDS_ID .'.log';
    }

    /**
     * Zapíše zprávu do logu
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function add_log($event, $message, $postID="", $userID="", $note="" ) { 

        if(is_array($message) || is_object($message )) {
            $message = json_encode($message); 
        } 
        $file = fopen( $this->LogFile,"a");
        $date = date('Y-m-d H:i:s');
        if (empty($postID)) $postID = '-';
        if (empty($userID)) $userID = '-';
        if (empty($note)) $note = '-';

        fwrite($file, $date . " | " . $event . " | " . $message . " | " . $postID. " | " .$userID. " | " .$note . "\n". ' || '); 
        fclose($file);
    }
    /**
     * Vrátí složku pro log
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function get_log_dir() { 
        /*$settings = new wedesinLogSettings;
        return $settings->get_wds_log_folder();*/
    }

    /**
     * Výpis logu do admina 
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function the_log_excerpt_admin() { 
      if($this->is_log_file_exists()) {
        include_once( 'templates/view-log.php' );
      }
    }

    /**
     * Zkontroluje, jestli existuje soubor s logem
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function is_log_file_exists() { 
      /*$settings = new wedesinLogSettings;
      return file_exists($this->LogFile);*/
    }

    /****************************************************************************************
     *                                                                                      *
     * USER LOG SECTION                                                                     *
     *                                                                                      *
     ***************************************************************************************/

    /**
     * Vrátí složku pro log uživatelů
     *
     * @param none
     * 
     * @author Wedesin
     * @return folder address
     */ 
    public function get_user_log_dir() { 
      /*$settings = new wedesinLogSettings;
      $log = $settings->get_wds_log_folder();
      $userLog = $log . '/'.WDS_ID;
      return $userLog;*/
    }


    /**
     * Vrátí adresu souboru uživatele
     *
     * @param none
     * 
     * @author Wedesin
     * @return log address
     */
    public function get_user_log_file($userID="") {
      if( empty($userID)) $userID = get_current_user_id();
      $folder = $this->get_user_log_dir();
      $file_name = $this->get_file_name_user($userID);
      if ($folder && $file_name)
        return $folder .'/'. $file_name;

    }
    /**
     * Vrátí jméno souboru uživatele
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */
    public function get_file_name_user($userID) {
      $user = get_userdata($userID);
      $mail = $user->user_email;
      if ($mail && $userID)
        $filename = $mail . '_'. $userID. '_log.log';
      if($filename)  
        return $filename;
    }
    /**
    * Zapíše zprávu do logu uživatele
    *
    * @param $courseID = ID kurzu
    * @param  $lessonID = ID lekce
    * @param  $taskUniqueID = Unikátní ID v opakovači úkolů
    * @param  $value = nová hodnota
    * @param  $action = ukládání úkolů [task_save] / ukládání poznámky [note] / uzavření úkolu [task_done]
    * 
    * @author Wedesin
    * @return true/false
    */ 
    public function add_user_log($userID, $courseID, $lessonID, $taskUniqueID, $action, $value, $note="" ) { 

      if(is_array($value) || is_object($value )) {
          $value = json_encode($value); 
      } 
      $file = fopen( $this->get_user_log_file($userID),"a");
      $date = date('Y-m-d H:i:s');
      if (empty($note)) $note = '-';
      fwrite($file, $date . " | " . $action . " | " . $courseID .'/'. $lessonID .' - '. get_the_title($lessonID). " | " . $taskUniqueID . " | " . $value. " | " .$note . "\n");
      fclose($file);
    }
    
  }

	new wedesinLog;

}
?>