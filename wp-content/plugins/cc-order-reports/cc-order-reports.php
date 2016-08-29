<?php 
/**
 * Carpetcall Woocommercre Orders Exporter
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Carpetcall Woocommercre Orders Exporter
 *
 * @wordpress-plugin
 * Plugin Name:       Carpetcall Woocommercre Orders Exporter
 * Description:       Carpetcall Woocommercre Orders Exporter
 * Version:           1.0.0
 * Author:            AITS
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       carpetcall
 * Domain Path:       /languages
 */
class CcOrderExport {

  /**
   * Constructor
   */
  public function __construct() {
    if (isset($_GET['export_orders'])) {
	$cc_order_report =  $this->cc_generate_order_report();
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
		  
		
     
	 /*
	  header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private", false);
      header("Content-Type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"OrderReport".strtotime('now').".csv\";");
      header("Content-Transfer-Encoding: binary");
      echo $csv;

	  */

      exit;
    }

// Add extra menu items for admins
    add_action('admin_menu', array($this, 'admin_menu'));

// Create end-points
    add_filter('query_vars', array($this, 'query_vars'));
    add_action('parse_request', array($this, 'parse_request'));
  }

  /**
   * Add extra menu items for admins
   */
  public function admin_menu() {
    add_submenu_page('woocommerce','Order Export', 'Export Last hour Orders', 'manage_options', 'export_recent_orders', array($this, 'export_recent_orders'));
  }

  /**
   * Allow for custom query variables
   */
  public function query_vars($query_vars) {
    $query_vars[] = 'export_recent_orders';
    return $query_vars;
  }

  /**
   * Parse the request
   */
  public function parse_request(&$wp) {
    if (array_key_exists('export_recent_orders', $wp->query_vars)) {
      $this->export_recent_orders();
      exit;
    }
  }

  /**
   * Download report
   */
  public function export_recent_orders() {
  
  
    echo '<div class="enquiry-details-csv-page"><h3>Click download to export Orders received in last hour in CSV</h3>';
    echo '<p><a href="?post_type=shop_order&export_orders=all">Download</a></p></div>';
  }

  /**
   * Creating Data for order Information
   */
  public function generate_order_report() {
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

$arrayCsv = array();
$arrayCsv[] = array(
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
$arrayCsv[] = array(
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
    endwhile;
$csv_output = '';
foreach($arrayCsv as $check):
          $csv_output[] =$check;
	endforeach;
    return $csv_output;
  }
  /**
   * Creating Data for order Items list
   */
  public function generate_order_item_list() {
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
$arrayCsv = array();
$arrayCsv[] = array(
					'Order Id',
					'Product Code',
					'Product Name',
					'Price',
					'Quantity'
					);
 
  while($loop->have_posts()):
            $loop->the_post();
			global $woocommerce;
			$order = new WC_Order(get_the_ID());
			foreach ($order->get_items() as $key => $lineItem) {
			if(get_post($lineItem['product_id'])){		
			$arrayCsv[] = array(
								get_the_ID(),
								get_post_meta($lineItem['product_id'],'_sku',true),
								$lineItem['name'],
								$lineItem['line_total'],
								$lineItem['qty']
								);
   			 }
			}
    endwhile;
$csv_output = '';
foreach($arrayCsv as $check):
          $csv_output[] =$check;
	endforeach;
    return $csv_output;  
	}





  public function cc_generate_order_report() {
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
     /*array(
           'after' => strtotime('-1 hour'),
           'before' => strtotime('now'),
		   'inclusive' => true,
           )
		  */
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



}

// Instantiate a singleton of this plugin
add_action('init' ,'cc_order_exporter_class');
function cc_order_exporter_class(){
  $OrderExportCsv = new CcOrderExport();

}
