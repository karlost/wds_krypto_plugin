<?php 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'formsBuilderWDS' ) )
{
	class formsBuilderWDS
	{

		private $fields;
		private $wds_form;

		public function __construct( )
		{
			

            //prozatím zakomentované (save form zatím nefunkční)
			//add_action( 'wp', [$this, 'save_form'] );
			//add_action( 'admin_init', [$this, 'set_data'] );
			add_action( 'admin_init', [$this, 'save_form'] );
		}
		public function set_data() {
			//$this->wds_form = new WDS_Front_Form($this->fields);
			$this->fields = $this->get_fields_form($this->form_id);
		}

        /**
         * Vyhotovení formuláře
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */
		public function display_form($formID ) {
			$field = $this->get_fields_form($formID);
			$this->wds_form = new WDS_Front_Form($field);
			echo $this->wds_form->get_form($formID );
		}
		public function save_form() {
			$inputs = filter_input_array(INPUT_POST);
            if (isset($inputs['form_id_wds']) && !empty($inputs['form_id_wds'])) {
				$formID = $inputs['form_id_wds'];
				$field = $this->get_fields_form($formID);
				$this->wds_form = new WDS_Front_Form($field);
				return $this->wds_form->save_form();
            }
			
			//preprint($this->fields);
			//return $this->wds_form->save_form();
		}
		public function get_fields_form($formID){
			$fields= [];
			$tpf = new thisPluginField;
			$fields = $tpf->get_fields_form($formID);
			return $fields;

		}
		public function get_fields_cpt_form($post_type){
			$fields= [];
			$tpf = new thisPluginField;
			$fields = $tpf->get_fields_cpt_form($post_type);
			return $fields;
		}
		
		
	}
	
    new formsBuilderWDS;

}