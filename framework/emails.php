<?php


if ( ! defined( 'ABSPATH' ) ) {

  exit;

}



if( ! class_exists( 'WdsSendEmail' ) )

{

    class WdsSendEmail
    {

      private $background;
      private $fontColorText;
      private $fontColorFooter;
      private $fontSize;
      private $lineHeight;
      private $fontFamily;
      private $buttonColor;
      private $settings;
  
      public function __construct($settings = []){
        add_filter( 'wp_mail', [$this, 'change_headers'] );
        add_action( 'init', [$this,'email_test'] );
        $this->settings_css($settings);
      }
      public function settings_css($settings = []) {
        $this->background = (isset($settings['footer_bg_color']) ? $settings['footer_bg_color'] : '#414b55' );
        $this->fontColorText = '#151B24';
        $this->fontColorLink = '#03acff';
        $this->fontColorFooter = (isset($settings['footer_bg_color']) ? $settings['footer_color'] : '#03acff' );
        $this->fontSize = '12px';
        $this->lineHeight = '16px';
        $this->fontFamily = 'Arial, sans-serif';
        $this->buttonColor = array('bg'=> '#B0EA91!important', 'color'=>'#151B24', 'hover'=> '#ffffff!important');
        $this->settings = $settings;
      }
      public function default_font_style(){
        $css = 'font-size: '.$this->fontSize.'; 
        line-height: '.$this->lineHeight.'; 
        font-family: '.$this->fontFamily.'; 
        color: '.$this->fontColorText.';';
        return $css;
      }
      public function text_settings(){
        $text = array(
          'footer_copy'=> '© '. date('Y') .' TIS partners, s.r.o',
          'footer_text'=> 'Automatický email v webové stránky '. get_home_url()
        );
        return $text;
      }
  
      function change_headers($args) {
  
        $mailheader = "Reply-To: produkce@gramon.cz\r\n";
        $mailheader .= "MIME-Version: 1.0\r\n";
        $mailheader .= "Content-Type: text/html; charset=utf-8\r\n";
  
        $args['headers'] = $mailheader;
  
        return $args;
  
      }
  
      /*
      wraps email body into prestyled html content
      ==============================================================*/
  
      public function email_content(
        $title, 
        $body="",
        $footer=""
        ){
          $img = get_option('_wds_wdslicsys_license_plugin_wds_obrazek', false);
          $return ='<!DOCTYPE html>
              <html lang="cs">
              <head>
              <title>'. $title .'</title>
              <meta charset="utf-8">
              <meta name="viewport" content="width=device-width">
              <style type="text/css">'.
              $this->mail_default_css().
              '</style>
              </head>
              <body style="margin: 0; padding: 0; background: #f6f6f6;">
              <table  border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                      <td>
                          <div align="center" style="padding: 20px 15px 0px 15px;">
                              <table style="background: #ffffff;" border="0" cellpadding="0" cellspacing="0" width="600" class="wrapper">
                                  <tr>
                                      <td style="padding: 30px;" class="logo">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td bgcolor="" width="600" align="left">
                                                    <a href="'.home_url().'"><img src="'.$img .'" width="200" height="auto" style="width: 200px; height:auto;"></a>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                      </td>
                  </tr>
              </table>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                      <td align="center" class="section-padding">
                          <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
                              <tr>
                                  <td bgcolor="#ffffff" style="padding: 20px ; font-size: '.$this->fontSize.'; line-height: '.$this->lineHeight.'; font-family:'.$this->fontFamily.'; color: '.$this->fontColorText.';">
                                  <div style="padding: 20px;">
                                      <table  width="100%" border="0" cellspacing="0" cellpadding="0">';
                                          if (!empty($title) ) {
                                            $return .= '<tr><td align="center" style="font-size: 40px; line-height: 48px; font-family: Georgia, Arial, sans-serif; color: '.$this->fontColorText.'; padding:20px 5%" class="padding-copy">' .$title. '</td></tr>';
                                          }
  
                                        if ( $body ) { 
                                          foreach ($body as $paragraph) {
  
                                            $return .= '<tr><td align="center" style="'.$this->default_font_style().' padding: 0 5% 20px 5%;" class="padding-copy">' .$paragraph. '</td></tr>';
  
                                          }
                                        }
                                          $return .= '<tr>
                                              <td align="center" style="padding: 15px 5% 20px 5%; font-size: 12px; line-height: 25px; font-family: '.$this->fontFamily.'; color: '.$this->fontColorText.';" class="padding-copy">'.$footer.'                                            
                                              </td>
                                          </tr>                                      
                                      </table>
                                  </div>
                                              
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr>
              </table>'
              .$this->render_mail_footer().'
              </body>
              </html>';
  
              // echo $return;
              // die();
  
              return $return;
  
      }
      public function render_mail_footer() {
        $text = $this->text_settings();
        /*$fb = get_field('facebook_address', 'option') ;
        $insta = get_field('instagram_address', 'option') ;
        $pinte = get_field('pinterest_address', 'option') ;
        $yt = get_field('youtube_address', 'option') ;
        $links = new linksWds;
        $contact_link = (method_exists($links,'contact_link') ? $links->contact_link( ) : '');
        $business_terms = (method_exists($links,'business_terms') ? $links->business_terms( ) : '');
        $gdpr = (method_exists($links,'gdpr') ? $links->gdpr( ) : '');
        */
        $return = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td align="center">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="footer-email">
                    <tr>
                        <td style="padding: 0px 0px 20px 0px;">
                            <table style="background: '.$this->background.'; color:'.$this->fontColorFooter.';" width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">';
                              /*if ($contact_link || $business_terms || $gdpr){  
                                $return .='<tr>
                                  <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding-top: 35px;">';
                                    if ($contact_link){
                                      $return .='<a href="'.$contact_link.'" target="_blank" style="color: #ffffff;">Kontakt</a>
                                      <span style="color: #ffffff; padding: 0 10px">|</span>';
                                    }
                                      
                                    if ($business_terms){
                                      $return .='<a href="'. $business_terms.'" target="_blank" style="color: #ffffff;">Obchodní podmínky</a>
                                      <span style="color: #ffffff; padding: 0 10px">|</span>';
                                    }
                                    if ($gdpr){
                                        $return .='<a href="'.$gdpr.'" target="_blank" style="color: #ffffff;">Ochrana osobních údajů</a>';
                                    }
                                  $return .='</td>
                                </tr>';
                              }
                                if (!empty($fb) || !empty($insta) || !empty($pinte) || !empty($yt)) {
                                $return .='<tr>
                                  <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding: 35px 5px 20px 5px;">';
                                  if (! empty($fb)) { $return .= '<a href="'.$fb.'" target="_blank" style="color: '.$this->fontColorFooter.'; text-decoration: none; padding:0 10px">
                                    <img src="'.home_url().'/wp-content/themes/fleraacademy/assets/svg/mail/facebook.svg" width="30" height="30" style="width: auto; height:30px;">
                                    </a>'; }
                                  if (! empty($yt)) { $return .= '<a href="'.$yt.'" target="_blank" style="color: '.$this->fontColorFooter.'; text-decoration: none; padding:0 10px">
                                    <img src="'.home_url().'/wp-content/themes/fleraacademy/assets/svg/mail/youtube.svg" width="30" height="30" style="width: auto; height:30px;">
                                    </a>'; }
                                  if (! empty($insta)) { $return .= '<a href="'.$insta.'" target="_blank" style="color: '.$this->fontColorFooter.'; text-decoration: none; padding:0 10px">
                                    <img src="'.home_url().'/wp-content/themes/fleraacademy/assets/svg/mail/instagram.svg" width="30" height="30" style="width: auto; height:30px;">
                                    </a>'; }
                                  if (! empty($pinte)) { $return .= '<a href="'.$pinte.'" target="_blank" style="color: '.$this->fontColorFooter.'; text-decoration: none; padding:0 10px">
                                    <img src="'.home_url().'/wp-content/themes/fleraacademy/assets/svg/mail/pinterest.svg" width="30" height="30" style="width: auto; height:30px;">
                                    </a>'; }
                                  $return .='</td>
                                </tr>'; }*/
                                $return .='<tr>
                                    <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding: 15px 5px 0px 5px;">
                                    '. $text['footer_copy'].'
                                    </td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding: 0 5px;">
                                    '.$text['footer_text'].'
                                  </td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding: 15px 5px 15px 5px;">
                                    <a href="'.home_url().'" target="_blank" style="color: '.$this->fontColorFooter.'; text-decoration: underline;">'.home_url().'</a>
                                  </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
        </table>';
        return $return;
      }
  
      /* Add default styles to email 
      ========================================================*/
      public function mail_default_css(){
        $css = '#outlook a{padding:0;}
        .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
        body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;}
        table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
        img{-ms-interpolation-mode:bicubic;}
        body{margin:0; padding:0;}
        img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
        table{border-collapse:collapse !important;}
        body{height:100% !important; margin:0; padding:0; width:100% !important;}
        .appleBody a {color:#666666; text-decoration: none;}
        .appleFooter a {color:#666666; text-decoration: none;}
        a {
          color: #2199e8;
        }
        a.button:hover {
            text-decoration: none !important;
            color: '.$this->buttonColor['hover'].';
            background :'.$this->buttonColor['bg'].';
            border-color: '.$this->buttonColor['bg'].';
        }
        @media screen and (max-width: 525px) {
            table[class="wrapper"]{
              width:100% !important;
            }
            td[class="logo"]{
              text-align: left;
              padding: 20px 0 20px 0 !important;
            }
            td[class="logo"] img{
              margin:0 auto!important;
            }
            td[class="mobile-hide"]{
              display:none;
            }
            img[class="mobile-hide"]{
              display: none !important;
            }
            img[class="img-max"]{
              max-width: 100% !important;
              height:auto !important;
            }
            table[class="responsive-table"]{
              width:100%!important;
            }
            td[class="padding"]{
              padding: 10px 5% 15px 5% !important;
            }
            td[class="padding-copy-to-center"]{
              padding: 10px 5% 10px 5% !important;
              text-align: center;
            }
            td[class="padding-copy"]{
              padding: 10px 5% 10px 5% !important;
            }
            td[class="padding-meta"]{
              padding: 30px 5% 0px 5% !important;
              text-align: center;
            }
            td[class="no-pad"]{
              padding: 0 0 20px 0 !important;
            }
            td[class="no-padding"]{
              padding: 0 !important;
            }
            td[class="section-padding"]{
              padding: 30px 15px 30px 15px !important;
            }
            td[class="section-padding-bottom-image"]{
              padding: 30px 15px 0 15px !important;
            }
            td[class="mobile-wrapper"]{
                padding: 10px 5% 15px 5% !important;
            }
            table[class="mobile-button-container"]{
                margin:0 auto;
                width:100% !important;
            }
            a[class="mobile-button"]{
                width:80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 12px !important;
            }
        }';
        return $css;
      }
  
      /* Send admin email
      ========================================================*/
  
      public  function send_admin_email( $subject, $message ) {
          $headers = array( 'Content-Type: text/html; charset=UTF-8 ' );
          $to = get_field( 'admin_email', 'options');
          //submit admin email
          if ( $to && $subject && $message ) {
            wp_mail( $to, $subject, $message, $headers );
          }
      } 
  
      /* Create email to send to the user
      ========================================================*/
  
      public function send_client_emails( $mail, $subject, $message ){ 
  
        if (empty($subject)) {
            $subject = __('', 'custom' );
        }
  
        $headers = array( 'Content-Type: text/html; charset=UTF-8 ');
  
        if ( $mail && $subject && $message ) {
          wp_mail(  $mail, $subject, $message, $headers );
          return true;
        }  
  
        return false;
      }
  
      /* Test mailů
      ========================================================*/
      public function email_test() {
        if ( isset($_GET['showmail']) &&$_GET['showmail']==1 ) {
          echo $this->email_content( 'title', 'subtitle',array('test', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam sapien sem, ornare ac, nonummy non, lobortis a enim. Etiam egestas wisi a erat. Vivamus ac leo pretium faucibus. Maecenas sollicitudin. Morbi leo mi, nonummy eget tristique non, rhoncus non leo. Vivamus luctus egestas leo. Suspendisse sagittis ultrices augue. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam. Nullam justo enim, consectetuer nec, ullamcorper ac, vestibulum in, elit. Aliquam ante. Aliquam erat volutpat. In convallis.'),
          'footer', 'https://wedesin.cz', 'ahoj' );
          die('semtu');
        }
      }
    }
}
