<?php

$pid = get_the_ID();
$meta_arr = array();

$meta_arr[] = array('label'=>'Colour','value'=>get_post_meta($pid,'colour',true));
$meta_arr[] = array('label'=>'Price per pack','value'=>get_post_meta($pid,'price_per_pack',true));
$meta_arr[] = array('label'=>'Boards per pack','value'=>get_post_meta($pid,'boards_per_pack',true));
$meta_arr[] = array('label'=>'Coverage per pack','value'=>get_post_meta($pid,'coverage_per_pack',true));
$meta_arr[] = array('label'=>'Product - Length','value'=>get_post_meta($pid,'product_length',true));
$meta_arr[] = array('label'=>'Product - Width','value'=>get_post_meta($pid,'product_width',true));
$meta_arr[] = array('label'=>'Product - Thickness Veneer','value'=>get_post_meta($pid,'product_thickness_veneer',true));
$meta_arr[] = array('label'=>'Product - Thickness Total','value'=>get_post_meta($pid,'product_thickness_total',true));
$meta_arr[] = array('label'=>'Pack - Weight','value'=>get_post_meta($pid,'product_weight',true));
?>

<div class="hf_meta_block-wrapper">
<?php foreach($meta_arr as $meta){
	if($meta['value'] == '') 
	continue;
	?>
<div class="col-md-12">
<span class="meta_label"><?php _e($meta['label'],'carpetcall')?></span>:<span class="meta_value"><?php _e($meta['value'],'carpetcall')?></span>
</div><?php	}
?>
</div>