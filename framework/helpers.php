<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
  
/**
 * Print result with pre tag
 *
 * @param $lang string
 * 
 * @author Wedesin
 * @return echo string
 */ 

if ( !function_exists('preprint') ) {

    function preprint( $print ) {

        echo '<pre>';

        echo print_r( $print );

        echo '</pre>';

    }

}

/**
 * Vrátí správnou délku stringu
 *
 * @param $value string
 * 
 * @author Wedesin
 * @return int
 */ 
if ( !function_exists('valid_leght_string') ) {

    function valid_leght_string($value) {
        $strip = (strip_tags($value));
        $strip = trim($strip);
        $conversion_table = Array(
            'ä'=>'a',
            'Ä'=>'A',
            'á'=>'a',
            'Á'=>'A',
            'à'=>'a',
            'À'=>'A',
            'ã'=>'a',
            'Ã'=>'A',
            'â'=>'a',
            'Â'=>'A',
            'č'=>'c',
            'Č'=>'C',
            'ć'=>'c',
            'Ć'=>'C',
            'ď'=>'d',
            'Ď'=>'D',
            'ě'=>'e',
            'Ě'=>'E',
            'é'=>'e',
            'É'=>'E',
            'ë'=>'e',
            'Ë'=>'E',
            'è'=>'e',
            'È'=>'E',
            'ê'=>'e',
            'Ê'=>'E',
            'í'=>'i',
            'Í'=>'I',
            'ï'=>'i',
            'Ï'=>'I',
            'ì'=>'i',
            'Ì'=>'I',
            'î'=>'i',
            'Î'=>'I',
            'ľ'=>'l',
            'Ľ'=>'L',
            'ĺ'=>'l',
            'Ĺ'=>'L',
            'ń'=>'n',
            'Ń'=>'N',
            'ň'=>'n',
            'Ň'=>'N',
            'ñ'=>'n',
            'Ñ'=>'N',
            'ó'=>'o',
            'Ó'=>'O',
            'ö'=>'o',
            'Ö'=>'O',
            'ô'=>'o',
            'Ô'=>'O',
            'ò'=>'o',
            'Ò'=>'O',
            'õ'=>'o',
            'Õ'=>'O',
            'ő'=>'o',
            'Ő'=>'O',
            'ř'=>'r',
            'Ř'=>'R',
            'ŕ'=>'r',
            'Ŕ'=>'R',
            'š'=>'s',
            'Š'=>'S',
            'ś'=>'s',
            'Ś'=>'S',
            'ť'=>'t',
            'Ť'=>'T',
            'ú'=>'u',
            'Ú'=>'U',
            'ů'=>'u',
            'Ů'=>'U',
            'ü'=>'u',
            'Ü'=>'U',
            'ù'=>'u',
            'Ù'=>'U',
            'ũ'=>'u',
            'Ũ'=>'U',
            'û'=>'u',
            'Û'=>'U',
            'ý'=>'y',
            'Ý'=>'Y',
            'ž'=>'z',
            'Ž'=>'Z',
            'ź'=>'z',
            'Ź'=>'Z'
        );
        $return = strtr($strip, $conversion_table);
        $return = str_replace( array("\r", "\n"), '', $return );
        $num = strlen($return);

        return $num;
    }

}
/**
 * Vrací konkrétní hodnotu nastavení pokud je definovaná, pokud není, buď vrací předdefinocanou a nebo false
 *
 * @param $meta_name - jméno metadata
 * @param $default - volitelná, vrací hodnotu v případě, že jí nemáme definovanou
 * 
 * @author Wedesin
 * @return echo string
 */ 

if ( !function_exists('wds_get_option') ) {

    function wds_get_option( $meta_name, $default = "" ) {

        if ( get_option( $meta_name ) ) {
            return get_option( $meta_name );
        } else if ( $default ) {
            return $default;
        } else {
            return false; 
        }  

    }

}

/**
 * User redirect to refferer
 *
 * @param none
 * 
 * @author Wedesin
 * @return true/false
 */ 
if ( !function_exists( 'redirect_back' ) ) {
    function redirect_back( $parameter = "" ){
      $location = ( isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : "" );
  
      if ( !empty( $location ) )
        wp_safe_redirect($location . $parameter);
      exit;
    }
}

/**
 * Vrací konkrétní hodnotu nastavení pokud je definovaná, pokud není, buď vrací předdefinocanou a nebo false
 *
 * @param $meta_name - jméno metadata
 * @param $default - volitelná, vrací hodnotu v případě, že jí nemáme definovanou
 * 
 * @author Wedesin
 * @return echo string
 */ 

if ( !function_exists('wds_meta_name') ) {

    function wds_meta_name( $form_prefix, $meta_name ) {

        return '_wds_'. $form_prefix. '_' .$meta_name;

    }

}