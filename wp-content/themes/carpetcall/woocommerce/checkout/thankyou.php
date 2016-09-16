<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p class="woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

		<p class="woocommerce-thankyou-order-failed-actions">
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		
         <header class="title"><h3>ORDER #<?php echo $order->get_order_number(); ?></h3></header>
          <header class="title cc-checkout-title"><h3>CUSTOMER DETAILS</h3></header>
		<ul class="cc-woocommerce-thankyou-order-details cc-order_details">
		<li class="cc-woo-order-email">
				<?php _e( 'Email:', 'woocommerce' ); ?>
				<?php echo $order->billing_email; ?>
			</li>
			<li class="cc-woo-order-phone">
				<?php _e( 'Tel:', 'woocommerce' ); ?>
				<?php echo $order->billing_phone; ?>
			</li>
			<li class="order">
		    Order Number: #<?php echo $order->get_order_number(); ?>
			</li>
			<li class="date">
				<?php _e( 'Order Date:', 'woocommerce' ); ?>
				<?php 
$datetimearr =explode(' ',$order->order_date);
$datearr =explode('-',$datetimearr[0]);

$date = $datearr[2].'/'.$datearr[1].'/'.$datearr[0];



 ?>
				<?php echo $date; ?>
			</li>
			
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php _e( 'Payment Method:', 'woocommerce' ); ?>
			<?php echo $order->payment_method_title; ?>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>
<div class="cc-bil-ship-woo-wrap clearfix">
<?php $where =  get_post_meta($order->id,'cc_shipping_method',true);  ?>

<?php if ( !wc_ship_to_billing_address_only() || $order->needs_shipping_address()) : ?>
<?php if(strcasecmp('Pickup From Head Offices',$where)!=0){ ?>
<div class="col-sm-6 no-pl cc-checkout-sbadr">
		<header class="title cc-ship-adbill">
			<h3><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
		</header>
		<address>
			<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
		</address>
	</div><?php } ?> <?php endif; ?>

<div class="col-sm-6 no-pr cc-checkout-sbadrs">
	<header class="title cc-bil-addr">
	<h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
</header>
<address>
	<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
</address>
</div>



	
</div>



<?php else : ?>

	<p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
