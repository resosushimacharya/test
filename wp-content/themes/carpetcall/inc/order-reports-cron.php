<?php
function hourly_order_export_func(){
/*$file = WP_CONTENT_DIR.'/mylog.txt';
$fh = fopen($file, "a");
$new_log= 'Order Export Cron started at '.date("Y-m-d H:i:s");
fwrite($fh, "\n"."\r".$new_log.PHP_EOL);
fclose($fh);
*/

$cc_order_report = cc_cron_generate_order_report();

if($cc_order_report !=''){
	$rugor = $cc_order_report['rugor'];
	$rugol = $cc_order_report['rugol'];
	$hfor = $cc_order_report['hfor'];
	$hfol = $cc_order_report['hfol'];
	
	$current_date_string = date( 'YmdHi', current_time( 'timestamp', 0 ));
	if($rugor && count($rugor) > 1){
		  $fp_order_report = fopen(WP_CONTENT_DIR.'/order-reports/ORRUGS'.$current_date_string.'.csv','w+');
				 foreach($rugor as $report){ 
				  fputcsv($fp_order_report,$report);
				 }
		 }
		
	if($hfor && count($hfor) > 1){
		  $fp_order_report = fopen(WP_CONTENT_DIR.'/order-reports/ORHARD'.$current_date_string.'.csv','w+');
				 foreach($hfor as $report){ 
				  fputcsv($fp_order_report,$report);
				 }
		 }
	 

	if($hfol && count($hfol) > 1){
		 $fp_order_list = fopen(WP_CONTENT_DIR.'/order-reports/OLHARD'.$current_date_string.'.csv','w+');
		  foreach($hfol as $report){ 
				 fputcsv($fp_order_list,$report);
				 }
		  }
	if($rugol && count($rugol) > 1){
		 $fp_order_list = fopen(WP_CONTENT_DIR.'/order-reports/OLRUGS'.$current_date_string.'.csv','w+');
		  foreach($rugol as $report){ 
				 fputcsv($fp_order_list,$report);
				 }
		  }	
	}
}
	
