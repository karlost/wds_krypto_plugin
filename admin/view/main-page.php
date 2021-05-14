<?php

if (!defined('ABSPATH')) {

    exit;
}

if (!class_exists('PluginNameMainPageWDS')) {
    class PluginNameMainPageWDS

    {
        //hook functions

        public function __construct()
        {
            add_action('admin_menu',  [$this, 'admin_main_page_wds']);
        }

        /**
         * Přidává stránku nastavení wedesin pluginů do adminu
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */
        public function admin_main_page_wds()
        {
            if (isset($GLOBALS['admin_page_hooks']['wds-plugins']) || !empty($GLOBALS['admin_page_hooks']['wds-plugins'])) {
                add_submenu_page(
                    'wds-plugins',
                    'vyvoj',
                    'vyvoj',
                    'manage_options',
                    'wds_vyvoj_slug',
                    array($this, 'my_admin_page_contents'),
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
        function my_admin_page_contents()
        {

            //Získat aktivní tab z parametru $_GET 
            $default_tab = null;
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

?>
            <div class="wrap wds-admin">

                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <?php settings_errors(); ?>
                <div class="row">
                    <div class="column content">
                        <nav class="nav-tab-wrapper">
                            <a href="?page=wds_vyvoj_slug" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>"> <?php echo file_get_contents(WDS_URL . "assets/icons/home-line.svg"); ?> Default Tab</a>
                            <a href="?page=wds_vyvoj_slug&tab=settings" class="nav-tab <?php if ($tab === 'settings') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(WDS_URL . "assets/icons/slider-line.svg"); ?>Settings</a>
                            <a href="?page=wds_vyvoj_slug&tab=tools" class="nav-tab <?php if ($tab === 'tools') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(WDS_URL . "assets/icons/settings-line.svg"); ?>Tools</a>
                        </nav>
                        <div class="tab-content">
                            <?php switch ($tab):
                                    // Default tab
                                default:
                            ?>
                                    <h2>Nastavení pluginu</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                                    <hr>
                                    <form action="">
                                        <div class="form-section">
                                            <div class="row xl">
                                                <div class="column">

                                                    <div class="form-item">
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                            <h3>Jednoduchý switch s popiskem</h3>
                                                        </label>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                                                    </div>

                                                </div>
                                                <div class="column">

                                                    <div class="form-item">
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                            <h3>Jednoduchý switch s popiskem</h3>
                                                        </label>
                                                        <p>
                                                            <span class="floating-label">
                                                                <input type="text" name="text" id="text" placeholder="Lorem ipsum">
                                                                <label for="text" class="">Lorem ipsum</label>
                                                            </span>
                                                        </p>
                                                        <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <div class="row xl">

                                                <div class="column">

                                                    <div class="form-item">
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                            <h3>Jednoduchý switch s popiskem</h3>
                                                        </label>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                                                        <p>
                                                            <span class="floating-label">
                                                                <input type="text" name="text" id="text" placeholder="Lorem ipsum">
                                                                <label for="text" class="">Lorem ipsum</label>
                                                            </span>
                                                        </p>

                                                        <p>
                                                        <div class="floating-label">

                                                            <div class="wds-select">
                                                                <select>
                                                                    <option value="0">Lorem ipsum</option>
                                                                    <option value="1">Audi</option>
                                                                    <option value="2">BMW</option>
                                                                    <option value="3">Citroen</option>
                                                                    <option value="4">Ford</option>
                                                                    <option value="5">Honda</option>
                                                                    <option value="6">Jaguar</option>
                                                                    <option value="7">Land Rover</option>
                                                                    <option value="8">Mercedes</option>
                                                                    <option value="9">Mini</option>
                                                                    <option value="10">Nissan</option>
                                                                    <option value="11">Toyota</option>
                                                                    <option value="12">Volvo</option>
                                                                </select>
                                                            </div>
                                                            <label for="wds-select" class="">Lorem ipsum</label>

                                                        </div>
                                                        </p>

                                                        <p>
                                                            <span class="floating-label">
                                                                <textarea id="textarea" name="textarea" rows="4" cols="50" placeholder="Lorem ipsum"></textarea>
                                                                <label for="textarea" class="">Lorem ipsum</label>
                                                            </span>
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="column">
                                                    <div class="form-item">
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                            <h3>Jednoduchý switch s popiskem</h3>
                                                        </label>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                                                    </div>
                                                    <div class="form-item">
                                                        <label class="radio radio-large">
                                                            <h3>One</h3>
                                                            <input type="radio" checked="checked" name="radio">
                                                            <span class="checkmark"></span>
                                                            <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                        </label>
                                                    </div>
                                                    <div class="form-item">
                                                        <label class="radio radio-large">
                                                            <h3>Two</h3>
                                                            <input type="radio" name="radio">
                                                            <span class="checkmark"></span>
                                                            <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                        </label>
                                                    </div>
                                                    <div class="form-item">
                                                        <label class="radio radio-large">
                                                            <h3>Three</h3>
                                                            <input type="radio" name="radio">
                                                            <span class="checkmark"></span>
                                                            <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                        </label>
                                                    </div>
                                                    <div class="form-item">
                                                        <label class="radio radio-large">
                                                            <h3>Four</h3>
                                                            <input type="radio" name="radio">
                                                            <span class="checkmark"></span>
                                                            <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-section">

                                            <div class="form-item">
                                                <label class="checkbox checkbox-large">
                                                    <h3>One</h3>
                                                    <input type="checkbox" checked="checked">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>

                                                    <div class="input-group">
                                                        <span class="input-group-label"><?php echo file_get_contents(WDS_URL . "assets/icons/link-line.svg"); ?></span>
                                                        <span class="floating-label">
                                                            <input type="url" name="url" id="url" placeholder="Lorem ipsum">
                                                            <label for="url" class="">Lorem ipsum</label>
                                                        </span>

                                                    </div>

                                                <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

                                                <p>
                                                    <label class="checkbox">One
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </p>
                                                <p>
                                                    <label class="checkbox">Two
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </p>
                                            </div>

                                        </div>

                                        <div class="form-section">

                                            <div class="form-item">
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                    <h3>Jednoduchý switch s popiskem</h3>
                                                </label>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>


                                                <div class="input-group">
                                                    <span class="input-group-label"><?php echo file_get_contents(WDS_URL . "assets/icons/link-line.svg"); ?></span>
                                                    <span class="floating-label">
                                                        <input type="url" name="image_path" id="image_path" placeholder="Lorem ipsum">
                                                        <label for="url" class="">Lorem ipsum</label>
                                                    </span>
                                                    <a href="#" class="button"><?php echo file_get_contents(WDS_URL . "assets/icons/upload-cloud-line.svg"); ?> Nahrát</a>

                                                </div>

                                                <p>
                                                <div class=upload-img-preview>
                                                    <img src="https://via.placeholder.com/300x200" width="300" height="200" alt="placeholder image">
                                                    <a href="#" class="button white icon"><?php echo file_get_contents(WDS_URL . "assets/icons/trash-line.svg"); ?> Odstranit</a>
                                                </div>
                            </p>
                                            </div>

                                        </div>

                                        <div class="form-section">

                                            <div class="form-item">
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                    <h3>Jednoduchý switch s popiskem</h3>
                                                </label>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>


                                                <div class="input-group">
                                                    <span class="input-group-label"><?php echo file_get_contents(WDS_URL . "assets/icons/calendar-line.svg"); ?></span>
                                                    <span class="floating-label">
                                                        <input type="date" name="date" id="date" placeholder="Lorem ipsum">
                                                        <label for="date" class="">Lorem ipsum</label>
                                                    </span>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-section">
                                            <div class="form-item">
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                    <h3>Jednoduchý switch s popiskem</h3>
                                                </label>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                                <p>
                                                <label class="radio">One
                                                    <input type="radio" checked="checked" name="radio2">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio">Two
                                                    <input type="radio" name="radio2">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio">Three
                                                    <input type="radio" name="radio2">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio">Four
                                                    <input type="radio" name="radio2">
                                                    <span class="checkmark"></span>
                                                </label>
                            </p>
                                            </div>
                                        </div>

                                        <?php submit_button(); ?>

                                    </form>
                                <?php
                                    break;

                                    //Tab 2
                                case 'settings':
                                ?>
                                    Settings tab content
                                <?php
                                    break;

                                    //Tab 3
                                case 'tools':
                                ?>
                                    Tools tab content
                            <?php
                                    break;

                            endswitch; ?>
                        </div>
                    </div>
                    <div class="column sidebar">
                        <div class="card">
                            <p><img src="<?php echo WDS_URL ?>assets/img/Logo-Wedesin-CZ.png" alt=""></p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                            <p><a href="#" class="button">tlačítko</a></p>
                        </div>
                        <div class="card info">
                            <h3><?php echo file_get_contents(WDS_URL . "assets/icons/info-standard-line.svg"); ?>Info blok</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
    new PluginNameMainPageWDS;
}

?>