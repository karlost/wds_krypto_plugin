<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WDS_Front_Form')) {
    class WDS_Front_Form
    {

        private $fields;
        private $session;

        public function __construct($field_list = [])
        {
            $this->fields = $field_list;

            add_action('wp_ajax_wds_frontend_form_dropzone_handle_dropped_files', [$this, 'handle_dropped_files_callback'], 10, 1);
            add_action('wp_ajax_nopriv_wds_frontend_form_dropzone_handle_dropped_files', [$this, 'handle_dropped_files_callback'], 10, 1);

            add_action('wp_ajax_wds_frontend_form_dropzone_handle_deleted_files', [$this, 'handle_deleted_files_callback'], 10, 1);
            add_action('wp_ajax_nopriv_wds_frontend_form_dropzone_handle_deleted_files', [$this, 'handle_deleted_files_callback'], 10, 1);

            add_action('wp_ajax_wds_frontend_form_dropzone_get_files', [$this, 'get_files_callback'], 10, 1);
            add_action('wp_ajax_nopriv_wds_frontend_form_dropzone_get_files', [$this, 'get_files_callback'], 10, 1);

            $this->session = new sessionClassWDS;
        }

        private function check_if_fields_has($var)
        {
            if (empty($this->fields)) {
                return false;
            }

            foreach ($this->fields as $index => $field) {
                if ($field['type'] == $var || $field['name'] == $var) {
                    return true;
                }
            }
            return false;
        }

        public function get_form($post_id = 'new', $post_type = 'post', $formID = 'wedesin_frontend')
        {

            global $post;

            $return = "";
            $query = filter_input_array(INPUT_GET);

?>
            <div class="wrap wds-admin">

                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

                <?php settings_errors(); ?>

                <div class="row">
                    <div class="column content">

                        <!-- místo pro taby -->

                        <div class="content-box">

                            <span class="form-star"><small><?= __('* povinné pole', 'textdomain'); ?></small></span>

                            <form method="post" id="<?= $formID ?>_<?= $post_id ?>_form" class="wds-form" action="<?php // the_permalink(); 
                                                                                                                    ?>" enctype="multipart/form-data" novalidate data-abide>

                                <?php $this->get_form_fields($post_id, $post_type, 1, $formID); ?>

                                <?php submit_button(); ?>

                            </form>
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

        private function get_form_field_index($fields, $key)
        {
            return array_keys(array_column($fields, 'saveAs'), $key);
        }

        private function get_form_field_count($fields, $key)
        {
            return count($this->get_form_field_index($fields, $key));
        }

        private function get_form_field_featuredImages_index($fields)
        {
            return array_keys(array_column($fields, 'useAsFeatured'), 1);
        }

        private function get_form_field_featuredImages_count($fields)
        {
            return count($this->get_form_field_featuredImages_index($fields));
        }

        private function get_field_type_from_name($name)
        {
            if (isset($this->fields) && !empty($this->fields)) {
                foreach ($this->fields as $index => $field) {
                    if ($field['name'] == $name) {
                        if (isset($this->fields[$index]['type'])) {
                            return $this->fields[$index]['type'];
                        } else {
                            return false;
                        }
                    }
                }
            }
        }

        public function get_fields($fields, $key)
        {
            $return_fields = [];
            $indexes = $this->get_form_field_index($fields, $key);
            if (is_array($indexes) && !empty($indexes)) {
                foreach ($indexes as $index) {
                    $return_fields[] = $fields[$index];
                }
            }
            return $return_fields;
        }

        public function get_fields_from_post($inputs, $key)
        {
            if (is_array($inputs) && isset($inputs['wds_' . $key])) {
                return $inputs['wds_' . $key];
            }
            return false;
        }

        public function get_field_parameter($name, $parameter)
        {
            if (isset($this->fields) && !empty($this->fields)) {
                foreach ($this->fields as $index => $field) {
                    if ($field['name'] == $name) {
                        if (isset($this->fields[$index][$parameter])) {
                            return $this->fields[$index][$parameter];
                        } else {
                            return false;
                        }
                    }
                }
            }
        }

        /**
         * 	Description
         *
         * 	@param $arg = fce define_arg_form();
         *
         * 	@author Wedesin
         * 	@return echo
         */
        public function get_form_fields($post_id, $post_type = 'post', $formID = null)
        {

            if (empty($this->fields)) {
                die('Fields must be set.');
            }

            /*if ($col == 2) {
                $col1 = 'medium-3 small-12 cell';
                $col2 = 'medium-9 small-12 cell';
            } else {
                $col1 = 'medium-12 small-12 cell';
                $col2 = 'medium-12 small-12 cell';
            }*/

            // get index
            // run some tests, all this under should be only once
            if ($this->get_form_field_count($this->fields, 'post_title') > 1) {
                die('Fields contain more than 1 post_title.');
            }
            if ($this->get_form_field_count($this->fields, 'post_content') > 1) {
                die('Fields contain more than 1 post_content.');
            }
            if ($this->get_form_field_count($this->fields, 'post_excerpt') > 1) {
                die('Fields contain more than 1 post_excerpt.');
            }
            if ($this->get_form_field_featuredImages_count($this->fields) > 1) {
                die('Fields contain more than 1 featured image.');
            }

            /*
            $validation_data = $this->session->getSession( $formID.'_validation' );
            if (isset($validation_data['allvalid']) && !$validation_data['allvalid']) {
                ?>
                <div class="small-12 cell callout alert">
                    <?php _e('Formulář obsahuje chyby.', TM); ?>
                </div>
                <?php
            }*/

            foreach ($this->fields as $section) {

                $section_headline = isset($section['headline']) ? $section['headline'] : false;
                $section_description = isset($section['description']) ? $section['description'] : false;

                //Vše v array fields jsou automaticky sekce formuláře
                echo '<div class="form-section">';

                if ($section_headline) echo '<h2>' . $section_headline . '</h2>';
                if ($section_description) echo '<p>' . $section_description . '</p>';

                if ($section['columns']) {

                    echo '<div class="row xl">';
                    //preprint($section);

                    foreach ($section['columns'] as $column) {

                        //preprint($column);
                        echo '<div class="column">';

                        //Pole formuláře v gridu
                        foreach ($column as $field) {

                            $type = isset($field['type']) ? $field['type'] : false;
                            $name = isset($field['name']) ? $field['name'] : false;

                            if ($name && $type) {

                                $is_valid = true;

                                //nejdřív přidáme skrytá pole
                                if ($type == 'hidden') {

                                    $value = isset($field['value']) ? $field['value'] : '';
                                    $this->get_input_html($type, $name, $value, $field, $is_valid);
                                } else { ?>

                                    <div class="form-item <?php echo $name; ?>">

                                    <?php 
                                    $value = isset($field['value']) ? $field['value'] : '';
                                    $this->get_input_html($type, $name, $value, $field, $is_valid); ?>

                                    </div>

                            <?php
                                }
                            }
                        }

                        echo '</div>';
                    }

                    echo '</div>';
                }

                //Pole formuláře v sekcích
                foreach ($section as $item => $field) {
                    //TODO #1 Přesunout row s columns pod toto foreatch, tak aby se vykreslovalo ve správném pořadí a ne jako první
                    /*if ($section['columns']) {
                        preprint($section['columns']) ;
                    }*/
                    
                    $type = isset($field['type']) ? $field['type'] : false;
                    $name = isset($field['name']) ? $field['name'] : false;

                    if ($name && $type) {

                        $is_valid = true;

                        //nejdřív přidáme skrytá pole
                        if ($type == 'hidden') {

                            $value = isset($field['value']) ? $field['value'] : '';
                            $this->get_input_html($type, $name, $value, $field, $is_valid);
                        } else { ?>

                            <div class="form-item <?php echo $name; ?>">

                                <?php 
                                $value = isset($field['value']) ? $field['value'] : '';
                                $this->get_input_html($type, $name, $value, $field, $is_valid); ?>

                            </div>

<?php
                        }
                    }
                }

                echo '</div>';
            }

            $this->session->removeSession($formID . '_validation');
        }

        /*
        public function get_field_name($name, $saveAs = null, $type = null)
        {

            $name = $type == 'gallery' ? 'gallery_' . $name : $name;

            // switch to get correct input name
            switch ($saveAs) {
                case 'meta':
                    $newName = 'wds_meta[' . $name . ']';
                    break;
                case 'taxonomy':
                    $newName = 'wds_taxonomy[' . $name . ']';
                    break;
                case 'post_title':
                case 'post_content':
                case 'post_excerpt':
                    $newName = $saveAs;
                    break;
                default:
                    $newName = $name;
            }

            return $newName;
        }
        */


        public function get_input_html($type, $name, $value, $args = [], $is_valid = true)
        {

            $multiple = isset($args['multiple']) && $args['multiple'] == true ? 'multiple' : false;
            $atts = isset($args['required']) && $args['required'] == true ? 'required="required"' : '';
            $atts .= $multiple ? ' multiple' : '';
            $class = !$is_valid ? 'callout alert' : '';
            //$name = $this->get_field_name($name, $args['saveAs'], $type);
            $name = isset($args['name']) ? $args['name'] : false;
            $name = $name . ($type == 'checkbox' || ($type == 'image' && $multiple) ? '[]' : '');
            //$limit = isset($args['imagesLimit']) ? $args['imagesLimit'] : '999999';
            $is_required = isset($args['required']) && $args['required'] == true ? true : false;
            $required = $is_required == true ? ' <span class="required form-star">*</span>' : '';
            $label = isset($args['label']) ? $args['label'] : false;
            $placeholder = isset($args['placeholder']) ? $args['placeholder'] : $label;
            $description = isset($args['description']) ? $args['description'] : false;
            $help_text = isset($args['help_text']) ? $args['help_text'] : false;
            $floating_label_start = $label ? '<span class="floating-label">' : '';
            $floating_label_end = $label ? '</span>' : '';

            if ($is_required) {
                $placeholder = $placeholder . ' *';
            }

            switch ($type) {

                /**
                 * Input types
                 * -----------
                 * button           v rámci některých polí
                 * checkbox         OK
                 * checkbox_large   OK
                 * switch           OK
                 * color            OK
                 * date             OK
                 * datetime-local   OK
                 * email            OK
                 * file
                 * hidden           OK
                 * image            OK upravit upload přes WP upload
                 * month            OK
                 * number           OK
                 * password         OK
                 * radio            OK
                 * radio_large      OK
                 * range            OK
                 * reset
                 * search
                 * select           OK doplnit o js
                 * submit           OK - wordpress
                 * tel              OK
                 * text             OK
                 * textarea         OK
                 * editor           OK
                 * time             OK
                 * url              OK
                 * week             OK
                 * info a warning box    OK
                 * custom html
                 */

                case 'email':
                case 'tel':
                case 'number':
                case 'password':
                case 'text':
                case 'hidden':

                    $id_val = str_replace(']', '', str_replace('[', '', $name));

                    if ($description) echo '<p>' . $description . '</p>';

                    if ($type != "hidden" && !$is_valid) {

                        $er_mess = __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain');
                        if ($type == "email") $er_mess = __('Prosíme, zadejte platný email.', 'textdomain');
                        echo '<p class="form-error">' . $er_mess . '</p>';
                    }

                    echo '<p>' . $floating_label_start;

                    echo '<input type="' . $type . '" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" id="' . $id_val . '"/>';
                    if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';

                    echo $floating_label_end . '</p>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    break;

                case 'select':
                    $options = isset($args['options']) ? $args['options'] : [];



                    if (!empty($options)) {

                        if ($description) echo '<p>' . $description . '</p>';

                        if (!$is_valid) {
                            echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                        }

                        echo $floating_label_start;

                        echo '<select name="' . $name . '" ' . $atts . ' class="selectize ' . $class . '" placeholder="' . $placeholder . '" id="' . $name . '">';
                        foreach ($options as $option_key => $option_name) {
                            echo '<option value="' . $option_key . '" ' . ($option_key == $value ? 'selected="selected"' : '') . '>' . $option_name . '</option>';
                        }
                        echo '</select>';

                        if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';

                        echo $floating_label_end;

                        if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                        //todo #3 Selectize.js zprovoznění vloženého scryptu s možnostmi výběru
                        $selectize = isset($args['selectize']) ? $args['selectize'] : [];
                        if (!empty($selectize)) {
                            
                            echo '<script>$("#' . $name . '").selectize({';
                            
                            foreach ($selectize as $selectize_key => $selectize_value) {
                                echo $selectize_key . ': ' . $selectize_value . ',';
                            }

                            echo '});</script>';

                        }

                        
                    }
                    break;

                /*case 'gallery':
                    echo '<div id="media-uploader-' . $name . '" data-target="' . $name . '" data-limit="' . $limit . '" class="dropzone ' . $class . '"></div>';
                    echo '<input type="hidden" name="' . $name . '" value="' . $value . '" ' . $atts . ' />';

                    if (!empty($placeholder)) echo '<p>' . $placeholder . '</p>';

                    
                    tady message sama nevyskočí
                    if ( $is_required ) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') .'</span>';
                    }
                    
                    break;*/

                case 'url':

                    if ($description) echo '<p>' . $description . '</p>';

                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }

                    echo '<div class="input-group">';
                    echo '<span class="input-group-label">' . file_get_contents(WDS_URL . "assets/icons/link-line.svg") . '</span>';
                    echo  $floating_label_start;

                    echo '<input type="url" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" />';

                    if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';

                    echo $floating_label_end ;
                    echo '</div>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    break;

                case 'image':
                    //echo '<div id="media-uploader-' . $name . '" data-target="' . $name . '" data-limit="1" class="dropzone ' . $class . '"></div>';
                    //echo '<input type="hidden" name="' . $name . '" value="' . $value . '" ' . $atts . ' />';
                    //if (!empty($placeholder)) echo '<p>' . $placeholder . '</p>';

                    if ($description) echo '<p>' . $description . '</p>';

                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }
                    
                    echo '<div class="input-group">';
                    echo '<span class="input-group-label">' . file_get_contents(WDS_URL . "assets/icons/link-line.svg") . '</span>';
                    echo  $floating_label_start;

                    echo '<input type="url" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" />';

                    if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';

                    echo $floating_label_end ;

                    echo '<a href="#" class="button">' . file_get_contents(WDS_URL . "assets/icons/upload-cloud-line.svg") . 'Nahrát</a>';


                    echo '</div>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
                    
                    if ($value) {
                        echo '<p><div class=upload-img-preview>';
                        echo '<img src="' . $value . '" width="300" height="200" alt="alt">';
                        echo '<a href="#" class="button white icon">' . file_get_contents(WDS_URL . "assets/icons/trash-line.svg") . 'Odstranit</a>';
                        echo '</div></p>';
                    }

                    break;

                case 'radio':
                case 'radio_large':

                    $options = isset($args['options']) ? $args['options'] : [];

                    if ($type == 'radio_large') {
                        $class = 'radio-large ' . $class;
                    }

                    if (!empty($options)) {

                        if ($description) echo '<p>' . $description . '</p>';

                        if (!$is_valid) {
                            echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                        }

                        echo '<div class="radio-wrap">';

                        //echo '<input type="' . $type . '" value=""  name="' . $name .'" checked class="hide"> ';
                        foreach ($options as $option_key => $option_name) {
                            if ($option_key != '' && $option_name != '') {

                                $checked = $option_key == $value ? 'checked' : '';

                                echo '<label class="radio ' . $class . '">';
                                echo '<input type="radio" value="' . $option_key . '"  name="' . $name . '" ' . $checked . ' ' . $atts . '> ';
                                echo '<span class="checkmark"></span>';

                                if ($type == 'radio_large') echo '<h3>';
                                echo is_array($option_name)?  $option_name[0] :  $option_name ;
                                if ($type == 'radio_large') echo '</h3>';
                                echo is_array($option_name)? '<p class="help-text">' . $option_name[1] . '</p>' : '' ;

                                echo '</label>';
                            }
                        }

                        echo '</div>';

                        if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    }
                    break;

                case 'checkbox':
                case 'checkbox_large':

                    if ($type == 'checkbox_large') {
                        $class = 'checkbox-large ' . $class;
                    }

                    if ($label)  {
                        echo '<label class="checkbox ' . $class . '">';
                        echo '<input type="checkbox" value="' . $name . '"  name="' . $name . '" ' . $checked . ' ' . $atts . '>';
                        echo '<span class="checkmark"></span>';
                        if ($type == 'checkbox_large') echo '<h3>';
                        echo  $label . $required ;
                        if ($type == 'checkbox_large') echo '</h3>';
                        echo '</label>';

                    };

                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }

                    if ($description) echo '<p>' . $description . '</p>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    break;

                case 'switch':

                    if ($label)  {
                        echo '<label class="switch">';
                        echo '<input type="checkbox" value=""  name="' . $name . '" ' . $checked . ' ' . $atts . '>';
                        echo '<span class="slider"></span>';
                        echo '<h3>' . $label . $required . '</h3></label>';
                    };

                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }

                    if ($description) echo '<p>' . $description . '</p>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    break;

                case 'textarea':

                    if ($description) echo '<p>' . $description . '</p>';

                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }

                    echo $floating_label_start;

                    echo '<textarea type="' . $type . '"  name="' . $name . '" placeholder="' . $placeholder . '" ' . $atts . ' class="' . $class . '" />' . $value . '</textarea>';
                    if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';
                    echo $floating_label_end;

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    break;

                case 'range':

                    $max = isset($args['max']) ? 'max="' . $args['max'] . '" ' : '';
                    $min = isset($args['min']) ? 'min="' . $args['min'] . '" ' : '';
                    $step = isset($args['step']) ? 'step="' . $args['step'] . '" ' : '';
                    $show_attr = isset($args['show_attr']) ? $args['show_attr'] : false;
                    $unit = isset($args['unit']) ? $args['unit'] : '';
                    $wrap_class = $unit ? 'val-right-large' : 'val-right';
                    $wrap_class = $show_attr == true ? $wrap_class . ' show-attr' : $wrap_class;

                        if ($label) echo '<p>' . $label . $required . '</p>';
    
                        if (!$is_valid) {
                            echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                        }
    
                        if ($description) echo '<p>' . $description . '</p>';

                        echo '<div class="range-wrap ' . $wrap_class . '">';
                        echo '<input name="' . $name . '" type="range" class="range" ' . $max . $min . $step . ' value="' . $value . '">';
                        if ($unit) echo '<div class="input-group">';
                        echo '<input class="outval small" type="number" ' . $max . $min . $step . ' value="' . $value . '" source="[name=' . $name . ']">';
                        if (is_array($unit)){
                            echo '<div class="select-button small"><select>';
                            foreach ($unit as $unit_key => $unit_name) {
                                echo '<option value="' . $unit_key . '">' . $unit_name . '</option>';
                            }
                            echo '</select></div>';
                        } else {
                            echo '<span class="input-group-label">' . $unit . '</span>';
                        }
                        if ($unit) echo '</div>';
                        echo '</div>';
    
                        if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';
    
                        break;

                case 'editor':

                    //$class = $name;
                    $settings =   array(
                        'wpautop' => true, // use wpautop?
                        'media_buttons' => false, // show insert/upload button(s)
                        'textarea_name' => $name, // set the textarea name to something different, square brackets [] can be used here
                        'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                        'tabindex' => '',
                        'editor_css' => '', //  extra styles for both visual and HTML editors buttons,
                        'editor_class' => $class, // add extra class(es) to the editor textarea
                        'teeny' => false, // output the minimal editor config used in Press This
                        'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                        'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                    );

                    if ($description) echo '<p>' . $description . '</p>';

                    $editor_id = str_replace(']', '', str_replace('[', '', $name));
                    wp_editor($value, $editor_id, $settings);

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    if (isset($args['length']) && $args['length']) {
                        echo "<p>Počet znaků: <span class='word-count' data-fieldname='" . $name . "' id='word-length-" . $name . "'>" . $this->valid_leght_string($value) . "</span>  / " . $args['length'] . '</p>';
                    }

                    //$editor_counter++;
                    break;

                case 'date':
                case 'datetime-local':
                case 'time':
                case 'month':
                case 'week':

                    /*if ($type == 'date') {
                        $now = date("Y-m-d");
                        (empty($value) ? $value = $now : '');
                        $value = date("Y-m-d", strtotime($value));
                    }*/

                    $icon = $type == 'time' ? "assets/icons/clock-line.svg" : "assets/icons/calendar-line.svg";

                    if ($description) echo '<p>' . $description . '</p>';
                    
                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }

                    echo '<div class="input-group">';
                    echo '<span class="input-group-label">' . file_get_contents(WDS_URL . $icon) . '</span>';
                    echo $floating_label_start;
                    echo '<input type="' . $type . '" id="' . $name . '" name="' . $name . '" value="' . $value . '">';
                    if ($label)  echo '<label for="' . $name . '">' . $label . $required . '</label>';
                    echo $floating_label_end;
                    echo '</div>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    break;

                case 'color':

                    $default = isset($args['value']) ? $args['value'] : '';

                    if ($label)  echo '<p>' . $label . $required . '</p>';
                    if ($description) echo '<p>' . $description . '</p>';

                    if (!$is_valid) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'textdomain') . '</span>';
                    }

                    echo '<p><input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="' . $default . '" id="' . $name . '" name="' . $name . '" value="' . $value . '"></p>';

                    if ($help_text) echo '<p class="help-text">' . $help_text . '</p>';

                    break;

                case 'info_box':
                case 'warning_box':
                    // Box s informací nebo varováním

                    $headline = isset($args['headline']) ? $args['headline'] : false;
                    $warning = $type == 'warning_box' ? ' warning' : '';
                    $icon = $type == 'warning_box' ? 'assets/icons/warning-standard-line.svg' : 'assets/icons/info-standard-line.svg';


                    echo '<div class="info-block' . $warning . '">';

                    echo '<span class="icon">' . file_get_contents(WDS_URL . $icon) . '</span>';

                    if ($headline) echo '<h3>' . $headline . '</h3>';
                    if ($description) echo '<p>' . $description . '</p>';

                    echo '</div>';
                    break;

                case 'html':
                    // Vlasní html obsah

                    $content = isset($args['content']) ? $args['content'] : false;

                    echo $content;

                    break;

                default:
                    # code...
                    break;
            }
        }

        public function save_form()
        {
            $success = false;
            $inputs = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //preprint( $inputs );

            if (!isset($inputs['wedesin_frontend_form']) || $inputs['wedesin_frontend_form'] == '') {
                return;
            }

            $formID = $inputs['wedesin_frontend_form'];
            if (isset($inputs['nonce_' . $formID]) && wp_verify_nonce($inputs['nonce_' . $formID], $formID)) {

                //validace polí
                if (!$this->validate_fields($inputs, $formID)) {
                    $this->session->addSession($formID . '_save', 'fail');
                    wp_safe_redirect($inputs['_wp_http_referer']);
                    exit;
                }

                //honeypot pole
                if ((isset($inputs['wds_meta']['name']) && $inputs['wds_meta']['name'] !== "") || (isset($inputs['wds_meta']['surname']) && $inputs['wds_meta']['surname'] !== "")) {
                    exit;
                }

                $new_post = ['post_status' => 'publish'];
                $new_post['post_type'] = $inputs['post_type'];
                $new_post['post_title'] = isset($inputs['post_title']) ? $inputs['post_title'] : '';
                $new_post['post_content'] = isset($inputs['post_content']) ? $inputs['post_content'] : '';
                $new_post['post_excerpt'] = isset($inputs['post_excerpt']) ? $inputs['post_excerpt'] : '';
                $new_post['post_author'] = isset($inputs['post_author']) ? $inputs['post_author'] : 1;

                if ($inputs['post_id'] == 'new') {
                    // create post
                    $save_post = wp_insert_post($new_post);
                } else {
                    // find post to update
                    $new_post['ID'] = $inputs['post_id'];
                    $save_post = wp_update_post($new_post);
                }

                if (!is_wp_error($save_post)) {

                    $taxonomies = $this->get_fields_from_post($inputs, 'taxonomy');
                    if ($taxonomies && !empty($taxonomies)) {
                        foreach ($taxonomies as $taxonomy_type => $taxonomy) {
                            wp_set_object_terms($save_post, $taxonomy, $taxonomy_type);
                        }
                    }

                    $metas = $this->get_fields_from_post($inputs, 'meta');

                    if ($metas && !empty($metas)) {
                        foreach ($metas as $meta_key => $meta_value) {
                            $gallery = 'gallery_';

                            if (substr($meta_key, 0, strlen($gallery)) === $gallery) {

                                // save gallery
                                if ($meta_value && $meta_value != '') {
                                    $images = explode(',', $meta_value);
                                    $imageCount = count($images);

                                    //if it is gallery

                                    if (is_array($images) && $imageCount > 0) {



                                        $prevCount = get_post_meta($save_post, $meta_key, true);
                                        // delete all previous rows from database
                                        if ($prevCount > 0) {
                                            for ($tempIndex = 0; $tempIndex < $prevCount; $tempIndex++) {
                                                delete_post_meta($save_post, $meta_key . '_' . ($tempIndex) . '_gallery_image_' . $inputs['post_type']);
                                                delete_post_meta($save_post, '_' . $meta_key . '_' . ($tempIndex) . '_gallery_image_' . $inputs['post_type']);
                                            }
                                        }
                                        // reset image count for ACF repeater
                                        delete_post_meta($save_post, $meta_key);

                                        $imgindex = 0;


                                        foreach ($images as $file_path) {

                                            $file_url = get_site_url() . '/' . str_replace(ABSPATH, '', $file_path);

                                            update_post_meta($save_post, $meta_key . '_' . ($imgindex) . '_gallery_image_' . $inputs['post_type'], $file_url);

                                            $imgindex++;
                                        }

                                        if ($this->get_field_parameter(str_replace('gallery_', '', $meta_key), 'useAsFeatured')) {
                                            if ($imgindex > 1) {
                                                // save the number of images to complete data for ACF repeater
                                                update_post_meta($save_post, $meta_key, $imageCount - 1);
                                            }
                                        } else {
                                            if ($imgindex > 0) {
                                                // save the number of images to complete data for ACF repeater
                                                update_post_meta($save_post, $meta_key, $imageCount);
                                            }
                                        }
                                    }
                                }
                            } else {

                                // save meta as usual
                                if ($meta_key == 'date_time') {
                                    //$meta_value = str_replace('-', '', $meta_value);
                                    update_post_meta($save_post, $meta_key . '_' . $inputs['post_type'], $meta_value);
                                } else if ($this->get_field_type_from_name($meta_key) == 'image') {
                                    if ($this->get_field_parameter($meta_key, 'useAsFeatured')) {
                                        set_post_thumbnail($save_post, $meta_value);
                                    } else {
                                        update_post_meta($save_post, $meta_key . '_' . $inputs['post_type'], $meta_value);
                                    }
                                } else {
                                    update_post_meta($save_post, $meta_key . '_' . $inputs['post_type'], $meta_value);
                                }
                            }
                        }
                    }

                    $success = true;
                    $gdpt = isset($inputs['wds_meta']['gdpr'][0]) && $inputs['wds_meta']['gdpr'][0] == 'gdpr' ? true : false;

                    //napojení na API
                    $API = new openApiSetup();
                    $current_date = date('Y-m-d\TH:i:s+00:00');
                    $data = [
                        "category" => isset($inputs['wds_meta']['maincategory']) && !empty($inputs['wds_meta']['maincategory']) ? $inputs['wds_meta']['maincategory'] : '',
                        "client_name" => isset($inputs['post_title']) && !empty($inputs['post_title']) ? $inputs['post_title'] : 'není dostupný',
                        "company_name" => isset($inputs['wds_meta']['_company']) && !empty($inputs['wds_meta']['_company']) ? $inputs['wds_meta']['_company'] : '',
                        "date_submitted" => $current_date,
                        'email' => isset($inputs['wds_meta']['email']) && !empty($inputs['wds_meta']['email']) ? $inputs['wds_meta']['email'] : 'není dostupný',
                        'gdpr_accepted' => $gdpt,
                        'message' => isset($inputs['wds_meta']['message']) && !empty($inputs['wds_meta']['message']) ? $inputs['wds_meta']['message'] : 'není dostupná',
                        'phone' => isset($inputs['wds_meta']['phone_number']) && !empty($inputs['wds_meta']['phone_number']) ? $inputs['wds_meta']['phone_number'] : '',
                        'subcategory' => isset($inputs['wds_meta']['subcategory']) && !empty($inputs['wds_meta']['subcategory']) ? $inputs['wds_meta']['subcategory'] : '',
                        'url_product' => isset($inputs['wds_meta']['specific-image']) && !empty($inputs['wds_meta']['specific-image']) ? $inputs['wds_meta']['specific-image'] : '',
                        'url_submitted' => isset($inputs['wds_meta']['currenturl']) && !empty($inputs['wds_meta']['currenturl']) ? $inputs['wds_meta']['currenturl'] : 'není dostupná',
                        'device_type' => isset($inputs['wds_meta']['device_type']) && !empty($inputs['wds_meta']['device_type']) ? $inputs['wds_meta']['device_type'] : 'není dostupné',
                    ];

                    $apiResult = $API->send_order($save_post, $data);

                    //preprint( $apiResult );

                    $filepaths = $inputs['wds_meta']['gallery_orders'];

                    if ($filepaths) {

                        $filepaths = explode(",",  $filepaths);

                        foreach ($filepaths as $filepath) {

                            $restul = $API->send_file((int)$apiResult->id, $filepath);

                            //preprint( $restul );

                        }
                    }

                    /*$a = 0;
                    $wordpress_upload_dir = wp_upload_dir();
                    if (!empty($_FILES)) {
                        
                        foreach ($_FILES as $inputKey => $inputData) {
                            foreach( $inputData['name'] as $key => $value ) {
                                $fileCount = count($inputData['name']);
                                if ($inputData['name'][$key]) {
                                    $fileToUpload = array(
                                        'name' => $inputData['name'][$key],
                                        'type' => $inputData['type'][$key],
                                        'tmp_name' => $inputData['tmp_name'][$key],
                                        'error' => $inputData['error'][$key],
                                        'size' => $inputData['size'][$key]
                                    );
                                }
                                $i = 1;

                                if( !empty( $fileToUpload ) ) {

                                    //preprint( $fileToUpload  );

                                    $new_file_path = $wordpress_upload_dir['path'] . '/' . $fileToUpload['name'];
                                    $new_file_mime = mime_content_type( $fileToUpload['tmp_name'] );

                                    while( file_exists( $new_file_path ) ) {
                                        $i++;
                                        $new_file_path = $wordpress_upload_dir['path'] . '/' . $fileToUpload['name'] . '_' . $i;
                                    }

                                    // looks like everything is OK
                                    if( move_uploaded_file( $fileToUpload['tmp_name'], $new_file_path ) ) {


                                        /*$upload_id = wp_insert_attachment( array(
                                            'guid'           => $new_file_path,
                                            'post_mime_type' => $new_file_mime,
                                            'post_title'     => preg_replace( '/\.[^.]+$/', '', $fileToUpload['name'] ),
                                            'post_content'   => '',
                                            'post_status'    => 'inherit'
                                        ), $new_file_path );*/

                    // wp_generate_attachment_metadata() won't work if you do not include this file
                    //require_once( ABSPATH . 'wp-admin/includes/image.php' );

                    // Generate and save the attachment metas into the database
                    //wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

                    /*update_post_meta($save_post, $key.'_'.$inputs['post_type'], $upload_id );

                                        $a++;
                                    }

                                }

                                //die();
                            }
                        }
                    }*/
                }

                if ($success) {
                    $metas['name'] = $new_post['post_title'];

                    //odeslání emailu
                    $email = get_field('email_notification', 'options') ? get_field('email_notification', 'options') : "produkce@textdomain.cz";
                    $class_email = new sendEmailContentWds();

                    //admin email
                    $class_email->email_new_order($email, $save_post, $metas);

                    //client email
                    $class_email->email_new_order($metas['email'], $save_post, $metas);

                    // remove field validation data
                    $this->session->removeSession($formID . '_validation');
                    // add "all good and saved" notice
                    $this->session->addSession($formID . '_save', 'success');

                    //redirect na nově vytvořený příspěvek
                    $newUrl = add_query_arg(['submit' => 1], $inputs['_wp_http_referer']) . '#order-popup';

                    $links = new linksWds;

                    if ($links->thank_you()) $newUrl = $links->thank_you();

                    wp_safe_redirect($newUrl);

                    exit;
                }

                $this->session->addSession($formID . '_save', 'fail');
                wp_safe_redirect($inputs['_wp_http_referer']);
                exit;
                die('Nastala chyba');
            }
        }

        public function validate_fields($inputs, $formID)
        {
            if (empty($this->fields)) {
                die('Fields must be set.');
            }
            $allvalid = true;

            $validated = [];

            foreach ($this->fields as $index => $field) {
                $value = '';
                $valid = true;
                $msg = '';

                $type = isset($field['type']) ? $field['type'] : false;
                $name = isset($field['name']) ? $field['name'] : false;
                $name = $type == 'gallery' ? 'gallery_' . $name : $name;
                $required = isset($field['required']) ? $field['required'] : false;

                switch ($field['saveAs']) {
                    case 'meta':
                        $value = isset($inputs['wds_meta'][$name]) ? $inputs['wds_meta'][$name] : null;
                        break;
                    case 'taxonomy':
                        $value = isset($inputs['wds_taxonomy'][$name]) ? $inputs['wds_taxonomy'][$name] : null;
                        break;
                    case 'post_title':
                    case 'post_content':
                    case 'post_excerpt':
                        $value = isset($inputs[$field['saveAs']]) ? $inputs[$field['saveAs']] : null;
                        break;
                    default:
                        $value = isset($inputs[$name]) ? $inputs[$name] : null;
                }

                if ($required) {
                    if (is_array($value)) {
                        if (empty($value)) {
                            $valid = false;
                            $msg = 'Povinné pole';
                            $allvalid = false;
                        }
                    } else {
                        if ($value == '' || !$value) {
                            $valid = false;
                            $msg = 'Povinné pole';

                            $allvalid = false;
                        }
                    }
                }

                if (isset($field['length'])) {
                    $num = $this->valid_leght_string($value);

                    if ($num > $field['length']) {
                        $valid = false;
                        $msg = 'Příliš mnoho znaků (' . $num . ')';
                        $allvalid = false;
                    }
                }

                //validate emails
                if ($type == 'email') {

                    if (!empty($value)) {

                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $valid = false;
                            $msg = 'Pole není email';
                            $allvalid = false;
                        }
                    }
                }

                $validated[$name] = [
                    'value' => $value,
                    'valid' => $valid,
                    'msg' => $msg,
                ];
            }

            $validated['allvalid'] = $allvalid;

            $this->session->addSession($formID . '_validation', $validated);
            return $allvalid;
        }

        public function handle_dropped_files_callback()
        {
            status_header(200);

            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['path'] . DIRECTORY_SEPARATOR;
            $num_files = count($_FILES['file']['tmp_name']);

            $newupload = 0;

            if (!empty($_FILES)) {
                $files = $_FILES;

                foreach ($files as $file) {

                    /* UPLOAD DO MÉDIÍ WORDPRESSU
                    $newfile = array (
                        'name' => $file['name'],
                        'type' => $file['type'],
                        'tmp_name' => $file['tmp_name'],
                        'error' => $file['error'],
                        'size' => $file['size']
                    );

                    $_FILES = array('upload'=>$newfile);
                    */

                    $upload_folder_path = WP_CONTENT_DIR . '/order-files';

                    if (!file_exists($upload_folder_path)) {
                        mkdir($upload_folder_path);
                    }

                    //preprint( $file );
                    $temp = $_FILES['photo']['tmp_name'];
                    $data = $file['name'];
                    $extten = "." . substr($data, strrpos($data, '.') + 1);
                    $file_name = substr($data, 0, strrpos($data, '.'));
                    $finalpath = $upload_folder_path . '/' . $file_name .  $extten;

                    //oprava opakovaných souborů
                    if (file_exists($finalpath)) {

                        for ($i = 1; $i < 999; $i++) {

                            $finalpath = $upload_folder_path . '/' . $file_name . "-" . $i .  $extten;

                            if (!file_exists($finalpath)) break;
                        }
                    }

                    //UPLOAD DO MÉDIÍ WORDPRESSU $newupload = media_handle_upload( $file, 0 );*/                        
                    if (move_uploaded_file($temp, $finalpath)) {
                        $newupload = $finalpath;
                    } else {
                        $newupload = 0;
                    }
                }
            }

            echo $newupload;
            die();
        }

        public function handle_deleted_files_callback()
        {
            if (isset($_REQUEST['media_id'])) {
                $post_id = $_REQUEST['media_id'];

                //$status = wp_delete_attachment($post_id, true);
                $status = !unlink($post_id);

                if ($status)
                    echo json_encode(array('status' => 'OK'));
                else
                    echo json_encode(array('status' => 'FAILED'));
            }

            die();
        }

        public function get_files_callback()
        {
            $images = [];
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR;
            if (isset($_REQUEST['images'])) {
                $image_ids = $_REQUEST['images'];
                if ($image_ids) {
                    foreach (explode(',', $image_ids) as $image_id) {
                        $meta = wp_get_attachment_metadata($image_id);
                        if ($meta) {
                            $images[] = [
                                'ID' => $image_id,
                                'name' => get_the_title($image_id),
                                'size' => filesize($upload_path . $meta['file']),
                                'url' => wp_get_attachment_url($image_id),
                            ];
                        }
                    }
                }
                echo json_encode($images);
            } else {
                echo json_encode(false);
            }

            die();
        }
    }

    new WDS_Front_Form;
}
