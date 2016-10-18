<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?> <!-- footer start -->
  <tr>
    <td colspan="3" style="background-color:#144a9f;">
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20"></td>
          <td width="560">
            <table width="560" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" height="20"></td>
              </tr>

              <tr>                
                <td colspan="3">
                  <a href="<?php echo site_url();?>"><img src="<?php echo get_template_directory_uri(); ?>/images/carpetcall-logo.png" width="150" alt="logo"/></a>
                </td>
              </tr> <!-- LOGO -->

              <tr>
                <td colspan="3" height="20"></td>
              </tr>

              <tr>
                <td colspan="3">
                  <table width="560" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><a href="<?php echo site_url();?>/shop-our-range/" style="text-decoration:none;font-size:8px;"><span style="color:#FFF; text-decoration:none;">SHOP OUR RANGE</span></a></td>
                      <td><a href="<?php echo site_url();?>/ideas-and-advice/" style="text-decoration:none;font-size:8px;"><span style="color:#FFF; text-decoration:none;">IDEAS AND ADVICE</span></a></td>
                      <td><a href="<?php echo site_url();?>/clearance/" style="text-decoration:none;font-size:8px;"><span style="color:#FFF; text-decoration:none;">CLEARANCE</span></a></td>
                      <td><a href="<?php echo site_url();?>/about-us/" style="text-decoration:none;font-size:8px;"><span style="color:#FFF; text-decoration:none;">ABOUT CARPETCALL</span></a></td>
                      <td><a href="http://roomvisualiser.carpetcall.com.au/" style="text-decoration:none;font-size:8px;"><span style="color:#FFF; text-decoration:none;">ROOM VISUALISER</span></a></td>
                      <td><a href="<?php echo site_url();?>/find-a-store/" style="text-decoration:none;font-size:8px;"><span style="color:#FFF; text-decoration:none;">STORE FINDER</span></a></td>
                    </tr>
                  </table>
                </td>
              </tr> <!-- FOOTER LINKS -->

              <tr>
                <td colspan="3" height="5"></td>
              </tr>
                
              <tr>
                <td colspan="3">
                  <table width="560" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td style="width:70px; font-size:6.88px; font-weight:bold; color:#FFF; text-transform:uppercase;" valign="bottom"> Get to know us</td>
                      
                      <td style="width:20px;"><a href="http://www.facebook.com/carpetcallau" style="text-decoration:none;"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" width="9" height="9" alt="facebook" style="vertical-align: bottom;"/></a></td>
                      
                      <td style="width:20px;"><a href="http://www.youtube.com/user/carpetcallau?sub_confirmation=1" style="text-decoration:none;"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png" width="11" height="8" alt="youtube" style="vertical-align: bottom;"/></a></td>
                      
                      <td style="width:20px;"><a href="http://www.pinterest.com/carpetcall" style="text-decoration:none;"><img src="<?php echo get_template_directory_uri(); ?>/images/pinterest.png" width="9" height="9" alt="pinterest" style="vertical-align: bottom;"/></a></td>
                      
                      <td style="width:20px;"><a href="https://plus.google.com/108290827729290320654" style="text-decoration:none;"><img src="<?php echo get_template_directory_uri(); ?>/images/google-plus.png" width="13" height="9" alt="google-plus" style="vertical-align: bottom;"/></a></td>
                      
                      <td><a href="https://www.instagram.com/carpetcallau/" style="text-decoration:none;"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram.png" width="10" height="9" alt="instagram" style="vertical-align: bottom;"/></a></td>                      
                    </tr>
                  </table>
                </td>
              </tr> <!-- GET TO KNOW US LINKS -->

              <tr>
                <td colspan="3" height="10"></td>
              </tr>
              
              <tr>
                <td colspan="3">                  
                  <table width="560" border="0" cellspacing="0" cellpadding="0">
                   <tr>
                     <td width="125" valign="top"><p href="#" style="margin:0; font-size:6.88px; color:#FFF; text-decoration:none; text-transform:uppercase; border-right: 1px solid #fff; padding-right: 5px; display: block; line-height: 8px;"> © Copyright 2016 Carpet CalL </p></td>
                     <td width="50" valign="top"><a href="<?php echo site_url();?>/sitemap/" style="font-size:6.88px; color:#FFF; text-decoration:none; text-transform:uppercase; border-right: 1px solid #fff; padding-right: 5px; margin-left:5px; display: block; line-height: 8px;"> SITE MAP </a></td>
                     <td valign="top"><a href="<?php echo site_url();?>/terms-and-conditions/" style="font-size:6.88px; color:#FFF; text-decoration:none; text-transform:uppercase; margin-left:5px; display: block; line-height: 8px;"> TERMS AND CONDITIONS </a></td>
                   </tr>
                 </table>
                </td>                
              </tr> <!-- COPYRIGHT SEC -->

              <tr>
                <td colspan="3" height="20"></td>
              </tr>
    
             </tr>
            </table>
          </td> 
          <td width="20"></td>        
        </tr>      
    </table>
    </td>
  </tr>
</table>



</body>
</html>
