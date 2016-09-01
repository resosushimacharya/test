
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

<div class="checkout-main-form-cntr">
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="col-1 checkout-form-sec billing-details-cntr">
	          <h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>
	          <div class="collapse collapsable in clearfix billing-form" id="checkout_customer_details">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
	            <div class="checkout_next_prev_button read_more">
	              <a class="next fetch_locations" href="#checkout_delivery">Next</a>
	            </div> 		            			
	       	  </div>
			</div>

	        <div class="col-1 checkout-form-sec delivery-options-cntr">
		         <h3><?php _e( 'Delivery Options', 'woocommerce' ); ?></h3>
		         <div class="collapse collapsable clearfix delivery-form" id="checkout_delivery">
						<?php do_action('cc_checkout_delivery_custom_block'); ?>

		            <div class="checkout_next_prev_button read_more">
		              <a href="#checkout_customer_details">Previous</a>
		              <a class="next" href="#checkout_payment">Next</a>
		            </div>
		            	            
				</div>
	        </div>

	        <div class="col-1 checkout-form-sec payment-options-cntr">
		        <h3><?php _e( 'Payment Options', 'woocommerce' ); ?></h3>
		        <div class="collapse collapsable clearfix payment-form" id="checkout_payment">
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
		            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
		            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
		             <div class="checkout_next_prev_button read_more">
		              <a href="#checkout_delivery">Previous</a>
		            </div> 		             
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
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script type="text/javascript">
jQuery(document).ready(function(e) {
    jQuery(document).on('click','.checkout_next_prev_button a',function(e){
    	e.preventDefault();
		var error_flag = false;
		if(jQuery(this).hasClass('fetch_locations')){
			var address = jQuery('#billing_postcode').val()+', '+jQuery('#billing_address_2').val()+', '+jQuery('#billing_address_1').val()+', '+jQuery('#billing_city').val()+', '+jQuery('#billing_state').val()+', '+jQuery('#billing_country').val();
			jQuery('#edit_dialog_keyword').val(address);
			jQuery('#checkout_fetch_nearby_stores').trigger('click');
			};
		if(jQuery(this).hasClass('next')){
			var validator = jQuery( ".checkout.woocommerce-checkout" ).validate();
			jQuery(this).parents('.checkout-form-sec').find('p.validate-required').find('input:visible').each(function(index, el) {
				validator.element("#"+el.id);
				console.log(el.id+'-->'+validator.element("#"+el.id));
				if(jQuery(el).parent('.form-row').hasClass('woocommerce-invalid')){
					error_flag = true;
					jQuery('#'+el.id).focus();
					}
				});
			}
		if(error_flag){
				return false;
				}else{
					jQuery('.collapsable').removeClass('in');
					jQuery('div'+jQuery(this).attr('href')).addClass('in');
				}

		});
});
</script>
