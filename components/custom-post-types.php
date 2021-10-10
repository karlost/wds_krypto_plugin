<?php 
namespace tickersec\addCPT;
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'registerCustomPostTypes' ) )
{
	class registerCustomPostTypes
	{

		public function __construct()
		{

            //
			add_action( 'init', [$this, 'create_post_type'] );
			//taxonomies
			add_action( 'init', [$this,'create_perenny_type_tax'] );

		}

		function create_post_type() {

			register_post_type( 'simple_order_form',
			    array(
					'labels' => array(
						'name' => __( 'Objednávkové formuláře', TM_IDKRYPTO ),
						'add_new' => __( 'Přidat formulář', TM_IDKRYPTO ),
						'view_item'=> __( 'Zobrazit formulář', TM_IDKRYPTO ),
						'edit_item' => __( 'Upravit formulář', TM_IDKRYPTO ),
						'singular_name' => __( 'Objednávkový formulář', TM_IDKRYPTO ),
						'menu_name' => __( 'Objednávkové formuláře', TM_IDKRYPTO ),
					),
					'public' => false,
					'menu_icon' => 'dashicons-archive',
					'menu_position' => 50,
					'show_in_rest' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'show_in_nav_menus' => false,
					'publicly_queryable' => false,
					'exclude_from_search' => true,
			      	'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes', 'thumbnail' )
			    )
			);
			
			register_post_type( 'simple_order',
			    array(
			      'labels' => array(
			        'name' => __( 'Objednávka', TM_IDKRYPTO ),
			        'add_new' => __( 'Přidat objednávku', TM_IDKRYPTO  ),
			        'view_item'=> __( 'Zobrazit objednávku', TM_IDKRYPTO ),
			        'edit_item' => __( 'Upravit objednávku', TM_IDKRYPTO ),
			        'singular_name' => __( 'Objednávka', TM_IDKRYPTO ),
			        'menu_name' => __( 'Objednávky', TM_IDKRYPTO ),
			      ),
				  'public' => false,
				  'show_ui' => true,
			      'menu_icon' => 'dashicons-media-spreadsheet',
			      'menu_position' => 54,
			      'show_in_rest' => true,
			      'supports' => array( 'title', 'author')
			    )
			);

		}

		//taxonomy type
		function create_workshop_type_tax() {
			register_taxonomy(
				'workshop_type',
				'workshop',
				array(
					'label' => __( 'Typ semináře', 'plan' ),
					'rewrite' => array( 'slug' => 'typ' ),
					'hierarchical' => true,
				)
			);
		}
		//taxonomy type
		function create_perenny_type_tax() {
			register_taxonomy(
				'perenny_moisture',
				'perenny',
				array(
					'label' => __( 'Půdní vlhkost', 'plan' ),
					'rewrite' => array( 'slug' => 'pudni-vlhkost' ),
					'hierarchical'               => false,
					'public'                     => false,
					'show_ui'                    => true,
					'show_admin_column'          => true,
					'show_in_nav_menus'          => true,
					'show_tagcloud'              => true,
					'show_in_rest' 				=> true,
				)
			);
			register_taxonomy(
				'perenny_shine',
				'perenny',
				array(
					'label' => __( 'Oslunění záhonu', 'plan' ),
					'rewrite' => array( 'slug' => 'osluneni' ),
					'hierarchical'               => false,
					'public'                     => false,
					'show_ui'                    => true,
					'show_admin_column'          => true,
					'show_in_nav_menus'          => true,
					'show_tagcloud'              => true,
					'show_in_rest' 				=> true,
				)
			);
		}
		
	}

}

new registerCustomPostTypes;