function cc_cron_generate_order_report(){
$args = array(
    'post_type'=>'shop_order',
    'posts_per_page'=>'-1',
    'post_status' => 'any',
	'meta_query'	=>array(
							array(
								'key'=>'cc_order_date',
								'value'=>array(strtotime('-1 hour'),strtotime('now')),
								'compare'=>'BETWEEN'
								)
	
							)
							
	
	/*'date_query' => array(
     array(
           'after' => date('Y/m/d H:i:s',strtotime('-1 hour')),
           'before' => date('Y/m/d H:i:s',strtotime('now')),
		   'inclusive' => true,
           )
     )
	 */
   );
$loop = new WP_Query($args);

if($loop->have_posts()){
$arrayCsv_rugs_or = $arrayCsv_hardflooring_or = array();
$arrayCsv_rugs_ol = $arrayCsv_hardflooring_ol = array();

$arrayCsv_rugs_ol[] = $arrayCsv_hardflooring_ol[] =array(
														'order id',
														'product code',
														'product name',
														'price',
														'quantity'
														);


$arrayCsv_rugs_or[] = $arrayCsv_hardflooring_or[] =array(
					'order id',
					'business name',
					'first name',
					'last name',
					'email',
					'phone',
					'delivery address 1',
					'delivery address 2',
					'delivery zip',
					'delivery state',
					'delivery city',
					'delivery country',
					'billing business name',
					'billing first name',
					'billing last name',
					'billing email',
					'billing phone',
					'billing address 1',
					'billing address 2',
					'billing zip',
					'billing state',
					'billing city',
					'billing country',
					'delivery option',
					'store id',
					'store_state',
					'store address',
					'grand total',
					'code',
					'shipping cost',
					'payment method',
					'status',
					'order status',
					'cc name',
					'cc type',
					'cc date',
					'cc num',
					'cc ccv',
					'time stamp',
					'payment number',
					'bank reference',
					'summary code',
					'response code',
					'response text',
					'payment time',
					'payment reference',
					'invoice',
					'payer id',
					'payment date',
					'payment status',
					'payer status',
					'txn id',
					'payment type',
					'receiver id',
					'receipt id',
					'status code',
					'status description',
					'response description',
					'atl',
					'comment'
					);
 
while($loop->have_posts()){
            $loop->the_post();
			global $woocommerce;
			 $order = new WC_Order(get_the_ID());
			 $selected_store = get_post_meta($order->id,'pickup_store_id',true);
			 $shipping_method = get_post_meta($order->id,'cc_shipping_method',true); 
			 if (strpos(strtolower($shipping_method), 'pickup') !== false) {
				 $shipping_method = 'pickup';
				 }else{
					 $shipping_method = 'deliver';
				}
			 $selected_store_meta = get_post_meta($selected_store);
			 foreach ($order->get_items() as $key => $lineItem) {
				$sku = $lineItem['sku'];
				
				$args = array(
						'post_type'=>'product',
						'post_status'=>'publish',
						'posts_per_page'=>1,
					   'meta_query' => array(
						   array(
							   'key' => '_sku',
							   'value' => $sku,
							   'compare' => '=',
						   )
					   )
					);
 			$product = get_posts($args);
			foreach($product as $post){
				setup_postdata($post);
						
				$terms = wp_get_object_terms( $post->ID, 'product_cat',array('fields'=>'slugs'));
				$terms_obj = wp_get_object_terms( $post->ID, 'product_cat');
				
				if(array_intersect(array('rugs'),$terms)){
					$arrayCsv_rugs_or[get_the_ID()] =array(
 					$order->id,
					$order->shipping_company,
					$order->shipping_first_name,
					$order->shipping_last_name,
					$order->shipping_email,
					$order->shipping_phone,
					$order->shipping_address_1,
					$order->shipping_address_2,
					$order->shipping_postcode,
					strtoupper(substr($order->shipping_state,0,1)),
					$order->shipping_city,
					'Australia',//$order->shipping_country,
					'',
					$order->billing_first_name,
					$order->billing_last_name,
					$order->billing_email,
					$order->billing_phone,
					$order->billing_address_1,
					$order->billing_address_2,
					$order->billing_postcode,
					strtoupper(substr($order->billing_state,0,1)),//$order->billing_state,
					$order->billing_city,
					'Australia',//$order->billing_country,
					$shipping_method,
					get_post_meta($selected_store,'store_id',true),
					strtoupper(substr($selected_store_meta['wpsl_state'][0],0,1)),
					$selected_store_meta['wpsl_address'][0],
					$order->order_total,
					'',//code
					0,
					$order->payment_method_title,
					'',//order status
					$order->get_status(),
					get_post_meta($order->id,'securepay_first_name',true).' '.get_post_meta($order->id,'securepay_last_name',true),
					get_post_meta($order->id,'securepay_cctype',true),//CC Type
					get_post_meta($order->id,'securepay_expmonth',true).'/'.get_post_meta($order->id,'securepay_expyear',true),//CC Date
					substr(get_post_meta($order->id,'securepay_cardno',true),-4),//CC Num
					get_post_meta($order->id,'securepay_cardcvv',true),//CC CCV
					date('d/M/Y, H:i:s',strtotime($order->order_date)),
					'',//payment number
					'',
					'',
					'',
					'',
					date('d/M/Y, H:i:s',strtotime($order->order_date)),
					$order->id,
					'',
					'',
					date('d/M/Y, H:i:s',strtotime($order->order_date)),
					'',
					'',
					$order->get_transaction_id(),
					'',//payment type
					'',
					'',
					'',
					'',
					'',
					get_post_meta($order->id,'atl',true),
					$order->customer_note
 					);
					
					
					$last_cat ='';
					if($terms){
						foreach($terms_obj as $term){
							if(is_last_cat($term->term_id)){
								$last_cat = $term->name;
								break;
								}
							}
						}
					
					$arrayCsv_rugs_ol[] = array(
									get_the_ID(),
									get_post_meta($post->ID,'_sku',true),
									strtoupper($last_cat),
									$lineItem['line_total'],
									$lineItem['qty']
									);
					}
				if(array_intersect(array('hard-flooring','accessories'),$terms)){
					$arrayCsv_hardflooring_or[get_the_ID()] = array(
 					$order->id,
					$order->shipping_company,
					$order->shipping_first_name,
					$order->shipping_last_name,
					$order->shipping_email,
					$order->shipping_phone,
					$order->shipping_address_1,
					$order->shipping_address_2,
					$order->shipping_postcode,
					strtoupper(substr($order->shipping_state,0,1)),
					$order->shipping_city,
					'Australia',//$order->shipping_country,
					'',
					$order->billing_first_name,
					$order->billing_last_name,
					$order->billing_email,
					$order->billing_phone,
					$order->billing_address_1,
					$order->billing_address_2,
					$order->billing_postcode,
					strtoupper(substr($order->billing_state,0,1)),//$order->billing_state,
					$order->billing_city,
					'Australia',//$order->billing_country,
					$shipping_method,
					get_post_meta($selected_store,'store_id',true),
					strtoupper(substr($selected_store_meta['wpsl_state'][0],0,1)),
					$selected_store_meta['wpsl_address'][0],
					$order->order_total,
					'',//code
					0,
					$order->payment_method_title,
					'',//order status
					$order->get_status(),
					'',//CC Name
					'',//CC Type
					'',//CC Date
					'',//CC Num
					'',//CC CCV
					date('d/M/Y, H:i:s',strtotime($order->order_date)),
					'',//payment number
					'',
					'',
					'',
					'',
					date('d/M/Y, H:i:s',strtotime($order->order_date)),
					'',
					'',
					'',
					'',
					'',
					'',
					$order->get_transaction_id(),
					'',//payment type
					'',
					'',
					'',
					'',
					'',
					get_post_meta($order->id,'atl',true),
					$order->customer_note
 					);
					$arrayCsv_hardflooring_ol[] = array(
									get_the_ID(),
									get_post_meta($post->ID,'_sku',true),
									strtoupper($lineItem['name']),
									$lineItem['line_total'],
									$lineItem['qty']
									);
					}
				 
				}
			}
	}
	
$HFOR = '';
$HFOL = '';
$RUGOR = '';
$RUGOL = '';
foreach($arrayCsv_hardflooring_or as $check){
          $HFOR[] =$check;
	}
foreach($arrayCsv_hardflooring_ol as $check){
          $HFOL[] =$check;
	}
foreach($arrayCsv_rugs_or as $check){
          $RUGOR[] =$check;
	}
foreach($arrayCsv_rugs_ol as $check){
          $RUGOL[] =$check;
	}
	
$ret = array('hfor'=>$HFOR,'hfol'=>$HFOL,'rugor'=>$RUGOR,'rugol'=>$RUGOL);	
	}else{
		$ret = '';
		}
return $ret;	
  
	}
?>