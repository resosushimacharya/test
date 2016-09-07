<div class="delivery_option_hardflooring">
<div class="radiogroup_wrap">
<div class="delivery_option_item">
<?php
	woocommerce_form_field("cc_shipping_method", array(
    'type'              => 'radio',
	'required'			=> true,
    'options'           => array( 'store_pickup' => '<span>Pickup In Store(Rugs and Hard Flooring</span>' ),
), 'store_pickup' );

?>
<!--
<input type="radio" name="shipping_method" value="store_pickup" required><label class="deliver_option_label">Pickup In Store(Rugs and Hard Flooring)</label>

-->
</div>
</div>

<div class="pickup_head_offices_list"><?php get_template_part( 'templates/delivery/pickup_head', 'office' );?></div>
</div>


