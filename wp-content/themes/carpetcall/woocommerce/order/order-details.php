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
<header class="title cc-checkout-od">
<h3><?php _e( 'Order Details', 'woocommerce' ); ?></h3></header>
<table class="shop_table order_details cc-checkkout-details-ord">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'QTY', 'woocommerce' ); ?></th>
            <th class="product-total"><?php _e( 'PRICE', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		
		$_pf = new WC_Product_Factory(); 
			foreach( $order->get_items() as $item_id => $item ) {
			
            	
				

				$id = $item['item_meta']['_product_id'][0];

				
				$item_price = get_post_meta($id ,'_price',true);
				$item_price = number_format($item_price, 2);
			  
			
			  
				$qty = $item['item_meta']['_qty'][0];
				$sku= $item['item_meta']['sku'][0];
				$item_total = $item['item_meta']['_line_total'][0];
				$item_total = number_format($item_total, 2);
				?>
				<tr class="order_item">
					<td><?php echo $item['name'];?>
					<span>SKU:<?php echo $item['item_meta']['sku'][0]; ?></span>
					</td>
					<td><?php echo $qty;?></td> 
					<td><?php echo '$'.$item_price;?></td>
					<td><?php echo '$'.$item_total;?></td>
				</tr>
				<?php 
				
				$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
/*
				wc_get_template( 'order/order-details-item.php', array(
					'order'			     => $order,
					'item_id'		     => $item_id,
					'item'			     => $item,
					'show_purchase_note' => $show_purchase_note,
					'purchase_note'	     => $product ? get_post_meta( $product->id, '_purchase_note', true ) : '',
					'product'	         => $product,
				) );*/
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
				<tr class="mod-table-calc-res"><td></td>
					<td><?php 
					 $label = rtrim($total['label'],":");
					 echo $label; ?></td>
					<td></td>
					<td><?php echo $total['value']; ?></td>
				</tr>
				<?php
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php if ( $show_customer_details ) : ?>
	<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
<?php endif; ?>
