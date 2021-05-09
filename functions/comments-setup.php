<?php

/**
 * class description
 *
 * 
 * @author Wedesin
 */ 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if( ! class_exists( 'customizeComments' ) )

{
	class customizeComments extends setupWDS
	{

		public function __construct()
		{

            //register scripts
            //add_filter( 'comment_form_default_fields', [$this,'my_update_comment_fields'] );

            //Those filter makes my ""custom comment field"" both logged and unlogged  
            add_action('comment_form_logged_in_after', [$this, 'comment_custom_field_logged_in'] );
            
            //hvězdičky před komentáři
            add_filter( 'comment_form_fields', [$this,'reorder_fields_logged_out'] );
            add_action ('comment_post', [$this,'update_comment_meta_values'], 1);
            add_action('comment_post', [$this, 'add_before_comment_field'], 10, 2 );

            //metadata komentářů
            add_action( 'add_meta_boxes', [$this,'custom_box'] );

            //prostor před komentářem
            if ( !is_admin() ) {
                add_filter( 'comment_text', [$this,'add_star_rating_to_comment'], 10, 2 );
            }

        }

        /**
        * 	Description 
        *
        * 	@param $auctioneer = ID of the seller
        *	  @param $current_user_id = ID user
        * 
        * 	@author Wedesin
        * 	@return echo
        */
        public function add_before_comment_field(  ) {

        echo '<h1>sem tu aha</h1>';

        } 

        /**

         * Změna pořadí polí komentářů

         *

         * @param none

         * 

         * @author Wedesin

         * @return true/false

         */ 

        function reorder_fields_logged_out( $fields ) {

            $comment_field = $fields['comment'];
            $author_field = $fields['author'];
            $email_field = $fields['email'];
            $cookies_field = $fields['cookies'];
            $fields['startaring'] = $this->star_rating_html( );
            $fields['comment'] = $comment_field;
            $fields['email'] = $email_field;
            $fields['author'] = $author_field;
            $fields['cookies'] = $cookies_field;
            return $fields;

        }


        /**
         * Uložení metadata komentářů
         *
         * @param none
         * 
         * @author Wedesin
         * @return true/false
         */ 

        function update_comment_meta_values($comment_id) {            

            if ( isset($_POST['star-rating']) && $_POST['star-rating'] != '') {
                add_comment_meta($comment_id, 'star-rating_wds', $_POST['star-rating']);
            } 

        }



        /**

         * Registrace metabox

         *

         * @param none

         * 

         * @author Wedesin

         * @return true/false

         */ 

        function custom_box() {

            add_meta_box('travel_comment_extra_box', __('Metadata komentářů', TM), [$this, 'metabox_callback'], 'comment', 'normal');

        }

        

        /**

         * Callback funkce metaboxu

         *

         * @param comment

         * 

         * @author Wedesin

         * @return true/false

         */ 

        function metabox_callback($comment) {

            $starrate = get_comment_meta(  $comment->comment_ID ,'star-rating_wds', true );

            ?>

                <table class="form-table editcomment comment_xtra">

                    <tbody>

                    <tr valign="top">

                        <td class="first"><?php _e( 'Hvězdičkové hodnocení', TM ); ?></td>
                        <td><input type="number" steo="1" name="star-rating" size="10" class="code" value="<?php echo esc_attr($starrate); ?>" min="1" max="5" tabindex="1" /></td>

                    </tr>

                </tbody>

            </table>

            <?php

        }

        /**
         * Return star rating html
         *
         * @param comment
         * 
         * @author Wedesin
         * @return true/false
         */ 

        function comment_custom_field_logged_in(){

            ?>
            <div class="comment_form_rate" id="star_rating">
                <?php echo $this->star_rating_html( ); ?>
            </div>
            <?php

        }



        /**
         * html kód pro zadávání hvězdičkového hodnocení
         *
         * @param comment
         * 
         * @author Wedesin
         * @return true/false
         */ 

        function star_rating_html(  ) {

            return 
            '<div class="star-rating-wrp">
                <strong>' . __("Vaše hodnocení:", 'star-rating') . '</strong>
                <span class="star-rating-input">
                    <input class="star-5 hide" id="star-5" type="radio" name="star-rating" value="5"/>
                    <label class="star star-5" for="star-5">☆</label>    
                    <input class="star-4 hide" id="star-4" type="radio" name="star-rating" value="4"/>
                    <label class="star star-4" for="star-4">☆</label>
                    <input class="star-3 hide" id="star-3" type="radio" name="star-rating" value="3"/>
                    <label class="star star-3" for="star-3">☆</label>
                    <input class="star-2 hide" id="star-2" type="radio" name="star-rating" value="2"/>
                    <label class="star star-2" for="star-2">☆</label>
                    <input class="star-1 hide" id="star-1" type="radio" name="star-rating" value="1"/>
                    <label class="star star-1" for="star-1">☆</label> 
                </span></div>';

        }

        /**
         * html kód pro zobrazení hvězdičkového hodnocení
         *
         * @param comment
         * 
         * @author Wedesin
         * @return true/false
         */

        function add_star_rating_to_comment( $comment_text, $comment ) {

            $commentID = $comment->comment_ID;
            $rating = get_comment_meta( $commentID, 'star-rating_wds', true );

            preprint( $comment );
            // Do something to the comment, possibly switching based on the presence of $comment
            echo '<div>Jsem tu před komentářem, haha</div>'. $comment_text;
        }
        

	}

}



