<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
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
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<tr>
	<td width="40"></td>
	<td width="520">
		<table width="520" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="text-align:left; font-family: Arial, sans-serif;">
					<h3 style="font-family:Arial; color:#666666; margin-bottom: 10px; text-transform:uppercase;">
						<?php _e( 'BILLING ADDRESS', 'woocommerce' ); ?>
					</h3>
					<p><?php echo $order->get_formatted_billing_address(); ?></p>
				</td>
				<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>
				<td style="text-align:left; font-family: Arial, sans-serif;">
					<h3 style="font-family:Arial; color:#666666; margin-bottom: 10px; text-transform:uppercase;">
						<?php _e( 'SHIPPING ADDRESS', 'woocommerce' ); ?>
					</h3>
					<p><?php echo $shipping; ?></p>
				</td>
			<?php endif; ?>
			</tr>
		</table>
	</td>	
	<td width="40"></td>
</tr>
