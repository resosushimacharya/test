<?php
global $woocommerce, $product;


?>

<div class="delivery_option_rugs">
<div class="radiogroup_wrap">
	<div class="delivery_option_item">
    <?php 
	
	woocommerce_form_field("shipping_method", array(
    'type'              => 'radio',
	'required'			=> true,
    'options'           => array( 'store_pickup' => 'Pickup In Store' ),
), 'store_pickup' );

	?>
  <!--  
	<input type="radio" name="shipping_method" value="store_pickup" required>
    <label class="deliver_option_label">Pickup In Store</label>
	-->
    </div>

	<div class="delivery_option_item">
    <?php
    woocommerce_form_field("shipping_method", array(
    'type'              => 'radio',
	'required'			=>true,
    'options'           => array( 'local_delivery' => 'Local Delivery'),
), '' );
	
?>
   <!-- 
    <input type="radio" name="shipping_method" value="local_delivery" required>
    <label class="deliver_option_label">Local Delivery</label></div>
	-->
    </div>
</div>

	<div class="rugs_store_pickup_list">
	<?php get_template_part( 'templates/delivery/pickup_closest', 'office' );?>
	</div>

	<div class="shipping_needed_checkout" style="opacity:0; height: 0;overflow: hidden;"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
	
</div>
<script type="text/javascript">
jQuery(document).on('change','input[name="shipping_method"]',function(){
	if(jQuery(this).val() == 'local_delivery'){
			jQuery('.shipping_needed_checkout').css({'opacity': 1, 'height': 'auto', 'overflow': 'visible'});
			jQuery('.rugs_store_pickup_list').css({'opacity': 0, 'height': 0, 'overflow': 'hidden'});		
		}else{
			jQuery('.shipping_needed_checkout').css({'opacity': 0, 'height': 0, 'overflow': 'hidden'});
			jQuery('.rugs_store_pickup_list').css({'opacity': 1, 'height': 'auto', 'overflow': 'visible'});
		}
	});
</script>