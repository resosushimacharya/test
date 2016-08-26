<div class="delivery_option_both">
<input type="radio" name="shipping_method" value="store_pickup" required>Pickup In Store(Rugs and Hard Flooring)
<input type="radio" name="shipping_method" value="pickup_n_deliver" required>Pickup Hard Flooring and Deliver Rugs


<?php get_template_part( 'templates/delivery/pickup_head', 'office' );?>

<div class="shipping_needed_checkout" style="display:none">
<?php do_action( 'woocommerce_checkout_shipping' ); ?>
</div>
</div>
<script type="text/javascript">
jQuery(document).on('change','input[name="shipping_method"]',function(){
	if(jQuery(this).val() == 'pickup_n_deliver'){
		jQuery('.shipping_needed_checkout').show();
		}else{
			jQuery('.shipping_needed_checkout').hide();
			}
	});
</script>