<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>
<div class="woocommerce-billing-fields">

<?php /*?>
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>

	<?php endif; ?>
    
    
<?php */?>
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
<p class="req_info_wrap"><span class="required" title="required">* </span><span class="req_text">Required Field</span></p>
<div class="billing_fields_wrapper">
	<?php foreach ( $checkout->checkout_fields['billing'] as $key => $field ) :?>
		<?php 
		/*
		$field['placeholder'] = '';
		do_action('pr',$key);
		do_action('pr',$field);
		if($key == 'billing_address_1'){
			$field['label'] = 'Address Line 1';
			$field['placeholder'] = '';
			}
		if($key == 'billing_address_2'){
			$field['label'] = 'Address Line 2';
			$field['placeholder'] = '';
			}
		if($key == 'billing_first_name'){
			$field['placeholder'] = 'EG JOHN';
			}
		if($key == 'billing_last_name'){
			$field['placeholder'] = 'EG SMITH';
			}
		if($key == 'billing_company'){
			$field['placeholder'] = 'EG CARPET CALL';
			}
		if($key == 'billing_email'){
			$field['placeholder'] = 'EG JOHN@CARPETCALL.COM.AU';
			}
			*/
		?>
		<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

	<?php endforeach; ?>
</div>
	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

<?php /* ?>

	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

		<?php if ( $checkout->enable_guest_checkout ) : ?>

			<p class="form-row form-row-wide create-account">
				<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>

			<div class="create-account">

				<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

				<?php endforeach; ?>

				<div class="clear"></div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
	
<?php */ ?>
</div>
