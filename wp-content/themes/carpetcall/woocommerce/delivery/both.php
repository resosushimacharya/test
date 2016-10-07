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
        <?php 
$store_type = 'head_office';?>
<input type="hidden" name="store_type" value="<?php echo $store_type?>" id="store_type">
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

	<?php 
	include_once(get_template_directory().'/templates/delivery/pickup_head-office.php');?>
	<div class="shipping_needed_checkout" style="display:none">
    	<div class="atl_wrap">
            <input type="checkbox" name="atl" id="atl">
            <label>Authority to Leave See <a href="<?php echo site_url()?>/terms-and-conditions/">Terms and Conditions</a> for Full Details</label>
        </div>
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