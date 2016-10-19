<?php
/**
 * Additional Customer Details
 *
 * This is extra customer data which can be filtered by plugins. It outputs below the order item table.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-customer-details.php.
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
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
 <tr>
  <td>
    <table width="600" border="0" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
					<td width="40"></td>
					<td width="520">
						<table width="520" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<h2 style="font-family:Arial;color:#666666; margin-bottom: 10px; font-size: 14px;"><?php _e( 'CUSTOMER DETAILS', 'woocommerce' ); ?></h2>
									<div style="font-family:Arial;color:#666; margin-bottom:25px; font-size: 12px;">
										<?php foreach ( $fields as $field ) : ?>
								       		<p style="margin: 0">
								       			<strong style="text-transform: uppercase;"><?php echo wp_kses_post( $field['label'] ); ?>:</strong> <span class="text"><?php echo wp_kses_post( $field['value'] ); ?></span>
								       		</p>
								    	<?php endforeach; ?>
									</div>
								</td>
							</tr>
						</table>
					</td>
					<td width="40"></td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>