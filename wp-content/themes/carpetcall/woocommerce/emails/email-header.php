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
<head>
<meta charset="utf-8">
<title>THANK YOU FOR YOUR ORDER</title>
</head>

<body>
	<div style="background-color:#FFF; margin:23px auto; width:600px; clear:both;">
    
    		<div style="clear:both; background-color:#144a9f; height:35px; padding:17px 29px;">
            
            	<div style="float:left; margin-left:12px;" ><a href="<?php echo site_url();?>" ><img src="http://resolutionaustralia.com.au/design/Carpetcall/carpetcall-logo.png" width="171" height="35" alt="logo"/></a></div><!-- logo end -->
                
                <div style="float:right; width:179px;">
                <div style="font-family:'proxima_nova_ltsemibold', sans-serif; font-size:20px; color:#FFF;  line-height:1; clear:both;">CALL 1300 502 427 </div>
                
                <div style="clear:both; position:relative;">
                	<p style="float:left; font-family:'proxima_nova_ltsemibold', sans-serif; font-size:6.69px; color:#FFF; margin:2px 0; text-transform:uppercase;"> OR BOOK A CALL BACK WITH <br>
OUR FLOORING SPECIALISTS </p>
				<div style="position:absolute; top:-1px; right:0;"><a href="#" style="display:block; background-color:#c32428; padding:5px 14px; font-family:'proxima_nova_rgregular', sans-serif; font-size:7.25px; color:#FFF; text-align:center; text-decoration:none; text-transform:uppercase;"> CONTACT US </a></div>
                </div>
                </div><!-- header info end -->
                
            </div><!-- header section end -->
