<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'WDS_Front_Form' ) )
{
	class WDS_Front_Form
	{

        private $fields;
        private $session;

		public function __construct($field_list = [])
		{
            $this->fields = $field_list;

            add_action( 'wp_ajax_wds_frontend_form_dropzone_handle_dropped_files', [$this, 'handle_dropped_files_callback'], 10, 1 );
            add_action( 'wp_ajax_nopriv_wds_frontend_form_dropzone_handle_dropped_files', [$this, 'handle_dropped_files_callback'], 10, 1 );
            
            add_action( 'wp_ajax_wds_frontend_form_dropzone_handle_deleted_files', [$this, 'handle_deleted_files_callback'], 10, 1 );
            add_action( 'wp_ajax_nopriv_wds_frontend_form_dropzone_handle_deleted_files', [$this, 'handle_deleted_files_callback'], 10, 1 );
            
            add_action( 'wp_ajax_wds_frontend_form_dropzone_get_files', [$this, 'get_files_callback'], 10, 1 );
            add_action( 'wp_ajax_nopriv_wds_frontend_form_dropzone_get_files', [$this, 'get_files_callback'], 10, 1 );

            $this->session = new sessionClassWDS;
        }

        private function check_if_fields_has($var) {
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

        public function get_form($post_id = 'new', $post_type = 'post', $formID = 'wedesin_frontend' ) {

            global $post;

            $return = "";
            $query = filter_input_array( INPUT_GET );
            $product_id = false;

            if ( get_post_type() == "product" && is_single( ) ) {
                $product_id = get_the_ID();
            } else if ( isset( $query['order_product'] ) && $query['order_product'] ) {
                $product_id = $query['order_product'];
            }

            if ( $product_id && 88 != $product_id ) {
                
                $title = get_the_title( $product_id );
                
                $post_data = get_post( $product_id);
                $parent_post_id =  $post_data->post_parent;
                $parent_post = get_post($parent_post_id );
                $page_parent =  $parent_post->post_title;
                $post_thumbnail_id = get_post_thumbnail_id( $product_id );

                //specifické id obrázku
                if ( isset( $query['image-id'] ) && $query['image-id'] ) {
                    $post_thumbnail_id = $query['image-id'];
                }
 
                $image_src = wp_get_attachment_image_src( $post_thumbnail_id, 'medium');
                $image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', TRUE );
                
                ?>
                        
                <div class="grid-x grid-margin-x">
            
                    <?php if ( $image_src && $query['submit'] != 1 ) { ?>

                        <div class="cell large-5 medium-4 small-12">
                            <img src="<?= $image_src[0] ?>" alt="<?= $image_alt ?>" id="requested_image">
                        </div>
                        <div class="cell large-7 medium-8 small-12 phone-align">
                            <div class="grid-x">
                                <div class="cell">
                                    <div class="h3 no-margin-bottom">
                                        <?= __('Poptáváte produkt: ', 'gramon'); ?>
                                    </div>
                                    <p><?= $title ?></p>
                                </div>
                            </div>
                            <?php if ( $page_parent ) { ?>
                            <div class="grid-x">
                                <div class="cell">
                                    <div class="h3 no-margin-bottom">
                                        <?= __('Produkt ze sekce: ', 'gramon'); ?>
                                    </div>
                                    <p><?= $page_parent ?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                                
                </div>

            <?php } ?>

            <div class="large-12 medium-12 small-12 cell">
                <span class="form-star"><small><?= __('* povinné pole', 'gramon' ); ?></small></span>
            </div>
            <form method="post" id="<?=$formID?>_<?=$post_id?>_form" class="add-edit-wedesin-form" action="<?php // the_permalink(); ?>"
                enctype="multipart/form-data" novalidate data-abide>
                <div data-abide-error class="alert callout" style="display: none;">
                    <?= __('Ve formuláři je chyba. Prosíme, zkontrolujte zadaná pole.', 'gramon' ); ?>
                </div>
                <div class="grid-x grid-margin-x">
                    <div class="small-12 medium-12 cell">

                        <?php wp_nonce_field( $formID, 'nonce_' . $formID ); ?>
                        <input type="hidden" value="<?=$formID?>" name="wedesin_frontend_form" />
                        <input type="hidden" value="<?=$post_type?>" name="post_type" />
                        <input type="hidden" value="<?=$post_id?>" name="post_id" />
                        <input type="hidden" value="<?=get_current_user_id()?>" name="post_author" />

                        <div class="grid-x grid-margin-x">

                            <?php $this->get_form_fields($post_id, $post_type, 1, $formID); ?>

                            <div class="cell submit-button-container">
                                <button type="submit" class="button " onclick="needToConfirm = false;">
                                    <?php _e('Odeslat poptávku', 'gramon'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }

        private function get_form_field_index($fields, $key) {
            return array_keys(array_column($fields, 'saveAs'), $key);
        }

        private function get_form_field_count($fields, $key) {
            return count($this->get_form_field_index($fields, $key));
        }

        private function get_form_field_featuredImages_index($fields) {
            return array_keys(array_column($fields, 'useAsFeatured'), 1);
        }

        private function get_form_field_featuredImages_count($fields) {
            return count($this->get_form_field_featuredImages_index($fields));
        }

        private function get_field_type_from_name($name) {
            if (isset($this->fields) && !empty($this->fields)) {
                foreach ($this->fields as $index => $field) {
                    if ( $field['name'] == $name ) {
                        if (isset($this->fields[$index]['type'])) {
                            return $this->fields[$index]['type'];
                        } else {
                            return false;
                        }
                    }
                }
            }
        }

        public function get_fields($fields, $key) {
            $return_fields = [];
            $indexes = $this->get_form_field_index($fields, $key);
            if (is_array($indexes) && !empty($indexes)) {
                foreach ($indexes as $index) {
                    $return_fields[] = $fields[$index];
                }
            }
            return $return_fields;
        }

        public function get_fields_from_post($inputs, $key) {
            if (is_array($inputs) && isset($inputs['wds_' . $key])) {
                return $inputs['wds_' . $key];
            }
            return false;
        }

        public function get_field_parameter($name, $parameter) {
            if (isset($this->fields) && !empty($this->fields)) {
                foreach ($this->fields as $index => $field) {
                    if ( $field['name'] == $name ) {
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
        *	@param $col - 1 - one column, 2 - two columns
        *
        * 	@author Wedesin
        * 	@return echo
        */
        public function get_form_fields($post_id, $post_type = 'post', $col = 1, $formID = null, $class = "") {

            if (empty($this->fields)) {
                die('Fields must be set.');
            }

            if ($col == 2) {
                $col1 = 'medium-3 small-12 cell';
                $col2 = 'medium-9 small-12 cell';
            } else {
                $col1 = 'medium-12 small-12 cell';
                $col2 = 'medium-12 small-12 cell';
            }

            // get index
            // run some tests, all this under should be only once
            if ( $this->get_form_field_count($this->fields, 'post_title') > 1 ) {
                die('Fields contain more than 1 post_title.');
            }
            if ( $this->get_form_field_count($this->fields, 'post_content') > 1 ) {
                die('Fields contain more than 1 post_content.');
            }
            if ( $this->get_form_field_count($this->fields, 'post_excerpt') > 1 ) {
                die('Fields contain more than 1 post_excerpt.');
            }
            if ( $this->get_form_field_featuredImages_count($this->fields) > 1 ) {
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
            //preprint( $this->fields );

            foreach ($this->fields as $index => $field) {

                $type = isset($field['type']) ? $field['type'] : false;
                $name = isset($field['name']) ? $field['name'] : false;
                $class = isset($field['class']) ? $field['class'] : false;

                if ($name && $type)  {

                    $label = isset($field['label']) ? $field['label'] : false;

                    //new post
                    if ($post_id == 'new') {

                        $value = isset($field['default_value']) ? $field['default_value'] : '';

                    //edit post
                    } else {
      
                        $value = get_post_meta($post_id, $name.'_'.$post_type, true);

                        if ($type == 'gallery') {
                            $useAsFeatured = isset($field['useAsFeatured']) && $field['useAsFeatured'] ? true : false;

                            if ($useAsFeatured) {
                                $value = get_post_thumbnail_id($post_id);
                            } else {
                                $value = '';
                            }

                            $gallery = get_post_meta($post_id, 'gallery_'.$name, true);
                            $gallery = intval($gallery);

                            if( $gallery ) {
                                for ($i = 0; $i < $gallery; $i++) {
                                    $imageId = get_post_meta($post_id, 'gallery_'.$name.'_' . $i . '_gallery_image_'.$post_type, true);
                                    if (wp_attachment_is_image($imageId)) {
                                        $value .= $value == '' ? $imageId : ',' . $imageId;
                                    }
                                }
                            }

                        }

                        if ($type == 'image') {
                            $useAsFeatured = isset($field['useAsFeatured']) && $field['useAsFeatured'] ? true : false;

                            if ($useAsFeatured) {
                                $value = get_post_thumbnail_id($post_id);
                            } else {
                                $value = get_post_meta($post_id, $name . '_' . $post_type, true);;
                            }

                        }

                        // switch to get correct value
                        switch ($field['saveAs']) {
                            case 'taxonomy':
                                $tax = get_the_terms($post_id, $name);
                                $value = !is_wp_error($tax) ? join(',', wp_list_pluck($tax, 'slug')) : $value;
                                break;
                            case 'post_title':
                                $value = get_the_title($post_id);
                                break;
                            case 'post_content':
                                $value = get_the_content(null, false, $post_id);
                                // $value = apply_filters('the_content', $value);
                                break;
                            case 'post_excerpt':
                                $value = (has_excerpt($post_id) ? get_the_excerpt($post_id) : '');
                                break;
                            default:
                                // nothing
                        }
                    }
                    $required = isset($field['required']) && $field['required'] == true ? ' <span class="required form-star">*</span>' : '';

                    $is_valid = true;
                    $msg = null;
                    $tempname = $type == 'gallery' ? 'gallery_' . $name : $name;
                    if (isset($validation_data[$tempname]) && $validation_data[$tempname]) {

                        $is_valid = isset($validation_data[$tempname]['valid']) ? $validation_data[$tempname]['valid'] : false;
                        $value = isset($validation_data[$tempname]['value']) ? $validation_data[$tempname]['value'] : $value;
                        $msg = isset($validation_data[$tempname]['msg']) ? $validation_data[$tempname]['msg'] : null;
                    }

                    //nejdřív přidáme skrytá pole
                    if ( $type == 'hidden' ) {

                        $value = isset($field['value']) ? $field['value'] : '';
                        $this->get_input_html($type, $name, $value, $field, $is_valid);

                    } else {

                        if ( $class ) {

                            ?>
    
                            <div class="cell <?php echo $name; ?>">
                                <?php if ($label) { ?>
                                    <label for="<?= $name?>"><?=$label?><?=$required?></label>
                                    <?php
                                        if (!$is_valid) {
                                            echo '<span class="callout alert">'.$msg.'</span>';
                                        }
                                    }
                                    ?>
                                    <?php $this->get_input_html($type, $name, $value, $field, $is_valid); ?>
                            </div>
    
                            <?php
    
                        } else {
    
                            ?>
                            <div class="cell large-6 medium-6 small-12 <?php echo $name; ?>">
                                <div class="<?=$col1 ?>">
                                    <?php if ($label) { ?>
                                    <label for="<?= $name?>"><?=$label?><?=$required?></label>
                                    <?php
                                        if (!$is_valid) {
                                            echo '<span class="callout alert">'.$msg.'</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="<?=$col2?>">
                                    <?php $this->get_input_html($type, $name, $value, $field, $is_valid); ?>
                                </div>
                            </div>
    
                            <?php
    
                        }

                    }
                }

            }

            $this->session->removeSession( $formID.'_validation' );
        }

        public function get_field_name($name, $saveAs = null, $type = null) {

            $name = $type == 'gallery' ? 'gallery_' . $name : $name;

            // switch to get correct input name
            switch ($saveAs) {
                case 'meta':
                    $newName = 'wds_meta['.$name.']';
                    break;
                case 'taxonomy':
                    $newName = 'wds_taxonomy['.$name.']';
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


        

        public function get_input_html($type, $name, $value, $args = [], $is_valid = true) {
            $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';

            $multiple = isset($args['multiple']) && $args['multiple'] == true ? 'multiple' : false;
            $atts = isset($args['required']) && $args['required'] == true ? 'required="required"' : '';
            $atts .= $multiple ? ' multiple' : '';
            $class = !$is_valid ? 'callout alert' : '';
            $name = $this->get_field_name($name, $args['saveAs'], $type);
            $name = $name . ( $type == 'checkbox' || ( $type == 'image' && $multiple ) ? '[]' : '' );
            $limit = isset( $args['imagesLimit'] ) ? $args['imagesLimit'] : '999999';
            $is_required = isset($args['required']) && $args['required'] == true ? true : false;

            switch ($type) {

                case 'email':
                case 'text':
                case 'hidden':

                    $id_val = str_replace( ']', '', str_replace( '[', '', $name ) );

                    echo '<input type="' . $type . '" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '" '.$atts.' class="'.$class.'" id="'.$id_val.'"/>';

                    if ( $type != "hidden" && $is_required ) {
                        
                        $er_mess = __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'gramon');
                        if ( $type == "email" ) $er_mess = __('Prosíme, zadejte platný email.', 'gramon');
                        echo '<span class="form-error">' . $er_mess .'</span>';
                    }

                    break;
                case 'select':
                    $options = isset($args['options']) ? $args['options'] : [];
                    if (!empty($options)) {
                        echo '<select name="'.$name.'" '.$atts.' class="'.$class.'">';
                        foreach ($options as $option_key => $option_name) {
                            if ($option_key != '' && $option_name != '') {
                                echo '<option value="' . $option_key . '" '. ( $option_key == $value ? 'selected="selected"' : '') .'>' . $option_name . '</option>';
                            }
                        }
                        echo '</select>';
                        if ( $is_required ) {
                            echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'gramon') .'</span>';
                        }
                    }
                    break;
                case 'gallery':
                    echo '<div id="media-uploader-'.$name.'" data-target="'.$name.'" data-limit="'.$limit.'" class="dropzone '.$class.'"></div>';
                    echo '<input type="hidden" name="'.$name.'" value="'.$value.'" '.$atts.' />';

                    if (!empty($placeholder)) echo '<p>'. $placeholder . '</p>';
                    
                    /* 
                    tady message sama nevyskočí
                    if ( $is_required ) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'gramon') .'</span>';
                    }
                    */
                    break;
                case 'image':
                    echo '<div id="media-uploader-'.$name.'" data-target="'.$name.'" data-limit="1" class="dropzone '.$class.'"></div>';
                    echo '<input type="hidden" name="'.$name.'" value="'.$value.'" '.$atts.' />';
                    if (!empty($placeholder)) echo '<p>'. $placeholder . '</p>';
                    if ($is_required ) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'gramon') .'</span>';
                    }
                    break;
                case 'checkbox':
                case 'radio':
                    $options = isset($args['options']) ? $args['options'] : [];
                    if (!empty($options)) {
                        //echo '<input type="' . $type . '" value=""  name="' . $name .'" checked class="hide"> ';
                        foreach ($options as $option_key => $option_name) {
                            if ($option_key != '' && $option_name != '') {
                                if ($type == 'checkbox') {
                                    if ( (is_array($value) && in_array($option_key, $value)) || $option_key == $value) {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }
                                } else {
                                    $checked = $option_key == $value ? 'checked' : '';
                                }
                                echo '<label>';
                                    echo '<input type="' . $type . '" value="' . $option_key . '"  name="' . $name .'" '. $checked .' '.$atts.'> ';
                                    echo $option_name;
                                echo '</label>';
                            }
                        }
                    }
                    break;


                case 'textarea':

                    echo '<textarea type="' . $type . '"  name="' . $name . '" placeholder="' . $placeholder . '" '.$atts.' class="'.$class.'" />' . $value . '</textarea>';
                    if ($is_required ) {
                        echo '<span class="form-error">' . __('Toto pole je vyžadované, prosíme, vyplňte ho.', 'gramon') .'</span>';
                    }
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
                    $editor_id = str_replace( ']', '', str_replace( '[', '', $name ));
                    wp_editor( $value, $editor_id, $settings );

                    if ( isset( $args['length'] ) && $args['length'] ) {
                        echo "<p>Počet znaků: <span class='word-count' data-fieldname='".$name."' id='word-length-". $name . "'>".$this->valid_leght_string($value)."</span>  / " . $args['length'] . '</p>';
                    }

                    if (!empty($placeholder)) echo '<p>'. $placeholder . '</p>';
                    //$editor_counter++;
                    break;
                case 'date':
                    $now = date("Y-m-d");
                    (empty($value) ? $value = $now : '');
                    $value = date("Y-m-d", strtotime($value));
                    echo '<input type="date" id="'.$name.'" name="'.$name.'" value="'.$value.'">';
                    break;
                default:
                    # code...
                    break;
            }
        }

        public function save_form() {
            $success = false;
            $inputs = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

            //preprint( $inputs );

            if ( !isset($inputs['wedesin_frontend_form']) || $inputs['wedesin_frontend_form'] == '') {
                return;
            }

            $formID = $inputs['wedesin_frontend_form'];
            if( isset($inputs['nonce_'.$formID]) && wp_verify_nonce( $inputs['nonce_' . $formID], $formID ) ) {

                //validace polí
                if ( !$this->validate_fields($inputs, $formID) ) {
                    $this->session->addSession( $formID.'_save', 'fail' );
                    wp_safe_redirect( $inputs['_wp_http_referer'] );
                    exit;
                }

                //honeypot pole
                if ( ( isset($inputs['wds_meta']['name']) && $inputs['wds_meta']['name'] !== "") || ( isset($inputs['wds_meta']['surname']) && $inputs['wds_meta']['surname'] !== "") ) {
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
                    $save_post = wp_insert_post( $new_post );
                } else {
                    // find post to update
                    $new_post['ID'] = $inputs['post_id'];
                    $save_post = wp_update_post( $new_post );
                }

                if(!is_wp_error($save_post)) {

                    $taxonomies = $this->get_fields_from_post($inputs, 'taxonomy');
                    if ( $taxonomies && !empty($taxonomies) ) {
                        foreach ($taxonomies as $taxonomy_type => $taxonomy) {
                            wp_set_object_terms( $save_post, $taxonomy, $taxonomy_type );
                        }
                    }

                    $metas = $this->get_fields_from_post($inputs, 'meta');

                    if ( $metas && !empty($metas) ) {
                        foreach ($metas as $meta_key => $meta_value) {
                            $gallery = 'gallery_';

                            if ( substr($meta_key, 0, strlen($gallery)) === $gallery ) {

                                // save gallery
                                if ($meta_value && $meta_value != '') {
                                    $images = explode(',', $meta_value);
                                    $imageCount = count($images);

                                    //if it is gallery

                                    if (  is_array($images) && $imageCount > 0) {

                                        

                                        $prevCount = get_post_meta($save_post, $meta_key, true);
                                        // delete all previous rows from database
                                        if ($prevCount > 0) {
                                            for ($tempIndex=0; $tempIndex<$prevCount; $tempIndex++) {
                                                delete_post_meta($save_post, $meta_key.'_'.($tempIndex).'_gallery_image_'.$inputs['post_type']);
                                                delete_post_meta($save_post, '_'.$meta_key.'_'.($tempIndex).'_gallery_image_'.$inputs['post_type']);
                                            }
                                        }
                                        // reset image count for ACF repeater
                                        delete_post_meta($save_post, $meta_key);

                                        $imgindex = 0;
                                        

                                        foreach ($images as $file_path) {

                                            $file_url = get_site_url() . '/' . str_replace( ABSPATH, '', $file_path );

                                            update_post_meta($save_post, $meta_key.'_'.($imgindex).'_gallery_image_'.$inputs['post_type'], $file_url );

                                            $imgindex++;
                                        }

                                        if ($this->get_field_parameter(str_replace('gallery_', '', $meta_key), 'useAsFeatured')) {
                                            if ($imgindex > 1) {
                                                // save the number of images to complete data for ACF repeater
                                                update_post_meta($save_post, $meta_key, $imageCount-1 );
                                            }
                                        } else {
                                            if ($imgindex > 0) {
                                                // save the number of images to complete data for ACF repeater
                                                update_post_meta($save_post, $meta_key, $imageCount );
                                            }
                                        }

                                    }

                                }

                            } else {

                                // save meta as usual
                                if ($meta_key == 'date_time') {
                                    //$meta_value = str_replace('-', '', $meta_value);
                                    update_post_meta($save_post, $meta_key.'_'.$inputs['post_type'], $meta_value );
                                } else if ($this->get_field_type_from_name($meta_key) == 'image') {
                                    if ($this->get_field_parameter($meta_key, 'useAsFeatured')) {
                                        set_post_thumbnail( $save_post, $meta_value );
                                    } else {
                                        update_post_meta($save_post, $meta_key.'_'.$inputs['post_type'], $meta_value );
                                    }
                                } else {
                                    update_post_meta($save_post, $meta_key.'_'.$inputs['post_type'], $meta_value );
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
                        "category" => isset($inputs['wds_meta']['maincategory']) && !empty( $inputs['wds_meta']['maincategory'] ) ? $inputs['wds_meta']['maincategory'] : '',
                        "client_name" => isset($inputs['post_title'])&& !empty( $inputs['post_title'] ) ? $inputs['post_title'] : 'není dostupný',
                        "company_name" => isset($inputs['wds_meta']['_company'])&& !empty( $inputs['wds_meta']['_company'] ) ? $inputs['wds_meta']['_company'] : '', 
                        "date_submitted" => $current_date,
                        'email' => isset($inputs['wds_meta']['email'])&& !empty( $inputs['wds_meta']['email'] ) ? $inputs['wds_meta']['email'] : 'není dostupný',
                        'gdpr_accepted' => $gdpt,
                        'message' => isset($inputs['wds_meta']['message'])&& !empty( $inputs['wds_meta']['message'] ) ? $inputs['wds_meta']['message'] : 'není dostupná',
                        'phone' => isset($inputs['wds_meta']['phone_number'])&& !empty( $inputs['wds_meta']['phone_number'] ) ? $inputs['wds_meta']['phone_number'] : '',
                        'subcategory' => isset($inputs['wds_meta']['subcategory'])&& !empty( $inputs['wds_meta']['subcategory'] ) ? $inputs['wds_meta']['subcategory'] : '', 
                        'url_product' => isset($inputs['wds_meta']['specific-image'])&& !empty( $inputs['wds_meta']['specific-image'] ) ? $inputs['wds_meta']['specific-image'] : '',
                        'url_submitted' => isset($inputs['wds_meta']['currenturl'])&& !empty( $inputs['wds_meta']['currenturl'] ) ? $inputs['wds_meta']['currenturl'] : 'není dostupná',
                        'device_type' => isset($inputs['wds_meta']['device_type'])&& !empty( $inputs['wds_meta']['device_type'] ) ? $inputs['wds_meta']['device_type'] : 'není dostupné',
                    ];

                    $apiResult = $API->send_order( $save_post, $data );

                    //preprint( $apiResult );

                    $filepaths = $inputs['wds_meta']['gallery_orders'];

                    if ( $filepaths ) {

                        $filepaths = explode( ",",  $filepaths );

                        foreach ( $filepaths as $filepath ) {
                        
                            $restul = $API->send_file( (int)$apiResult->id, $filepath );

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
                    $email = get_field('email_notification', 'options') ? get_field('email_notification', 'options') : "produkce@gramon.cz";
                    $class_email = new sendEmailContentWds();

                    //admin email
                    $class_email->email_new_order( $email, $save_post, $metas);
                   
                    //client email
                    $class_email->email_new_order( $metas['email'], $save_post, $metas);

                    // remove field validation data
                    $this->session->removeSession( $formID.'_validation' );
                    // add "all good and saved" notice
                    $this->session->addSession( $formID.'_save', 'success' );

                    //redirect na nově vytvořený příspěvek
                    $newUrl = add_query_arg(['submit' => 1], $inputs['_wp_http_referer'] ) . '#order-popup';

                    $links = new linksWds;
                   
                    if ( $links->thank_you() ) $newUrl = $links->thank_you();

                    wp_safe_redirect( $newUrl );

                    exit;

                }

                $this->session->addSession( $formID.'_save', 'fail' );
                wp_safe_redirect( $inputs['_wp_http_referer'] );
                exit;
                die('Nastala chyba');
            }
        }

        public function validate_fields($inputs, $formID) {
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

                if (isset($field['length']) ) {
                    $num = $this->valid_leght_string($value);

                    if ($num > $field['length'] ) {
                        $valid = false;
                        $msg = 'Příliš mnoho znaků ('.$num .')';
                        $allvalid = false;
                    }
                }

                //validate emails
                if ( $type == 'email' ) {

                    if ( !empty( $value ) ) {

                        if ( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
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

            $this->session->addSession( $formID.'_validation', $validated );
            return $allvalid;
        }

        public function handle_dropped_files_callback() {
            status_header(200);

            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['path'] . DIRECTORY_SEPARATOR;
            $num_files = count($_FILES['file']['tmp_name']);

            $newupload = 0;

            if ( !empty($_FILES) ) {
                $files = $_FILES;

                foreach($files as $file) {

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

                    $upload_folder_path = WP_CONTENT_DIR. '/order-files';

                    if ( !file_exists (  $upload_folder_path ) ) {
                        mkdir(  $upload_folder_path );
                    }

                    //preprint( $file );
                    $temp = $_FILES['photo']['tmp_name'];
                    $data = $file['name'];    
                    $extten = "." . substr($data, strrpos($data, '.') + 1);
                    $file_name = substr($data, 0, strrpos( $data, '.') );
                    $finalpath = $upload_folder_path . '/' .$file_name .  $extten;

                    //oprava opakovaných souborů
                    if ( file_exists ( $finalpath ) ) {

                        for ($i=1; $i < 999; $i++) { 

                            $finalpath = $upload_folder_path . '/' .$file_name . "-". $i .  $extten;

                            if ( !file_exists ( $finalpath ) ) break;

                        }
                        
                    }
                    
                    //UPLOAD DO MÉDIÍ WORDPRESSU $newupload = media_handle_upload( $file, 0 );*/                        
                    if ( move_uploaded_file( $temp, $finalpath ) ) {
                        $newupload = $finalpath;
                    } else {
                        $newupload = 0;
                    }                         
                }
            }

            echo $newupload;
            die();
        }

        public function handle_deleted_files_callback() {
            if( isset($_REQUEST['media_id']) ){
                $post_id = $_REQUEST['media_id'];

                //$status = wp_delete_attachment($post_id, true);
                $status =!unlink($post_id);

                if( $status )
                    echo json_encode(array('status' => 'OK'));
                else
                    echo json_encode(array('status' => 'FAILED'));
            }

            die();
        }

        public function get_files_callback() {
            $images = [];
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR;
            if( isset($_REQUEST['images']) ){
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
