<?php
namespace ticker\admin\submenu\content;
if (!defined('ABSPATH')) {

    exit;
}

if (!class_exists('submenuContentWDS')) {
    class submenuContentWDS
    {
        //hook functions
        public function __construct()
        {
       
add_action( 'form_fields.php', 'save_data' );
        }

        /**
         * Zobrazení testovacího formuláře
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */
        function form_page_contents()
        {

            $builder = new formsBuilderWDS();
            //$builder = new formsBuilderWDS("test_form_mini");

            //$builder->display_form("test_form_mini");
            //$builder->display_form("test_form_mini_2");
            $builder->display_form("test_form_all");
        }

        /**
         * Zobrazení ukázkového formuláře
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */


          function save_data(){ 
              echo '<div class="notice notice-success wds-notice is-dismissible">
                    <p>Nastavení bylo uloženo.(krypto)</p>
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Skrýt toto upozornění.</span></button>
                    </div>';
              
          }
        function my_admin_page_contents()
        {   

            //Získat aktivní tab z parametru $_GET 
            $default_tab = null;
            $builder = new \formsBuilderWDS();
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab; ?>
            <div class="wrap wds-admin">

                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <?php settings_errors(); ?>
              
                <div class="row">
                    <div class="column content">
                        <nav class="nav-tab-wrapper">
                            <a href="?page=krypto" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>"> <?php echo file_get_contents(TM_URLKRYPTO . "assets/icons/home-line.svg"); ?> Default Tab</a>
                            <a href="?page=krypto&tab=settings" class="nav-tab <?php if ($tab === 'settings') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(TM_URLKRYPTO . "assets/icons/slider-line.svg"); ?>Settings</a>
                            <a href="?page=krypto&tab=tools" class="nav-tab <?php if ($tab === 'tools') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(TM_URLKRYPTO . "assets/icons/settings-line.svg"); ?>Tools</a>
                            <?php
                                $mailingForm = $builder->get_fields_form("emails_settings");
                            if (!empty($mailingForm)){
                                ?>
                                <a href="?page=krypto&tab=emails" class="nav-tab <?php if ($tab === 'emails') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(TM_URLKRYPTO . "assets/icons/link-line.svg"); ?>Emaily</a>
                                <?php 
                            } ?>
                        </nav>
                        <div class="content-box">
                            <?php switch ($tab):
                                    // Default tab
                                default:
                            ?>
                                    <h2>Zobrazeni všeho o nastaveném kryptu</h2>
                                    <hr>
                            <?php echo \ticker\admin\api\view\info_krypto();
                                    break;

                                    //Tab 2
                                case 'settings':
                                    $builder->display_form("test_form_mini");

                                    break;

                                    //Tab 3
                                case 'tools':
                                ?>
                                    Tools tab content
                            <?php
                                    break;
                                case 'emails':
                                    if (!empty($mailingForm)){
                                        $builder->display_form("emails_settings");
                                    }
                                    break;

                            endswitch; ?>
                        </div>
                    </div>
                    <div class="column sidebar">
                    
                    <?php 
                    $zobrazeni = new \ticker\admin\info_box\view\viewAdminBoxWDS;
                    $zobrazeni->wedesin_dashboard_widget_display('pluginsnews');
                   // use ticker\admin\api\viewAdminBoxWDS;
                   $coin = get_option('_wds_krypto_test_form_mini_krypto');
                   $fiat = get_option('_wds_krypto_test_form_mini_fiat');
			
                    $zobrazeni1 = new \ticker\admin\api\view\viewAdminBoxWDS;
                    $zobrazeni1->wedesin_dashboard_widget_display($fiat , $coin);
                    
                    ?>
                
                 
                        <?php   
                        $zobrazeni->wedesin_dashboard_widget_display('plugins');
                        ?>
                        <h3><?php echo file_get_contents(WDS_BRANDURL . "assets/icons/info-standard-line.svg"); ?>
                    
            
                    </div>
                </div>
            </div>
<?php
        }
    }
   new \ticker\admin\submenu\content\submenuContentWDS;
}