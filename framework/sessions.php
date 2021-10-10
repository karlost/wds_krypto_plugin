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

if( ! class_exists( 'sessionClassWDS' ) )
{
	class sessionClassWDS
	{

		public function __construct()
		{

        }

        /**
         * Vytvoření session
         *
         * @param $name = jméno session
         * @param $value = hodnota
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function addSession( $name, $value="" ) 
        {
            $_SESSION[$name] = $value;
            return true;
        }

        /**
         * Kontrola session
         *
         * @param $name = jméno session
         * @param $value = hodnota
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function checkSession( $name, $value="" ) 
        {
            
            if ( isset( $_SESSION[$name] ) ) 
            {

                if ( $value !== "" ) 
                {

                    if ( $_SESSION[$name] == $value ) 
                    {
                        return true;
                    }                    

                } else {

                    if ( $_SESSION[$name] == 'error' ) 
                    {

                        return true;

                    } else {
                        
                    }

                }

            }

            return false;

        }

        /**
         * Získat session
         *
         * @param $name = jméno session
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function getSession( $name ) 
        {
            
            if ( isset( $_SESSION[$name] ) ) 
            {
                return $_SESSION[$name];
            }

            return false;

        }

        /**
         * Odebrat session
         *
         * @param $name = jméno session
         * 
         * @author Wedesin
         * @return true/false
         */ 
        public function removeSession( $name ) 
        {
            if ( isset( $_SESSION[$name] ) ) 
            {
                unset($_SESSION[$name]);
                return true;
            }

            return false;
        }
        
	}

}