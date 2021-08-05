<?php 
namespace pluginslug\log;
if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

class wedesinLogSettings
{
    public $LogFile;

    //konstruktor
    public function __construct()
    {
        //spuštní
        add_action('admin_init', [$this, 'get_log_file'] );
        add_action('wds_plugin_log_tab_content', [$this, 'add_tab'] );
        add_action('wds_plugin_log_header_content', [$this, 'add_header'] );
        add_action( 'init',  [$this, 'test__log'] );

    }
    /**
     * Funkce zapíše log do souboru pro tento plugin
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function add_log($event, $message, $note="") {
        $log = new \wedesinLog;
        $file = $this->get_plugin_folder_name();
        $log->add_log( $file, $event, $message, $note);
    }

    /**
     * Zapíše zprávu do logu TEST
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function test__log() {
        if ( isset($_GET['test_log']) && $_GET['test_log'] == 2  ) {
          $this->add_log(     
              'ahoj',
              'testuji si tu uložení',
              'blabla'
          );
  
          die('tu');
        }
    }

    public function get_log_file($file="") {
        $settings= new \logSetupWDS;
        if (empty($file)) $file = $this->get_plugin_folder_name();
        $this->LogFile = $settings->get_wds_log_folder() .'/'.$file.'.log';
    }
    public function the_log_file($file="") {
        $settings= new \logSetupWDS;
        if (empty($file)) $file = $this->get_plugin_folder_name();
        return $this->LogFile = $settings->get_wds_log_folder() .'/'.$file.'.log';
    }

    public function get_plugin_folder_name(){
        $filename = "";
        $basename = plugin_basename( __FILE__ ); 
        if ($basename) {
            $name = explode('/',$basename);
            $filename = $name[0];
        }
        return $filename;
    }

    /**
     * Přidá záložku logu pro tento plugin
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function add_header( ) { 
        $default_tab = null;
        $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
        ?>
        <a href="?page=wds-logs&tab=<?= $this->get_plugin_folder_name() ?>" class="nav-tab <?= ($tab===$this->get_plugin_folder_name() ? 'nav-tab-active' : '')?>">
            <?= $this->get_plugin_folder_name() ?>
        </a>
    <?php }

    /**
     * Přidá záložku logu pro tento plugin
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function add_tab( ) {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : '';
        $file = $this->LogFile;
        if ($tab) $file = $tab;
        $this->the_log_excerpt_admin($file);
    }

    /**
     * Zkontroluje, jestli existuje soubor s logem
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function is_log_file_exists($file="") { 
        $fileLog = $this->LogFile;
        if ($file) $fileLog = $this->the_log_file($file);
        return file_exists($fileLog);
    }

    /**
     * Výpis logu do admina 
     *
     * @param none
     * 
     * @author Wedesin
     * @return true/false
     */ 
    public function the_log_excerpt_admin($file="") { 
        $fileLog = $this->LogFile;
        if ($file) $fileLog = $this->the_log_file($file);
        if($this->is_log_file_exists($file)) {
            $viewfile = $fileLog;
            include_once( WDS_PATH. 'admin/framework/log/views/view-log.php' );
        }
    }
}
new wedesinLogSettings;