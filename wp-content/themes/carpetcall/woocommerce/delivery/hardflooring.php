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
<?php 
$store_type = 'head_office';?>
<input type="hidden" name="store_type" value="<?php echo $store_type?>" id="store_type">
<div class="pickup_head_offices_list">

<?php 
include_once(get_template_directory().'/templates/delivery/pickup_head-office.php');?>
    <input type="hidden" name="store_type" value="<?php echo $store_type?>" id="store_type">

</div>
</div>


