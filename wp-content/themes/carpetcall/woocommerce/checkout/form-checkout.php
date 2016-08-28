
<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col-1">
          <h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>
          <div class="collapsable collapse in" id="checkout_customer_details">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
              <div class="checkout_next_prev_button">
              <a href="#checkout_delivery">Next</a>
            </div>  
			<div class="clearfix"></div>
			<div class="col-2">
				<?php //do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
        </div>
		</div>
        <div class="col-1">
        <h3><?php _e( 'Delivery Options', 'woocommerce' ); ?></h3>
         <div class="collapse collapsable" id="checkout_delivery">
				<?php do_action('cc_checkout_delivery_custom_block'); ?>
              <div class="checkout_next_prev_button">
              <a href="#checkout_customer_details">Previous</a>
            </div><div class="checkout_next_prev_button">
              <a href="#checkout_payment">Next</a>
            </div>  <div class="clearfix"></div>
		</div>
        </div>
        <div class="col-1">
        <h3><?php _e( 'Payment Options', 'woocommerce' ); ?></h3>
        <div class="collapse collapsable" id="checkout_payment">
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
              <div class="checkout_next_prev_button">
              <a href="#checkout_payment">Previous</a>
            </div> 
            <div class="clearfix"></div> 
		</div>
        </div>
		
		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

<?php /* ?>
	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>


<?php */ ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script type="text/javascript">
jQuery(document).ready(function(e) {
    jQuery(document).on('click','.checkout_next_prev_button',function(){
		jQuery('.collapsable').removeClass('in');
		jQuery('div'+jQuery(this).find('a').attr('href')).addClass('in');
		});
});
</script>
