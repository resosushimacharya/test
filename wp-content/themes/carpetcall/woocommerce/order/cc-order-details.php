<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$order = wc_get_order( $order_id );

$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>

<tr>
	<td colspan="3" height="20"></td>
</tr>
<tr>
	<td width="40"></td>
	<td width="520">
		<span style="text-transform: uppercase; color: #15489f; font-weight: bold; font-size: 20px;"><?php _e( 'Order Details', 'woocommerce' ); ?></span>
	</td>
	<td width="40"></td>
</tr>
<tr>
	<td colspan="3" height="20"></td>
</tr>
<tr>
	<td colspan="3">
		<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td width="40"></td>
				<td width="520">
					<table width="520" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr style="background-color:#e7edf8;">
								<th width="190" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;">
									<?php _e( 'PRODUCT', 'woocommerce' ); ?>								
								</th>
								<th width="30" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;">
									<?php _e( 'QTY', 'woocommerce' ); ?>								
								</th>
					            <th width="150" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;">
					            	<?php _e( 'PRICE', 'woocommerce' ); ?>				            	
					            </th>
								<th width="150" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;">
									<?php _e( 'TOTAL', 'woocommerce' ); ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php		
								$_pf = new WC_Product_Factory(); 
								foreach( $order->get_items() as $item_id => $item ) {
									$id = $item['item_meta']['_product_id'][0];				
									$item_price = get_post_meta($id ,'_price',true);
									$item_price = number_format(round($item_price), 2);			  
									$qty = $item['item_meta']['_qty'][0];
									$sku= $item['item_meta']['sku'][0];
									$item_total = $item['item_meta']['_line_total'][0];
									$item_total = number_format(round($item_total), 2);
									$product = new WC_Product($id);
							?>
							<tr>
								<td width="190" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;text-align: left;border-bottom:1px solid #e7edf8;">
									<p style="margin: 0;"><?php echo $item['name'];?></p>
									<p style="margin: 0;">SKU:<?php echo $item['item_meta']['sku'][0]; ?></p>
					            	<p style="margin: 0;">QTY: <?php echo $qty;?></p>
					            	<?php if($product->get_dimensions() !=''){?>
										<p style="margin: 0;">Size: <?php echo $product->get_dimensions();?></p>
									<?php } ?>
								</td>
								<td width="30" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px; text-align: left;border-bottom:1px solid #e7edf8;">
									<?php echo $qty;?>
								</td> 
								<td width="150" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px; text-align: left;border-bottom:1px solid #e7edf8;">
									<?php echo '$'.$item_price;?>
								</td>
								<td width="150" style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px; text-align: left;border-bottom:1px solid #e7edf8;">
									<?php echo '$'.$item_total;?>	
								</td>
							</tr>
							<?php 				
									$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
								}
							?>
							<?php do_action( 'woocommerce_order_items_table', $order ); ?>
						</tbody>
						<tfoot>
							<?php
								foreach ( $order->get_order_item_totals() as $key => $total ) {
									if($key == 'shipping'){
										$total['value'] = get_post_meta($order->id,'cc_shipping_method',true);
									}
							?>
									<tr style="background-color:#e7edf8;">									<
										<td colspan="2"></td>
										<td style="font-family:Arial;font-size:12px;color:#666;text-transform:uppercase;padding:12px 15px;font-weight:bold; text-align: left;"><?php 
										 $label = rtrim($total['label'],":");
										 echo $label; ?></td>
										<td style="font-family:Arial;font-size:12px;color:#666;padding:12px 15px;text-align: left;"><?php echo ($total['value']); ?></td>
									</tr>
							<?php
								}
							?>
						</tfoot>
					</table>
				</td>
				<td width="40"></td>
			</tr>
		</table>
	</td>
</tr>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php if ( $show_customer_details ) : ?>
	<?php //wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
<?php endif; ?>
