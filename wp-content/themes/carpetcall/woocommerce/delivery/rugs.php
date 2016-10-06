<?php
global $woocommerce, $product;


?>

<div class="delivery_option_rugs">
<div class="radiogroup_wrap">
	<div class="delivery_option_item">
    <?php 
	
	woocommerce_form_field("cc_shipping_method", array(
    'type'              => 'radio',
	'required'			=> true,
    'options'           => array( 'store_pickup' => '<span>Pickup In Store</span>' ),
), 'store_pickup' );

	?>
  <!--  
	<input type="radio" name="shipping_method" value="store_pickup" required>
    <label class="deliver_option_label">Pickup In Store</label>
	-->
    </div>

	<div class="delivery_option_item">
    <?php
    woocommerce_form_field("cc_shipping_method", array(
    'type'              => 'radio',
	'required'			=>true,
    'options'           => array( 'local_delivery' => '<span>Local Delivery</span>'),
), '' );
	
?>
   <!-- 
    <input type="radio" name="shipping_method" value="local_delivery" required>
    <label class="deliver_option_label">Local Delivery</label></div>
	-->
    </div>
</div>
<?php 
$store_type = 'owned_store';?>
<input type="hidden" name="store_type" value="<?php echo $store_type?>" id="store_type">
	<div class="rugs_store_pickup_list">
    
	<?php 
	//$store_type = 'head_office';
	include_once(get_template_directory().'/templates/delivery/pickup_closest-office.php');
	//get_template_part( 'templates/delivery/pickup_closest', 'office' );?>
	</div>
    

	<div class="shipping_needed_checkout" style="opacity:0; height: 0;overflow: hidden; visibility:hidden">
	<div class="atl_wrap">
            <input type="checkbox" name="atl" id="atl">
            <label>Authority to Leave See <a href="<?php echo site_url()?>/terms-and-conditions/">Terms and Conditions</a> for Full Details</label>
        </div>
		<?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
	
</div>
<script type="text/javascript">
jQuery(document).on('change','input[name="cc_shipping_method"]',function(){
	jQuery('#checkout_delivery #pickup_error_msg').hide();
	if(jQuery(this).val() == 'local_delivery'){
			jQuery('.shipping_needed_checkout').css({'opacity': 1, 'height': 'auto', 'overflow': 'visible','visibility':'visible'});
			jQuery('.rugs_store_pickup_list').css({'opacity': 0, 'height': 0, 'overflow': 'hidden','visibility':'hidden'});		
		}else{
			jQuery('.shipping_needed_checkout').css({'opacity': 0, 'height': 0, 'overflow': 'hidden','visibility':'hidden'});
			jQuery('.rugs_store_pickup_list').css({'opacity': 1, 'height': 'auto', 'overflow': 'visible','visibility':'visible'});
		}
	});
</script>