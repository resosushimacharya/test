<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
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

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<tr>
	<td>
		<table width="600" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="40"></td>
			</tr>			
			<tr>
				<td width="520">
					<table width="520" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="3" height="20"></td>
						</tr>
						<tr>
							<td>
								<?php if ( ! $sent_to_admin ) : ?>
									<p><?php printf( __( 'Order #%s', 'woocommerce' ), $order->get_order_number() ); ?></p>
								<?php else : ?>
									<p>
										<a href="<?php echo esc_url( admin_url( 'post.php?post=' . $order->id . '&action=edit' ) ); ?>">
											<?php printf( __( 'Order #%s', 'woocommerce'), $order->get_order_number() ); ?>
										</a> 
										(<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ); ?>)
									</p>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td>
								<table width="520" border="0" cellspacing="0" cellpadding="0">
									<thead>
										<tr style="background-color:#e7edf8;">
											<th width="300" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;">
												<?php _e( 'PRODUCT', 'woocommerce' ); ?>
											</th>
											<th width="60" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;">
												<?php _e( 'QUANTITY', 'woocommerce' ); ?>
											</th>
											<th width="160" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;">
												<?php _e( 'PRICE', 'woocommerce' ); ?>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php echo $order->email_order_items_table( array(
											'show_sku'      => $sent_to_admin,
											'show_image'    => false,
											'image_size'    => array( 32, 32 ),
											'plain_text'    => $plain_text,
											'sent_to_admin' => $sent_to_admin
										) ); ?>
									</tbody>
									<tfoot style="border-top: 1px solid #e7edf8;">
										<?php
											if ( $totals = $order->get_order_item_totals() ) {
												$i = 0;
												foreach ( $totals as $key=>$total ) {
													if($key == 'shipping'){
													$total['value'] = get_post_meta($order->id,'cc_shipping_method',true);
													}
													$i++;
													?><tr>
														<td width="150"></td>
														<td width="200" style="text-align:left; color: #666; font-weight: bold;text-transform: upppercase; padding:12px 15px; <?php if ( $i === 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></td>
														<td width="150" style="text-align:left; color: #666; padding:12px 15px; <?php if ( $i === 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
													</tr><?php
												}
											}
										?>
									</tfoot>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="3" height="20"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="40"></td>
			</tr>
		</table>
	</td>
</tr>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
