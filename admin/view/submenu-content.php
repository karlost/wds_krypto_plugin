<?php

if (!defined('ABSPATH')) {

    exit;
}


if (!class_exists('submenuContentWDS')) {
    class submenuContentWDS extends subMenuWDS
    {
        //hook functions
        public function __construct()
        {
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

            $fields = [
                [
                    'headline' => 'Nadis formuláře',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    [
                        'type' => 'hidden',
                        'name' => 'currenturl',
                        'saveAs' => 'meta',
                        'required' => false,
                        'value' => get_permalink()
                    ],
                    [
                        'type' => 'info_box',
                        'name' => 'info_box',
                        'headline' => 'Info box',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
                    ],
                ],
                [
                    [
                        'type' => 'switch',
                        'name' => 'switch1',
                        'label' => 'Checkbox as switch',
                        'saveAs' => 'post_title',
                        'required' => true,
                    ],
                    'columns' => [
                        [

                            [
                                'type' => 'text',
                                'name' => 'title',
                                'label' => 'Jméno',
                                'floating_label' => true,
                                'saveAs' => 'post_title',
                                'required' => true,
                            ],
                            [
                                'type' => 'text',
                                'name' => 'title',
                                'label' => 'Jméno',
                                'floating_label' => true,
                                'saveAs' => 'post_title',
                                'required' => true,
                            ],
                        ],
                        [
                            [
                                'type' => 'text',
                                'name' => 'title',
                                'label' => 'Jméno',
                                'floating_label' => true,
                                'saveAs' => 'post_title',
                                'required' => true,
                            ],
                        ],
                    ],
                    [
                        'type' => 'info_box',
                        'name' => 'info_box',
                        'headline' => 'Info box',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
                    ],
                ],
                [
                    [
                        'type' => 'text',
                        'name' => 'title',
                        'label' => 'Jméno',
                        'placeholder' => 'Vaše jméno',
                        'help_text' => 'Definovaný placeholder jiný než label',
                        'floating_label' => true,
                        'saveAs' => 'post_title',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'title',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        'label' => 'Jméno',
                        'help_text' => 'Placeholder není definovaný (placeholder = label)',
                        'floating_label' => true,
                        'saveAs' => 'post_title',
                        'required' => true,
                    ],
                    [
                        'type' => 'warning_box',
                        'name' => 'warning_box',
                        'headline' => 'Warning box',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.',
                    ],

                ],
                [
                    [
                        'type' => 'checkbox_large',
                        'name' => 'checkbox_large1',
                        'label' => 'Checkbox large',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        'saveAs' => 'post_title',
                    ],
                    [
                        'type' => 'checkbox',
                        'name' => 'checkbox1',
                        'label' => 'Checkbox Lorem ipsum dolor sit amet',
                        'saveAs' => 'post_title',
                    ],
                    [
                        'type' => 'checkbox',
                        'name' => 'checkbox2',
                        'label' => 'Checkbox Lorem ipsum dolor sit amet',
                        'saveAs' => 'post_title',
                        'required' => true,
                    ],
                ],
                [
                    [
                        'type' => 'radio_large',
                        'name' => 'radio_large1',
                        'saveAs' => 'post_title',
                        'options' => [
                            'label' => 'Checkbox large',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    
                        ],
                    ],
                    [
                        'type' => 'radio',
                        'name' => 'radio1',
                        'label' => 'Checkbox Lorem ipsum dolor sit amet',
                        'saveAs' => 'post_title',
                    ],
                ],
                /*[
					'type' => 'hidden',
					'name' => 'currenturl', 
					'saveAs' => 'meta',
					'required' => false,
					'value' => get_permalink()
				],
				[
					'type' => 'text',
					'name' => 'title', 
					'label' => 'Jméno',
					'saveAs' => 'post_title',
					'required' => true,
				],
				[
					'type' => 'text',
					'name' => '_company', 
					'label' => 'Společnost',
					'saveAs' => 'meta',
					'required' => false,
				],
				[
					'type' => 'text',
					'name' => 'name', 
					'label' => 'Jméno',
					'saveAs' => 'meta',
					'required' => false
				],
				[
					'type' => 'text',
					'name' => 'surname', 
					'label' => 'Příjmení',
					'saveAs' => 'meta',
					'required' => false
				],
				[
					'type' => 'email',
					'name' => 'email', 
					'label' => 'Email',
					'saveAs' => 'meta',
					'required' => true,
				],
				[
					'type' => 'text',
					'name' => 'phone_number', 
					'label' => 'Telefon',
					'saveAs' => 'meta',
					'required' => false,
				]*/

            ];

            $builder = new formsBuilderWDS($fields);

            $builder->display_form($fields);
        }

        /**
         * Zobrazení ukázkového formuláře
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
            $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab; ?>
            <div class="wrap wds-admin">

                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <?php settings_errors(); ?>

                <div class="notice notice-info wds-notice is-dismissible">
                    <a href="#" class="button right">tlačítko</a>
                    <h3>Info blok</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Skrýt toto upozornění.</span></button>
                </div>

                <div class="notice notice-warning wds-notice">
                    <a href="#" class="button right center">tlačítko</a>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit.</p>
                </div>

                <div class="notice notice-success wds-notice is-dismissible">
                    <p>Nastavení bylo uloženo.</p>
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Skrýt toto upozornění.</span></button>
                </div>

                <div class="notice notice-error wds-notice is-dismissible">
                    <p>Nastavení se nepodařilo uložit. Zkontrolujte správnost vyplnění následujících položek:</p>
                    <ul>
                        <li>položka 1</li>
                        <li>položka 2</li>
                        <li>položka 3</li>
                    </ul>
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Skrýt toto upozornění.</span></button>
                </div>

                <div class="row">
                    <div class="column content">
                        <nav class="nav-tab-wrapper">
                            <a href="?page=wds_vyvoj_slug" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>"> <?php echo file_get_contents(WDS_URL . "assets/icons/home-line.svg"); ?> Default Tab</a>
                            <a href="?page=wds_vyvoj_slug&tab=settings" class="nav-tab <?php if ($tab === 'settings') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(WDS_URL . "assets/icons/slider-line.svg"); ?>Settings</a>
                            <a href="?page=wds_vyvoj_slug&tab=tools" class="nav-tab <?php if ($tab === 'tools') : ?>nav-tab-active<?php endif; ?>"><?php echo file_get_contents(WDS_URL . "assets/icons/settings-line.svg"); ?>Tools</a>
                        </nav>
                        <div class="content-box">
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
                                                            <select id="select-state1">
                                                                <option value="">None</option>
                                                                <option value="AL">Alabama</option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="AZ">Arizona</option>
                                                                <option value="AR">Arkansas</option>
                                                                <option value="CA">California</option>
                                                                <option value="CO">Colorado</option>
                                                                <option value="CT">Connecticut</option>
                                                                <option value="DE">Delaware</option>
                                                                <option value="DC">District of Columbia</option>
                                                                <option value="FL">Florida</option>
                                                                <option value="GA">Georgia</option>
                                                                <option value="HI">Hawaii</option>
                                                                <option value="ID">Idaho</option>
                                                                <option value="IL">Illinois</option>
                                                                <option value="IN">Indiana</option>
                                                            </select>

                                                            <label for="select-state1" class="">Default select</label>

                                                        </div>
                                                        </p>

                                                        <p>
                                                        <div class="floating-label">
                                                            <select id="select-state" name="select-state" class="selectize" placeholder="Selectize">
                                                                <option value="">None</option>
                                                                <option value="AL">Alabama</option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="AZ">Arizona</option>
                                                                <option value="AR">Arkansas</option>
                                                                <option value="CA">California</option>
                                                                <option value="CO">Colorado</option>
                                                                <option value="CT">Connecticut</option>
                                                                <option value="DE">Delaware</option>
                                                                <option value="DC">District of Columbia</option>
                                                                <option value="FL">Florida</option>
                                                                <option value="GA">Georgia</option>
                                                                <option value="HI">Hawaii</option>
                                                                <option value="ID">Idaho</option>
                                                                <option value="IL">Illinois</option>
                                                                <option value="IN">Indiana</option>
                                                            </select>

                                                            <label for="select-state" class="">Selectize</label>

                                                        </div>
                                                        </p>
                                                        <p>
                                                        <div class="floating-label">
                                                            <select id="select-multi" name="select-multi" multiple="multiple" class="selectize" placeholder="Selectize multiple">
                                                                <option value="">None</option>
                                                                <option value="AL">Alabama</option>
                                                                <option value="AK">Alaska</option>
                                                                <option value="AZ">Arizona</option>
                                                                <option value="AR">Arkansas</option>
                                                                <option value="CA">California</option>
                                                                <option value="CO">Colorado</option>
                                                                <option value="CT">Connecticut</option>
                                                                <option value="DE">Delaware</option>
                                                                <option value="DC">District of Columbia</option>
                                                                <option value="FL">Florida</option>
                                                                <option value="GA">Georgia</option>
                                                                <option value="HI">Hawaii</option>
                                                                <option value="ID">Idaho</option>
                                                                <option value="IL">Illinois</option>
                                                                <option value="IN">Indiana</option>
                                                            </select>

                                                            <label for="select-multi" class="">Selectize multiple</label>

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
                                            <div class="row xl">
                                                <div class="column">

                                                    <div class="form-item">
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                            <h3>Jednoduchý switch s popiskem</h3>
                                                        </label>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac dictumst phasellus nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>

                                                        <div class="range-wrap val-right">
                                                            <input name="example" type="range" class="range" max="100" min="0" value="45">
                                                            <input class="outval small" type="number" max="100" min="0" value="45" source="[name=example]">
                                                        </div>
                                                        <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

                                                    </div>

                                                </div>
                                                <div class="column">

                                                    <div class="form-item">
                                                        <div class="range-wrap val-right-large">
                                                            <input name="example2" type="range" class="range" max="5000" min="0" value="1240">
                                                            <div class="input-group">
                                                                <input class="outval small" type="number" max="5000" min="0" value="1240" source="[name=example2]">
                                                                <span class="input-group-label">px</span>
                                                            </div>
                                                        </div>
                                                        <p class="help-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

                                                    </div>
                                                    <div class="form-item">
                                                        <div class="range-wrap val-right-large">
                                                            <input name="example3" type="range" class="range" max="100" min="0" value="63">
                                                            <div class="input-group">
                                                                <input class="outval small" type="number" max="100" min="0" value="63" source="[name=example3]">
                                                                <div class="select-button small">
                                                                    <select>
                                                                        <option value="1">px</option>
                                                                        <option value="2">%</option>
                                                                        <option value="3">rem</option>
                                                                        <option value="4">em</option>
                                                                        <option value="5">vh</option>
                                                                        <option value="6">vw</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-item">
                                                        <div class="range-wrap val-right">
                                                            <input name="example4" type="range" class="range" max="20" min="0" value="3">
                                                            <select class="outval small" source="[name=example4]">
                                                                <option value="0">0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                            </select>
                                                        </div>

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
                                            <div class="form-item">
                                                <div class="info-block">
                                                    <span class="icon"><?php echo file_get_contents(WDS_URL . "assets/icons/info-standard-line.svg"); ?></span>
                                                    <h3>Info blok</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
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

                                            <div class="form-item">
                                                <div class="info-block warning">
                                                    <span class="icon"><?php echo file_get_contents(WDS_URL . "assets/icons/warning-standard-line.svg"); ?></span>
                                                    <h3>Info blok warning</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Senectus libero ut lorem ac <a href="#">dictumst phasellus</a> nunc sit. Eu nisi sed viverra id aliquam enim, odio nunc.</p>
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
                                                    <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="#a5c83c" name="plugin_settings[color]" value="" />
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

                                        <div class="form-section">
                                            <div class="form-item">
                                                <table>
                                                    <tr>
                                                        <th>Company</th>
                                                        <th>Contact</th>
                                                        <th>Country</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Alfreds Futterkiste</td>
                                                        <td>Maria Anders</td>
                                                        <td>Germany</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Centro comercial Moctezuma</td>
                                                        <td>Francisco Chang</td>
                                                        <td>Mexico</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ernst Handel</td>
                                                        <td>Roland Mendel</td>
                                                        <td>Austria</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Island Trading</td>
                                                        <td>Helen Bennett</td>
                                                        <td>UK</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Laughing Bacchus Winecellars</td>
                                                        <td>Yoshi Tannamuri</td>
                                                        <td>Canada</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Magazzini Alimentari Riuniti</td>
                                                        <td>Giovanni Rovelli</td>
                                                        <td>Italy</td>
                                                    </tr>
                                                </table>
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

    new submenuContentWDS;
}
