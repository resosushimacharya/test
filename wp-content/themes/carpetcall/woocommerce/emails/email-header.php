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

<body style="margin:0; padding:0; font-family:Arial, Helvetica, sans-serif;">

<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="margin: 0 auto;">  
  <tr style="background-color:#144a9f; height:70px;">
    <td colspan="3">      
      <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>      
            <td width="20"></td>    
            <td width="220">      
              <a href="<?php echo site_url();?>">
                <img src="http://resolutionaustralia.com.au/design/Carpetcall/carpetcall-logo.png" width="150" alt="logo"/>
              </a>      
            </td>

            <td width="340">
              <table width="340" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="3">
                    <div style="font-family:'proxima_nova_ltsemibold', sans-serif; font-size:18px; color:#FFF;  line-height:1; font-weight:bold; text-align: right;">  <?php $x =  get_field('telephone', '89',false);
                      $x = preg_replace('/\s+/', '', $x);
                      $x = preg_replace( '/^[0]{1}/', '', $x );
                      $i = 1;
                      $x = '+61'.$x;   ?>

                      <a href="tel:<?php
                      echo $x; ?>" style="text-decoration:none;color:#fff;">

                      CALL 1300 502 427 </a>
                    </div>
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
                          <p style=" font-family:'proxima_nova_ltsemibold', sans-serif; font-size:6.69px; color:#FFF; margin:0; text-transform:uppercase; text-align: right;"> OR BOOK A CALL BACK WITH <br>
                        OUR FLOORING SPECIALISTS 
                          </p>
                        </td>      
                        <td width="20"></td>                                      
                        <td style="background: #c32327;" width="75" height="18" valign="middle">                            
                            <a href="<?php echo site_url();?>/contact-us" style="font-family:'proxima_nova_rgregular', sans-serif; font-size:7.25px; color:#FFF; text-align:center; text-decoration:none; text-transform:uppercase; display: block;"> CONTACT US 
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

      </table>


    </td>
      
      
  </tr> <!-- header section end -->
