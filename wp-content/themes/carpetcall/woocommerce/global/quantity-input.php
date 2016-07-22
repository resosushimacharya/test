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
      $options .='<option class= "col-md-12"'. ' value="PLEASE SELECT" id="sel_cart">PLEASE SELECT</option>';
      for ( $count = $args['min_value']; $count <= $args['max_value']; $count = $count+$args['step'] ) {
        $options .= '<option class= "col-md-12"'. ' value="' . $count . '" >' . $count . '</option>';
    } 
    if ( $options ){ ?>
    <select name="<?php echo esc_attr( $args['input_name'] ); ?>" id="quantity-control" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="qty col-md-12 selectpicker " /><?php echo $options;?></select>
    <?php } else {
        printf( '%s <input type="hidden" name="%s" value="%s" />', $args['input_value'], $args['input_name'], $args['input_value'] );
    }
    } 
    else{

    
    for ( $count = $args['min_value']; $count <= $args['max_value']; $count = $count+$args['step'] ) {
        $options .= '<option' . selected( $args['input_value'], $count, false ) .' class= "col-md-12"'. ' value="' . $count . '" >' . $count . '</option>';
    } 
    if ( $options ){ ?>
    <select name="<?php echo esc_attr( $args['input_name'] ); ?>" id="quantity-control" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="qty col-md-12 selectpicker " /><?php echo $options;?></select>
    <?php } else {
        printf( '%s <input type="hidden" name="%s" value="%s" />', $args['input_value'], $args['input_name'], $args['input_value'] );
    } 
    }?>
</div>
<script>
$ = jQuery.noConflict();
$(document).ready(function() {
 $('#sel_cart').attr('selected','selected');
        $loadref=$('#store-count-quantity').attr('href');
        $('#store-count-quantity').attr('href','javascript:void(0)');
          $('#store-count-quantity').removeClass('add_to_cart_button');
           $('#store-count-quantity').removeClass('ajax_add_to_cart');
        
          
       $(document).on('change','#quantity-control',function(){
          $stoq = $('#quantity-control').val();           
           
              if($stoq.toLowerCase()!='please select'){
         $('#store-count-quantity').attr('href',$loadref);

          $('#store-count-quantity').addClass('add_to_cart_button');
           $('#store-count-quantity').addClass('ajax_add_to_cart');
            $(".add_to_cart_button").attr('data-quantity',$stoq);
              $(".add_to_cart_button").data('quantity',$stoq);
         }
         else{
           /*  $('#store-count-default').show();
          $('#store-count-quantity').hide();*/
         $('#store-count-quantity').attr('href','javascript:void(0)');
          $('#store-count-quantity').removeClass('add_to_cart_button');
           $('#store-count-quantity').removeClass('ajax_add_to_cart');
           
         }
       
        

          });
     


     });


</script>
<style>
     #quantity-control{width: 60%;}
     .cc-quantiy-section
     {
      margin-top:5px;
      margin-bottom:5px;
     }
     .cc-size-section{
      margin-top:5px;
      margin-bottom:5px;
     }
     .cc-quantiy-section-inner
     {
       margin-top:5px;
      margin-bottom:5px;
      }
      .quantity{
        margin-top:5px;
      margin-bottom:5px;
      }
      .mod-social , .mod-social a{float:left;padding-right:5px;}

</style>