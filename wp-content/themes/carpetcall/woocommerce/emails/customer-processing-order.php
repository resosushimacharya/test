<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
  <tr>
    <td colspan="3" style="border:1px solid #cfcfcf; border-top:0; border-bottom:0; background-color:#f0f2f1;">
    <div style="background-color:#f0f2f1;  font-family: 'proxima_nova_ltsemibold', sans-serif; font-size:20px; color:#15489f; text-transform:uppercase; font-weight:bold; margin:29px 0 25px 45px;"> THANK YOU FOR YOUR ORDER </div>
    </td>
  </tr><!-- thank you for order end -->
  
  <tr>
    <td colspan="3" style="border:1px solid #cfcfcf; border-top:0; border-bottom:0;">
    <table width="504px" border="0" cellspacing="0" cellpadding="0" style="width:504px; margin:0 49px 0 45px;">
      <tr style="border:0;">
        <td colspan="3"><p style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666666; margin-top:29px; clear:both;">Your order has been received and is now being processed. Your order details are shown below for your reference. </p></td>
        </tr>
        
      <tr>
        <td style="width:420px;">
        <h1 style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#15489f; font-weight:bold; margin:30px 0 10px 0; clear:both;"> CUSTOMER DETAILS </h1>
<p style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:10px; color:#15489f; line-height:13px; margin:0;">
<span style="font-weight:bold;">Email:</span> <?php echo $order->billing_email; ?><br>
<span style="font-weight:bold;">Tel:</span> <?php echo $order->billing_phone; ?><br>
<span style="font-weight:bold;">Order:</span> #<?php echo $order->get_order_number(); ?><br>
<?php 
$datetimearr =explode(' ',$order->order_date);
$datearr =explode('-',$datetimearr[0]);

$date = $datearr[2].'/'.$datearr[1].'/'.$datearr[0];



 ?>
<span style="font-weight:bold;">Order Date:</span> <?php echo $date; ?>
<?php //do_action('pr',$order->order_date);?>
</p>

        
        </td>

        <td>&nbsp;</td>
      </tr>
      
      <tr>
    
<?php $where =  get_post_meta($order->id,'cc_shipping_method',true);  ?>

 <?php if ( !wc_ship_to_billing_address_only() || $order->needs_shipping_address()) : ?>
<?php if(strcasecmp('Pickup From Head Offices',$where)!=0){ ?>
        <td style="width:252px;">
        <h2 style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666666; margin:35px 0 0 0; text-transform:uppercase;"> Shipping Address</h2>
                        <span style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666666; margin:0;">Your order has been delivered to: </span>
                        <div style="border-bottom:1px solid #e7edf8; margin:5px 20% 10px 0;"></div>
<p style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:10px; color:#666; line-height:13px; text-decoration:none; margin:0;">
<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
</p>
                       
        </td><?php } ?> <?php endif; ?>
        <td style="width:252px;">
        <h2 style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666666; margin:35px 0 0 0; text-transform:uppercase;"> Billing Address</h2>
                        <span style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666666; margin:0;">Your order will be billed to: </span>
                        <div style="border-bottom:1px solid #e7edf8; margin:5px 20% 10px 0; "></div>
<p style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:10px; color:#666; line-height:13px; text-decoration:none; margin:0;">
<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
</p> 
        </td>
      </tr>
      
      <tr>

				 
				
        <td colspan="3" style="padding-top:30px;">
        <table width="504" border="0" cellspacing="0" cellpadding="0" style="width:504px;">
                      <tr style="background-color:#e7edf8;">
                        <td width="171" style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666; text-transform:uppercase; padding:12px 15px; font-weight: bold;">Product</td>
                        <td width="30" style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666; text-transform:uppercase; padding:12px 15px; font-weight: bold;">Qty</td>
                        <td width="158" style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666; text-transform:uppercase; padding:12px 15px; font-weight: bold;">Price</td>
                        <td width="145" style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666; text-transform:uppercase; padding:12px 15px; font-weight: bold;">Total</td>
                      </tr>
                      <?php

		
		$_pf = new WC_Product_Factory(); 
			foreach( $order->get_items() as $item_id => $item ) {
			
            	
				

				$id = $item['item_meta']['_product_id'][0];

				
				$item_price = get_post_meta($id ,'_price',true);
				$item_price = number_format(round($item_price), 2);
			  
			
			  
				$qty = $item['item_meta']['_qty'][0];
				$sku= $item['item_meta']['sku'][0];
				$item_total = $item['item_meta']['_line_total'][0];
				$item_total = number_format(round($item_total), 2);
				$product = new WC_Product($id);?>
                      <tr>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; border-bottom:1px solid #e7edf8;"><?php echo $item['name'];?><span style="display:block;">SKU: <?php echo $item['item_meta']['sku'][0]; ?></span></td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; border-bottom:1px solid #e7edf8;"><?php echo $qty;?></td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; border-bottom:1px solid #e7edf8;"><?php echo '$'.$item_price;?></td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; border-bottom:1px solid #e7edf8;"><?php echo '$'.$item_total;?></td>
                      </tr>
                      <?php } ?>

                    <?php 
                    $product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
                    do_action( 'woocommerce_order_items_table', $order ); ?>
                      <!--   total start-->
                      <?php
		
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				if($key == 'shipping'){
					$total['value'] = get_post_meta($order->id,'cc_shipping_method',true);
					}
				?>
				
				
                  
                    <?php if($key == 'cart_subtotal'){ ?>
                       <tr>
                        <td colspan="3" rowspan="3">&nbsp;</td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; text-transform:uppercase; font-weight:bold;">subtotal</td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px;"><?php echo ($total['value']); ?></td>
                      </tr>
                      <?php } ?>
                       <?php if($key == 'shipping'){ ?>
                      <tr>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; text-transform:uppercase; font-weight:bold;">shipping</td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px;"><?php echo ($total['value']); ?></td>
                      </tr>
                      <?php } ?>
                       <?php if($key == 'payment_method'){ ?>
                      <tr>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; text-transform:uppercase; font-weight:bold;">PAYMENT METHOD</td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px;"><?php echo ($total['value']); ?></td>
                      </tr>
                        <?php } ?>
                        <?php if($key == 'order_total'){ ?>
                      <tr style="background-color:#e7edf8;">
                        <td colspan="3" style="background-color: #e7edf8; padding:12px 15px;">&nbsp;</td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px; text-transform:uppercase; font-weight:bold;">TOTAL</td>
                        <td style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;  padding:12px 15px;"><?php echo ($total['value']); ?></td>
                      </tr><?php } ?>
                      <?php
                     
			}
		?>
                 <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>     
                     
                       <!--   total end-->
                    </table>
                    
        </td>
        </tr>
        
      <tr>
        <td colspan="3">
        <?php if($order->customer_message){ ?>
        <div style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666; text-transform:uppercase; border-bottom:1px solid #e7edf8; padding-bottom:8px; margin-bottom:6px; margin-top:36px;">ADDITIONAL COMMENTS OR INSTRUCTIONS</div>
                <span style="font-family:Arial, Gotham, 'Helvetica Neue', Helvetica, sans-serif; font-size:12px; color:#666;"><?php echo $order->customer_message; ;?></span>
                <?php }?>
        </td>
        </tr>
        
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      
    </table>
    </td>
  </tr>


<?php


/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
