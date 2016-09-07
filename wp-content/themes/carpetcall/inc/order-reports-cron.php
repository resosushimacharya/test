<?php
add_action( 'init', 'cc_create_order_export_schedule');
function cc_create_order_export_schedule(){
  //Use wp_next_scheduled to check if the event is already scheduled
  $timestamp = wp_next_scheduled( 'cc_order_export_daily_schedule' );
  //If $timestamp == false schedule daily backups since it hasn't been done previously
  if( $timestamp == false ){
    //Schedule the event for right now, then to repeat daily using the hook 'wi_create_daily_backup'
    wp_schedule_event(strtotime("+1 minutes"), 'hourly', 'cc_order_export_daily_schedule' );
  }
}


add_action( 'cc_order_export_daily_schedule', 'hourly_order_export_func' );
function hourly_order_export_func(){
$cc_order_report = cc_cron_generate_order_report();
	$rugor = $cc_order_report['rugor'];
	$rugol = $cc_order_report['rugol'];
	$hfor = $cc_order_report['hfor'];
	$hfol = $cc_order_report['hfol'];
	$current_date_string = date( 'YmdHi', current_time( 'timestamp', 0 ));
	if($rugor){
		  $fp_order_report = fopen(WP_CONTENT_DIR.'/order-reports/ORRUGS'.$current_date_string.'.csv','w+');
				 foreach($rugor as $report){ 
				  fputcsv($fp_order_report,$report);
				 }
		 }
		
	if($hfor){
		  $fp_order_report = fopen(WP_CONTENT_DIR.'/order-reports/ORHARD'.$current_date_string.'.csv','w+');
				 foreach($hfor as $report){ 
				  fputcsv($fp_order_report,$report);
				 }
		 }
	 

	if($hfol){
		 $fp_order_list = fopen(WP_CONTENT_DIR.'/order-reports/OLHARD'.$current_date_string.'.csv','w+');
		  foreach($hfol as $report){ 
				 fputcsv($fp_order_list,$report);
				 }
		  }
	if($rugol){
		 $fp_order_list = fopen(WP_CONTENT_DIR.'/order-reports/OLRUGS'.$current_date_string.'.csv','w+');
		  foreach($rugol as $report){ 
				 fputcsv($fp_order_list,$report);
				 }
		  }
	
	
	}
	
function cc_cron_generate_order_report(){
	
    /*$rows = array (
    array('aaa', 'bbb', 'ccc', 'dddd'),
    array('123', '456', '789'),
    array('"aaa"', '"bbb"')
);*/
$args = array(
    'post_type'=>'shop_order',
    'posts_per_page'=>'-1',
    'post_status' => 'any',
	'date_query' => array(
     array(
           'after' => strtotime('-1 hour'),
           'before' => strtotime('now'),
		   'inclusive' => true,
           )
		  
     )
	
   );
$loop = new WP_Query($args);
$arrayCsv_rugs_or = $arrayCsv_hardflooring_or = array();
$arrayCsv_rugs_ol = $arrayCsv_hardflooring_ol = array();

$arrayCsv_rugs_ol[] = $arrayCsv_hardflooring_ol[] =array(
														'Order Id',
														'Product Code',
														'Product Name',
														'Price',
														'Quantity'
														);


$arrayCsv_rugs_or[] = $arrayCsv_hardflooring_or[] =array(
					'Order Id',
					'Business Name',
					'First Name',
					'Last Name',
					'Email',
					'Phone',
					'Delivery Address 1',
					'Delivery Address 2',
					'Delivery Zip',
					'Delivery State',
					'Delivery City',
					'Delivery Country',
					'Billing Business Name',
					'Billing First Name',
					'Billing Last Name',
					'Billing Email',
					'Billing Phone',
					'Billing Address 1',
					'Billing Address 2',
					'Billing Zip',
					'Billing State',
					'Billing City',
					'Billing Country',
					'Delivery Option',
					'Store Id',
					'Store State',
					'Store Address',
					'Grand Total',
					'Code',
					'Shipping Cost',
					'Payment Method',
					'Status',
					'Order Status',
					'CC Name',
					'CC Type',
					'CC Date',
					'CC Num',
					'CC CCV',
					'Timestamp',
					'Payment Number',
					'Bank Reference',
					'Summary Code',
					'Response Code',
					'Response Text',
					'Payment Time',
					'Payment Reference',
					'Invoice',
					'Payer Id',
					'Payment Date',
					'Payment Status',
					'Payer Status',
					'Txn Id',
					'Payment Type',
					'Receiver Id',
					'Receipt Id',
					'Status Code',
					'Status Description',
					'Response Description',
					'ATL',
					'Comment'
					);
 
  while($loop->have_posts()):
            $loop->the_post();
			global $woocommerce;
			 $order = new WC_Order(get_the_ID());
			 $selected_store = get_post_meta($order->id,'pickup_store_id',true);
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
					$order->shipping_state,
					$order->shipping_city,
					$order->shipping_country,
					'',
					$order->billing_first_name,
					$order->billing_last_name,
					$order->billing_email,
					$order->billing_phone,
					$order->billing_address_1,
					$order->billing_address_2,
					$order->billing_postcode,
					$order->billing_state,
					$order->billing_city,
					$order->billing_country,
					$order->get_shipping_method(),
					$selected_store,
					$selected_store_meta['wpsl_state'][0],
					$selected_store_meta['wpsl_address'][0],
					$order->order_total,
					'',//code
					$order->get_total_shipping(),
					$order->payment_method_title,
					'',//order status
					$order->get_status(),
					'',//CC Name
					'',//CC Type
					'',//CC Date
					'',//CC Num
					'',//CC CCV
					strtotime($order->order_date),
					'',//payment number
					'',
					'',
					'',
					'',
					$order->order_date,
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
					'',
					$order->customer_note
 					);
					$arrayCsv_rugs_ol[] = array(
									get_the_ID(),
									get_post_meta($post->ID,'_sku',true),
									$lineItem['name'],
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
					$order->shipping_state,
					$order->shipping_city,
					$order->shipping_country,
					'',
					$order->billing_first_name,
					$order->billing_last_name,
					$order->billing_email,
					$order->billing_phone,
					$order->billing_address_1,
					$order->billing_address_2,
					$order->billing_postcode,
					$order->billing_state,
					$order->billing_city,
					$order->billing_country,
					$order->get_shipping_method(),
					$selected_store,
					$selected_store_meta['wpsl_state'][0],
					$selected_store_meta['wpsl_address'][0],
					$order->order_total,
					'',//code
					$order->get_total_shipping(),
					$order->payment_method_title,
					'',//order status
					$order->get_status(),
					'',//CC Name
					'',//CC Type
					'',//CC Date
					'',//CC Num
					'',//CC CCV
					strtotime($order->order_date),
					'',//payment number
					'',
					'',
					'',
					'',
					$order->order_date,
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
					'',
					$order->customer_note
 					);
					$arrayCsv_hardflooring_ol[] = array(
									get_the_ID(),
									get_post_meta($post->ID,'_sku',true),
									$lineItem['name'],
									$lineItem['line_total'],
									$lineItem['qty']
									);
					}
				 
				}
			}
    endwhile;
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
return $ret;	
  
	}
?>