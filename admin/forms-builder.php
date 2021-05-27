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

		public function __construct( $field_list = [] )
		{
			
            $this->fields = $field_list;

            //prozatím zakomentované (save form zatím nefunkční)
			//add_action( 'wp', [$this, 'save_form'] );
		}

        /**
         * Vyhotovení formuláře
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */
		public function display_form( ) {
            $form = new WDS_Front_Form( $this->fields );
			echo $form->get_form($post_id, 'orders', 'add_post' );
		}

		public function save_form() {
			return $this->wds_form->save_form();
		}
		
	}
	
    new formsBuilderWDS;

}