<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
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

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<div style="background-color:#FFF; border:1px solid #cfcfcf; border-top:0; width:598px; clear:both;">
            
            <div style="width:553px; height:15px; background-color:#f0f2f1; padding:29px 0 25px 45px; font-family: 'proxima_nova_ltsemibold', sans-serif; font-size:20px; color:#15489f; text-transform:uppercase; font-weight:bold;"> <?php _e( "THANK YOU FOR YOUR ORDER",'woocommerce' );?> </div><!-- thanks for order end -->
            </div>

<p><?php _e( "Your order has been received and is now being processed. Your order details are shown below for your reference:", 'woocommerce' ); ?></p>

<?php

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Emails::order_schema_markup() Adds Schema.org markup.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );?>
<div class="cc-bil-ship-woo-wrap clearfix">



<div class="col-sm-6 no-pr cc-checkout-sbadrs">
	<header class="title cc-bil-addr">
	<h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
</header>
<address>
	<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
</address>
</div>
<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>


	

<?php else: ?>
	<div class="col-sm-6 no-pl cc-checkout-sbadr">
		<header class="title cc-ship-adbill">
			<h3><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
		</header>
		<address>
			<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
		</address>
	</div>

<?php endif;?>
</div>

<?php


/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
