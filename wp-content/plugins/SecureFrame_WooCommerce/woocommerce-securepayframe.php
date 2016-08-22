<?php
/*
Plugin Name: Woocommerce SecurePay-SecureFrame Payment Gateway
Plugin URI: http://www.securepay.com.au
Description: This plugin extends the woocommerce payment gateways to add in SecurePay-SecureFrame gateway.
Version: 1.0.1
Author: SecurePay
Author URI: http://www.securepay.com.au
*/


/*  Copyright 2012  SydneyEcommerce  (email : sydneyecommerce@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
*/


/* Add a custom payment class to woocommerce
------------------------------------------------------------ */
if(isset($_POST['order-received'])){
	$query_string = '?';
	foreach($_POST as $key=>$value){
		$query_string .= "$key=$value&";
	}
	
	header("location:".get_site_url().$query_string);exit;
}
add_action( 'plugins_loaded', 'woocommerce_securepayframe_init', 0 );
function woocommerce_securepayframe_init() {
    
    if ( !class_exists( 'WC_Payment_Gateway' ) ) return; // if the Woocommerce payment gateway class is not available, do nothing
	
		class WC_Gateway_SecurePayFrame extends WC_Payment_Gateway {
		
		public function __construct() {
        	$this->id				= 'securepayframe';
        	$this->icon 			= WP_PLUGIN_URL . "/" . plugin_basename( dirname(__FILE__)) . '/images/logo.png';
        	$this->has_fields 		= false;
			$this->method_title     = __( 'SecurePay', 'woocommerce' );
			
			$this->supports           = array(
				'products',
				'refunds'
			);
			
			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();
			
			$this->surcharge = get_option( 'woocommerce_securepay_surcharge',
					array(
						'surcharge'   => $this->get_option( 'surcharge' ),
						'surcharge_visa' => $this->get_option( 'surcharge_visa' ),
						'surcharge_visa_value'      => $this->get_option( 'surcharge_visa_value' ),
						'surcharge_mastercard'      => $this->get_option( 'surcharge_mastercard' ),
						'surcharge_mastercard_value'           => $this->get_option( 'surcharge_mastercard_value' ),
						'surcharge_amex'            => $this->get_option( 'surcharge_amex' ),
						'surcharge_amex_value'            => $this->get_option( 'surcharge_amex_value' )
					)
			);
	
			// Define user set variables
			$this->title 		= $this->get_option( 'title' );
			$this->description  = $this->get_option( 'description' );
			$this->merchant_id   = $this->get_option( 'merchant_id' );
			$this->transaction_password   = $this->get_option( 'transaction_password' );
			$this->enviroment   = $this->get_option( 'enviroment' );
			
			$this->currency   = $this->get_option( 'currency' );
			$this->display_cardholder_name   = $this->get_option( 'display_cardholder_name' );
			$this->display_securepay_receipt   = $this->get_option( 'display_securepay_receipt' );
			
			$this->template_type   = $this->get_option( 'template_type' );
			$this->iframe_width   = $this->get_option( 'iframe_width' );
			$this->iframe_height   = $this->get_option( 'iframe_height' );
			$this->transaction_type   = $this->get_option( 'transaction_type' );

			$this->test_gateway_url   = 'https://payment.securepay.com.au/test/v2/invoice';
			$this->live_gateway_url   = 'https://payment.securepay.com.au/live/v2/invoice';
			
			$this->notify_url         = WC()->api_request_url( 'WC_Gateway_SecurePayFrame' );

			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( &$this, 'process_admin_options' ) );
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'save_surcharge' ) );

			add_action( 'woocommerce_api_wc_gateway_' . $this->id, array( &$this, 'check_notify_response' ) );
			add_action('woocommerce_receipt_' . $this->id, array(&$this, 'receipt_page'));
			
			add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
    	}
		
		function init_form_fields() {
    		$this->form_fields = array(
			'enabled' => array(
							'title' => __( 'Enable/Disable', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Enable SecurePay Frame Payment', 'woocommerce' ),
							'default' => 'yes'
						),
			'title' => array(
							'title' => __( 'Title', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Pay with SecurePay', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'description' => array(
							'title' => __( 'Customer Message', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Give the customer instructions for paying via Secure Frame.', 'woocommerce' ),
							'default' => __( 'Content here', 'woocommerce' )
						),
			'merchant_id' => array(
							'title' => __( 'Merchant ID', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => ''
						),
			'transaction_password' => array(
							'title' => __( 'Transaction Password', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => ''
						),
			'currency' => array(
							'title' => __( 'Currency', 'woocommerce' ),
							'type' => 'text',
							'description' => '3 digits, eg: AUD',
							'default' => 'AUD'
						),
			'display_cardholder_name' => array(
							'title' => __( 'Display Cardholder Name', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Display Cardholder Name', 'woocommerce' ),
							'default' => 'yes'
						),
			'display_securepay_receipt' => array(
							'title' => __( 'Display SecurePay Receipt Page', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Display SecurePay Receipt Page', 'woocommerce' ),
							'default' => 'no'
						),
			'template_type' => array(
							'title' => __( 'Template Type', 'woocommerce' ),
							'type' => 'select',
							'description' => '',
							'default' => 'iframe',
							'options' => array(
								  'iframe' => 'Iframe',
								  'default' => 'Default'
							 )
						),
			'iframe_width' => array(
							'title' => __( 'Iframe width', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => '500'
						),
			'iframe_height' => array(
							'title' => __( 'Iframe height', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => '300'
						),
			'transaction_type' => array(
							'title' => __( 'Transaction Type', 'woocommerce' ),
							'type' => 'select',
							'description' => '',
							'default' => '1',
							'options' => array(
								  '0' => 'PAYMENT',
								  '1' => 'PREAUTH',
								  '2' => 'PAYMENT with FRAUDGUARD',
								  '3' => 'PREAUTH with FRAUDGUARD',
								  '4' => 'PAYMENT with 3D Secure',
								  '5' => 'PREAUTH with 3D Secure',
								  '6' => 'PAYMENT with FRAUDGUARD and 3D Secure',
								  '7' => 'PREAUTH with FRAUDGUARD and 3D Secure',
							 )
						),
			'surcharge' => array(
								'type'        => 'surcharge'
							),
			'enviroment' => array(
							'title' => __( 'Enviroment', 'woocommerce' ),
							'type' => 'select',
							'description' => '',
							'default' => 'test',
							'options' => array(
								  'live' => 'Live',
								  'test' => 'Test'
							 )
						),
			);

    	}
		
		/**
		 * generate_surcharge_html function.
		 */
		public function generate_surcharge_html() {
			ob_start();
			if ( $this->surcharge ) {
				if($this->surcharge['surcharge'] == 1)
					$surcharge = 'checked';
			}
			?>
			<tr valign="top">
				<th scope="row" class="titledesc"><?php _e( 'Surcharge', 'woocommerce' ); ?>:</th>
				<td class="forminp" id="surcharge_info">
					<input name="surcharge" id="surcharge" value="1" type="checkbox" <?php echo $surcharge;?>><br />
					<table cellspacing="0" id="surcharge_table">
						<tbody class="accounts">
							<tr>
								<td>Visa</td>
								<td>
								<select name="surcharge_visa" id="surcharge_visa">
									<option value="" <?php if($this->surcharge['surcharge_visa'] == '') echo 'selected="selected"';?>>None</option>
									<option value="flat" <?php if($this->surcharge['surcharge_visa'] == 'flat') echo 'selected="selected"';?>>Flat Fee</option>
									<option value="percentage" <?php if($this->surcharge['surcharge_visa'] == 'percentage') echo 'selected="selected"';?>>Percentage</option>
								</select>
								</td>
								<td><input type="text" name="surcharge_visa_value" id="surcharge_visa_value" size=10 placeholder="" value="<?php echo $this->surcharge['surcharge_visa_value'];?>"/></td>
							</tr>
							<tr>
								<td>Mastercard</td>
								<td>
								<select name="surcharge_mastercard" id="surcharge_mastercard">
									<option value="" <?php if($this->surcharge['surcharge_mastercard'] == '') echo 'selected="selected"';?>>None</option>
									<option value="flat" <?php if($this->surcharge['surcharge_mastercard'] == 'flat') echo 'selected="selected"';?>>Flat Fee</option>
									<option value="percentage" <?php if($this->surcharge['surcharge_mastercard'] == 'percentage') echo 'selected="selected"';?>>Percentage</option>
								</select>
								</td>
								<td><input type="text" name="surcharge_mastercard_value" id="surcharge_mastercard_value" size=10 value="<?php echo $this->surcharge['surcharge_mastercard_value'];?>"/></td>
							</tr>
							<tr>
								<td>American Express</td>
								<td>
								<select name="surcharge_amex" id="surcharge_amex">
									<option value="" <?php if($this->surcharge['surcharge_amex'] == '') echo 'selected="selected"';?>>None</option>
									<option value="flat" <?php if($this->surcharge['surcharge_amex'] == 'flat') echo 'selected="selected"';?>>Flat Fee</option>
									<option value="percentage" <?php if($this->surcharge['surcharge_amex'] == 'percentage') echo 'selected="selected"';?>>Percentage</option>
								</select>
								</td>
								<td><input type="text" name="surcharge_amex_value" id="surcharge_amex_value" size=10 value="<?php echo $this->surcharge['surcharge_amex_value'];?>"/></td>
							</tr>
						</tbody>
					</table>
					<script type="text/javascript">
						jQuery(function() {
							if(jQuery('#surcharge').is(":checked")) {
								jQuery('#surcharge_table').show();
							} else {
								jQuery('#surcharge_table').hide();
							}
							jQuery('#surcharge').change(function() {
								if(this.checked){
									jQuery('#surcharge_table').show();
								} else {
									jQuery('#surcharge_table').hide();
								}
							});
						});
					</script>
				</td>
			</tr>
			<?php
			return ob_get_clean();
		}
	
		/**
		 * Save surcharge info
		 */
		public function save_surcharge() {
			$surcharge = array();
	
			if ( isset( $_POST['surcharge'] ) ) {
				$surcharge = array(
						'surcharge'   => 1,
						'surcharge_visa' => $_POST['surcharge_visa'],
						'surcharge_visa_value'      => $_POST['surcharge_visa_value'],
						'surcharge_mastercard' => $_POST['surcharge_mastercard'],
						'surcharge_mastercard_value'      => $_POST['surcharge_mastercard_value'],
						'surcharge_amex' => $_POST['surcharge_amex'],
						'surcharge_amex_value'      => $_POST['surcharge_amex_value'],
					);
			}
	
			update_option( 'woocommerce_securepay_surcharge', $surcharge );
		}

		//public function payment_fields() {
			//echo 'Payment Type, Total info, credit card or bank account... show here';
		//}
		/**
	 * Process the payment and return the result
		 **/
		function process_payment( $order_id ) {
			$order = new WC_Order( $order_id );
			return array(
				'result' 	=> 'success',
				'redirect'	=> add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, get_permalink(woocommerce_get_page_id('pay'))))
			);
	
		}
		
		/**
		 * receipt_page
		 **/
		function receipt_page( $order ) {
	
			echo '<p>'.__('Thank you for your order, please click the button below to pay with SecurePay.', 'woocommerce').'</p>';
			echo $this->generate_payment_form( $order );
	
		}
		
		function thankyou_page(){
			/*$order = new WC_Order( $_GET['order-received'] );
			
			WC()->api->includes();
			WC()->api->register_resources( new WC_API_Server( '/' ) );
			$notes = WC()->api->WC_API_Orders->get_order_notes($_GET['order-received']);
			
			if(isset($notes['order_notes'][0]['note']))
				echo $notes['order_notes'][0]['note'];
			*/
			echo '<strong>Transaction ID: ' . $_GET['txnid'];
			echo '<br/>Transaction status: ' . $_GET['restext'];
			echo '<br/>Amount: $' . $_GET['amount']/100 . ' ' .  $_GET['currency'].'</strong>';
		}
		
		/**
		 * Generate the Payment button link
		 **/
		public function generate_payment_form( $order_id ) {
			global $woocommerce;
			$order = new WC_Order( $order_id );
			
			$amount = number_format($order->order_total, 2, '.', '')*100;
			$currency = get_woocommerce_currency();
			
			$return_url = $this->get_return_url( $order );
			$notify_url = $this->notify_url;
			
			$products = array();
			if ( sizeof( $order->get_items() ) > 0 ) {
				foreach ( $order->get_items() as $item ) {
					if ( $item['qty'] ) {
						$products[] = $item['name'] . ' x ' . $item['qty'];
					}
				}
			}
			
			$fp_timestamp = gmdate('YmdHis');
			$fingerprint = $this->merchant_id.'|'.$this->transaction_password.'|'.$this->transaction_type.'|'.$order_id.'|'.$amount.'|'.$fp_timestamp;
			$fingerprint = hash('sha1', $fingerprint);
			
			$parameters = array(
				"bill_name" => "transact",
				"merchant_id" => $this->merchant_id,
				"primary_ref" => $order_id,
				"txn_type" => $this->transaction_type,
				"currency" => $this->currency,
				"amount" => $amount,
				"fp_timestamp" => $fp_timestamp,
				"fingerprint" => $fingerprint,
				"return_url" => $return_url,
				"return_url_target" => 'parent',
				"cancel_url" => $order->get_cancel_order_url(),
				"callback_url" => $notify_url,
				"template" => $this->template_type,
			);
			
			if($this->display_securepay_receipt == 'yes')
				$parameters['display_receipt'] = 'yes';
			else
				$parameters['display_receipt'] = 'no';
				
			if($this->display_cardholder_name == 'yes')
				$parameters['display_cardholder_name'] = 'yes';
			else
				$parameters['display_cardholder_name'] = 'no';
			
			if($this->surcharge['surcharge'] == 1)
			{
					$surcharge_visa_percen = 0;
					$surcharge_mastercard_percen = 0;
					$surcharge_amex_percen = 0;
					
					//visa
					if($this->surcharge['surcharge_visa'] == 'flat')
					{
						$surcharge_visa_percen = round($this->surcharge['surcharge_visa_value']/$order->order_total, 2);
					} 
					elseif($this->surcharge['surcharge_visa'] == 'percentage')
					{
						$surcharge_visa_percen = round($this->surcharge['surcharge_visa_value'], 2);
					}
					
					//mastercard
					if($this->surcharge['surcharge_mastercard'] == 'flat')
					{
						$surcharge_mastercard_percen = round($this->surcharge['surcharge_mastercard_value']/$order->order_total, 2);
					} 
					elseif($this->surcharge['surcharge_mastercard'] == 'percentage')
					{
						$surcharge_mastercard_percen = round($this->surcharge['surcharge_mastercard_value'], 2);
					}
					
					//amex
					if($this->surcharge['surcharge_amex'] == 'flat')
					{
						$surcharge_amex_percen = round($this->surcharge['surcharge_amex_value']/$order->order_total, 2);
					} 
					elseif($this->surcharge['surcharge_amex'] == 'percentage')
					{
						$surcharge_amex_percen = round($this->surcharge['surcharge_amex_value'], 2);
					}
					
					if($surcharge_visa_percen > 0)
						$parameters['surcharge_rate_v'] = $surcharge_visa_percen;
						
					if($surcharge_mastercard_percen > 0)
						$parameters['surcharge_rate_m'] = $surcharge_mastercard_percen;
						
					if($surcharge_amex_percen > 0)
						$parameters['surcharge_rate_a'] = $surcharge_amex_percen;
			}
			
			foreach($parameters as $key => $value){
				$request_args_array[] = "<input type='hidden' name='$key' value='$value'/>";
			}  

			if($this->enviroment == 'test')
				$securepayframe_gateway = $this->test_gateway_url;
			else
				$securepayframe_gateway = $this->live_gateway_url;
	
			if ($this->template_type == 'iframe'){
				$width=!empty($this->iframe_width)?$this->iframe_width.'px':'60%';
				$height=!empty($this->iframe_height)?$this->iframe_height.'px':'500px';
				$iframe='<iframe name="securepay_chekout_frame" src="" id="securepay_chekout_frame" width="'.$width.'" height="'.$height.'"></iframe>  ';
				//$target='target="securepay_chekout_frame" style="display:none"';
				$target='target="securepay_chekout_frame"';

				$result = $iframe.'<form action="'.$securepayframe_gateway.'" method="post" id="securepayframe_payment_form" '.$target.'>
            	' . implode('', $request_args_array) . '
            	<input type="submit" class="button alt" id="submit_securepayframe_payment_form" value="' . __( 'Pay via Securepay', 'woocommerce' ) . '" /> <a class="button cancel" href="'.esc_url( $order->get_cancel_order_url() ).'">'.__( 'Cancel order &amp; restore cart', 'woocommerce' ).'</a>
				</form>';
				
				$result.='<script type="text/javascript">jQuery(function(){jQuery("#submit_securepayframe_payment_form").click();});</script>';
				
				return $result;
			}else{
				wc_enqueue_js( '
						jQuery("body").block({
								message: "' . esc_js( __( 'Thank you for your order. We are now redirecting you to Securepay to make payment.', 'woocommerce' ) ) . '",
								baseZ: 99999,
								overlayCSS:
								{
									background: "#fff",
									opacity: 0.6
								},
								css: {
									padding:        "20px",
									zindex:         "9999999",
									textAlign:      "center",
									color:          "#555",
									border:         "3px solid #aaa",
									backgroundColor:"#fff",
									cursor:         "wait",
									lineHeight:		"24px",
								}
							});
						jQuery("#submit_securepayframe_payment_form").click();
					' );
			return '<form action="'.esc_url( $securepayframe_gateway ).'" method="post" id="securepayframe_payment_form" target="_top">
					' . implode('', $request_args_array) . '
						<input type="submit" class="button alt" id="submit_securepayframe_payment_form" value="' . __( 'Pay via Securepay', 'woocommerce' ) . '" /> <a class="button cancel" href="'.esc_url( $order->get_cancel_order_url() ).'">'.__( 'Cancel order &amp; restore cart', 'woocommerce' ).'</a>
					</form>';
			}
		}
		
		function check_notify_response() {
			
			$order_id = $_POST["refid"];
			$order = new WC_Order( (int)$order_id );
			
			$fingerprint = $_POST["fingerprint"];
			$timestamp = $_POST["timestamp"];
			$amount = $_POST["amount"];
			$summarycode  = $_POST["summarycode"];
			
			$txnid  = $_POST["txnid"];
			$rescode  = $_POST["rescode"];
			
			$fingerprint_string = $this->merchant_id.'|'.$this->transaction_password.'|'.$order_id.'|'.$amount.'|'.$timestamp.'|'.$summarycode;
			$fingerprint_hash = hash('sha1', $fingerprint_string);
			if($fingerprint_hash == $fingerprint && in_array($rescode, array('00', '08', '11'))) {
				//success transaction
				$order->add_order_note( __('Payment completed, Transaction ID: '.$txnid, 'woocommerce') );
				$order->payment_complete($txnid);
			} else {
				//error transaction
				$order->update_status( 'failed', __( 'Payment failed.' . print_r($_POST, true), 'woocommerce' ) );
			}
			exit;
		}
		
		public function process_refund( $order_id, $amount = null, $reason = '' ) {
			require_once('libs/securepay_xml_api.php');
			$order = wc_get_order( $order_id );
	
			if ( ! $order || ! $order->get_transaction_id() || ! $this->merchant_id || ! $this->transaction_password ) {
				return false;
			}
			
			$payment_mode = ($this->enviroment != 'test' ? SECUREPAY_GATEWAY_MODE_LIVE : SECUREPAY_GATEWAY_MODE_TEST);
			
			$txn_object = new securepay_xml_transaction($payment_mode, $this->merchant_id, $this->transaction_password, '');
			$banktxnID = $txn_object->processCreditRefund($amount, $order_id, $order->get_transaction_id());
	//return new WP_Error( 'securepay-error', $order->get_transaction_id() );
	
			if (  !$banktxnID  ) {
				return new WP_Error( 'securepay-error', __( 'Empty SecurePay response.', 'woocommerce' ) );
			}
	
			$order->add_order_note( sprintf( __( 'Refunded %s - Refund ID: %s', 'woocommerce' ), $amount, $banktxnID ) );
			return true;
		}
		
		
	}
	
	//add custom style
	add_action( 'wp_enqueue_scripts', 'embed_plugin_style' );
	function embed_plugin_style(){
			wp_register_style( 'secureframe-plugin', plugins_url( '/css/secureframe-style.css', __FILE__ ) );
			wp_enqueue_style( 'secureframe-plugin' );
	}

	/* Add our new payment gateway to the woocommerce gateways 
	------------------------------------------------------------ */
 
	add_filter( 'woocommerce_payment_gateways', 'add_woocommerce_securepayframe_payment_gateway' );
	function add_woocommerce_securepayframe_payment_gateway( $methods ) {
		$methods[] = 'WC_Gateway_SecurePayFrame'; return $methods;
	}
	
}