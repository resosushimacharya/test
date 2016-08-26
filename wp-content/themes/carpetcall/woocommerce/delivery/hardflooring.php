<div class="delivery_option_hardflooring">
<input type="radio" name="shipping_method" value="store_pickup">Pickup In Store(Rugs and Hard Flooring)

<div class="pickup_head_offices_list"><?php get_template_part( 'templates/delivery/pickup_head', 'office' );?></div>
</div>

<script type="text/javascript">
jQuery(document).on('change','input[name="shipping_method"]',function(){
	if(jQuery(this).val() == 'store_pickup'){
		jQuery('.pickup_head_offices_list').show();
		}else{
			jQuery('.pickup_head_offices_list').hide();
			}
	});
</script>