<?php 

namespace components\log;

if ( ! defined( 'ABSPATH' ) ) {

  exit;

}

class wedesinLogSettings
{
    public $LogFile;

    //konstruktor
    public function __construct()
    {
        
        $this->LogFile = $this->get_log_dir() .'/'. WDS_ID . '/' . WDS_ID .'.log';

        //spuštní
        add_action('wds_plugin_log_tab_content', [$this, 'add_tab'] );
        add_action('wds_plugin_log_header_content', [$this, 'add_header'] );

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
        return $this->get_wds_log_folder();
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
            default:
                $log = new wedesinLog;
                break;
        }
        $file = $log->LogFile;
        if ($file) {
            $current = file_get_contents($file);
            if ($current){
                include_once( 'views/table-header.php' );
                include_once( 'views/log-table.php' );
                include_once( 'views/table-footer.php' );
            }
        }
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
        <a href="?page=wds-logs" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">
            <?= WDS_ID ?>
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
        $this->the_log_excerpt_admin();
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
        return file_exists($this->LogFile);
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
            include_once( 'views/view-log.php' );
        }
    }
}