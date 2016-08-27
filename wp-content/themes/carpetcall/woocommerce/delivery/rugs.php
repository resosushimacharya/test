<?php
global $woocommerce, $product;


?>
<div class="delivery_option_rugs">
<input type="radio" name="shipping_method" value="store_pickup" required>Pickup In Store
<input type="radio" name="shipping_method" value="local_delivery" required>Local Delivery


<div class="rugs_store_pickup_list" style="display:none">
<?php get_template_part( 'templates/delivery/pickup_closest', 'office' );?>
</div>

<div class="shipping_needed_checkout" style="display:none"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
</div>
<script type="text/javascript">
jQuery(document).on('change','input[name="shipping_method"]',function(){
	if(jQuery(this).val() == 'local_delivery'){
		jQuery('.shipping_needed_checkout').show();
		jQuery('.rugs_store_pickup_list').hide();
		
		}else{
			jQuery('.shipping_needed_checkout').hide();
			jQuery('.rugs_store_pickup_list').show();
			}
	});
</script>