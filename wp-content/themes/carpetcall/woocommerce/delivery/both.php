<div class="delivery_option_both">
	<div class="radiogroup_wrap">
		<div class="delivery_option_item">
			<?php
				woocommerce_form_field("cc_shipping_method", array(
				'type'              => 'radio',
				'required'			=> true,
				'options'           => array( 'store_pickup' => '<span>Pickup In Store(Rugs and Hard Flooring)</span>' ),
			), 'store_pickup' );
			
			?> 
		</div>
		<div class="delivery_option_item">
				<?php
				woocommerce_form_field("cc_shipping_method", array(
				'type'              => 'radio',
				'required'			=>true,
				'options'           => array( 'pickup_n_deliver' => '<span>Pickup Hard Flooring and Deliver Rugs</span>' ),
			), '' );
			
			?>			
		</div>
	</div>

	<?php get_template_part( 'templates/delivery/pickup_head', 'office' );?>

	<div class="shipping_needed_checkout" style="display:none">
		<?php do_action( 'woocommerce_checkout_shipping' ); ?>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).on('change','input[name="cc_shipping_method"]',function(){
		jQuery('#checkout_delivery #pickup_error_msg').hide();
		if(jQuery(this).val() == 'pickup_n_deliver'){
			jQuery('.shipping_needed_checkout').show();
		}else{
			jQuery('.shipping_needed_checkout').hide();
		}
	});
</script>