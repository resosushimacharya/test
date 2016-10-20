<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html dir="<?php echo is_rtl() ? 'rtl' : 'ltr'?>">
<meta charset="utf-8">
<title>Thank You For Your Order</title>
</head>

<body style="margin:0; padding:0; font-family:Arial;">

<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0 auto;">  
  <tr style="background-color:#144a9f; height:70px;">
    <td colspan="3">      
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="3" height="10"></td>
        </tr>
        <tr>      
          <td width="20"></td>    
          <td width="220">      
            <a href="<?php echo site_url();?>">
              <img src="resolutionaustralia.com.au/design/Carpetcall/carpetcall-logo.png" width="150" alt="logo"/>
            </a>      
          </td>

          <td width="340">
            <table width="340" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" style="text-align: right;">
                  <?php $x =  get_field('telephone', '89',false);
                    $x = preg_replace('/\s+/', '', $x);
                    $x = preg_replace( '/^[0]{1}/', '', $x );
                    $i = 1;
                    $x = '+61'.$x;   ?>
                    <a href="tel:<?php echo $x;?>" style="text-decoration:none;"><span style="text-decoration:none; color:#fff; font-size: 18px; font-weight: bold; font-family:Arial;">CALL 1300 502 427</span></a>                  
                </td>                  
              </tr>
              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              <tr>
                <td colspan="3">
                  <table width="340" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="245">
                        <table width="245" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td style="font-size:6.69px; color:#FFF; text-align: right; line-height: 9px; font-family:Arial;" height="9" colspan="3">
                              <div style="height: 9px;">OR BOOK A CALL BACK WITH</div>
                            </td>
                          </tr>
                          <tr>
                            <td style="font-size:6.69px; color:#FFF; text-align: right; line-height: 9px; font-family:Arial;" height="9" colspan="3">
                              <div style="height: 9px;">OUR FLOORING SPECIALISTS</div>
                            </td>
                          </tr>
                        </table>                        
                      </td>      
                      <td width="20"></td>                                      
                      <td style="background: #c32327; text-align: center;" width="75" height="18" valign="middle">                            
                          <a href="<?php echo site_url();?>/contact-us" style="text-decoration:none; font-family:Arial; font-size:7.25px; color:#FFF; text-align:center; text-transform:uppercase; display: block;"> <span style="text-decoration:none;">CONTACT US</span>
                          </a>
                        </td>
                      </tr>
                    </table>                      
                </td>                  
              </tr>
            </table>
          </td>
          <td width="20"></td>
        </tr>
        <tr>
          <td colspan="3" height="10"></td>
        </tr>
      </table>


    </td>
      
      
  </tr> <!-- header section end -->
