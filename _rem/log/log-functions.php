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

      $settings = new wedesinLogSettings;
      $this->LogFile = $settings->get_log_dir() .'/'. WDS_IDSEC . '/' . WDS_IDSEC .'.log';

      //testování
      add_action( 'init',  [$this, 'test__log'] );
      add_action( 'init',  [$this, 'test__user_log'] );

    }



    /**
     * Zapíše zprávu do logu
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
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

    /**
     * Zapíše zprávu do logu
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
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
      $settings = new wedesinLogSettings;
      $log = $settings->get_wds_log_folder();
      $userLog = $log . '/'.WDS_IDSEC;
      return $userLog;
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
