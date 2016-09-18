<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="quantity col-md-12">
    <?php
    $options = '';
    if(is_single()){
		if(has_term('rugs','product_cat',get_the_ID()) || has_term('hard-flooring','product_cat',get_the_ID())){
			$args['max_value'] =($args['max_value'] - get_option( 'woocommerce_notify_no_stock_amount' ) );
		}
      $options .='<option class= "col-md-12"'. ' value="PLEASE SELECT" id="sel_cart" hidden>PLEASE SELECT</option>';
      for ( $count = $args['min_value']; $count <= $args['max_value']; $count = $count+$args['step'] ) {
        $options .= '<option class= "col-md-12"'. ' value="' . $count . '" >' . $count . '</option>';
    } 
    if ( $options ){ ?>
    <select name="<?php echo esc_attr( $args['input_name'] ); ?>" id="quantity-control" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="qty col-md-12 selectpicker "><?php echo $options;?></select>
    <?php } else {
        printf( '%s <input type="hidden" name="%s" value="%s" />', $args['input_value'], $args['input_name'], $args['input_value'] );
    }
    } 
    else{
    for ( $count = $args['min_value']; $count <= $args['max_value']; $count = $count+$args['step'] ) {
        $options .= '<option' . selected( $args['input_value'], $count, false ) .' class= "col-md-12"'. ' value="' . $count . '" >' . $count . '</option>';
    }
	
	 
    if ( $options ){ ?>
    <select name="<?php echo esc_attr( $args['input_name'] ); ?>" id="quantity-control" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="qty col-md-12 selectpicker "><?php echo $options;?></select>
    <?php } else {
		if(true){
		$max = max(100,$args['input_value']);
		for ( $count = $args['min_value']; $count <= $max; $count = $count+$args['step'] ) {
        $options .= '<option' . selected( $args['input_value'], $count, false ) .' class= "col-md-12"'. ' value="' . $count . '" >' . $count . '</option>';
		}
		}
		else{
			
			}?>
		<select name="<?php echo esc_attr( $args['input_name'] ); ?>" id="quantity-control" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="qty col-md-12 selectpicker "><?php echo $options;?></select>
        <?php
        //printf( '%s <input type="hidden" name="%s" value="%s" />', $args['input_value'], $args['input_name'], $args['input_value'] );
    } 
    }?>
</div>
