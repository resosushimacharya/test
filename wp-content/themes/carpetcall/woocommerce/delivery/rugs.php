<?php
global $woocommerce, $product;


?>
<div class="delivery_option_rugs">
<input type="radio" name="shipping_method" value="store_pickup">Pickup In Store
<input type="radio" name="shipping_method" value="local_delivery">Local Delivery


<div class="rugs_store_pickup_list">
<?php get_template_part( 'templates/delivery/pickup_closest', 'office' );?>
</div>

<<div class="shipping_needed_checkout">?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
</div>
<script type="text/javascript">
jQuery(document).on('change','input[name="shipping_method"]',function(){
	if(jQuery(this).val() == 'pickup_n_deliver'){
		jQuery('.shipping_needed_checkout').show();
		jQuery('.rugs_store_pickup_list').hide();
		
		}else{
			jQuery('.shipping_needed_checkout').hide();
			jQuery('.rugs_store_pickup_list').show();
			}
	});
</script>