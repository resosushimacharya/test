<?php
/*
Plugin Name: Securepay for WooCommerce
Plugin URI: http://solvercircle.com
Description: Add Securepay Payment Gateways for WooCommerce.
Version: 1.0.0
Author: SolverCircle
Author URI: http://solvercircle.com
License: 
*/
function init_securepay(){
  function add_securepay_gateway_class( $methods ) {
    $methods[] = 'WC_Gateway_Securepay'; 
    return $methods;
  }

  add_filter( 'woocommerce_payment_gateways', 'add_securepay_gateway_class' );
  if(class_exists('WC_Payment_Gateway')){
  class WC_Gateway_Securepay extends WC_Payment_Gateway {
    
    public function __construct() {
      $this->id               = 'securepay';
      $this->icon             = apply_filters( 'woocommerce_securepay_icon', plugins_url( 'images/securepay.jpg' , __FILE__ ) );
      $this->has_fields       = true;
      $this->method_title     = 'SecurePay';
      
      $this->init_form_fields();
      $this->init_settings();
      
      $this->title              = $this->get_option( 'title' );
      $this->securepay_merchant_id    = $this->get_option( 'securepay_merchant_id' );
      $this->securepay_merchant_pass  = $this->get_option( 'securepay_merchant_pass' );
      $this->securepay_currency       = $this->get_option( 'securepay_currency' );
      $this->securepay_testmode       = $this->get_option( 'securepay_testmode' );
      
      add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
    }
    
    public function admin_options() {
      ?>
      <h3><?php _e( 'Securepay', 'woocommerce' ); ?></h3>
      <p><?php _e( 'Securepay works only with Australia', 'woocommerce' ); ?></p>
      <table class="form-table">
    		<?php $this->generate_settings_html(); ?>
      </table>
      <?php
    }
    
    public function init_form_fields(){
      $this->form_fields = array(
          'enabled' => array(
            'title' => __( 'Enable/Disable', 'woocommerce' ),
            'type' => 'checkbox',
            'label' => __( 'Enable Securepay', 'woocommerce' ),
            'default' => 'yes'
            ),
          'title' => array(
            'title' => __( 'Title', 'woocommerce' ),
            'type' => 'text',
            'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
            'default' => __( 'Securepay Credit Card', 'woocommerce' ),
            'desc_tip'      => true,
            ),
          'securepay_merchant_id' => array(
            'title' => __( 'Merchant Id', 'woocommerce' ),
            'type' => 'text',
            'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
            'default' => '',
            'desc_tip'      => true,
            'placeholder' => 'Your Marchant ID'
            ),
          'securepay_merchant_pass' => array(
            'title' => __( 'Merchant Pass', 'woocommerce' ),
            'type' => 'text',
            'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
            'default' => '',
            'desc_tip'      => true,
            'placeholder' => 'Your Marchant Pass'
            ),
          'securepay_currency' => array(
            'title'       => __( 'Currency', 'woocommerce' ),
            'type'        => 'text',
            'description' => __( 'Currency should have Australian Currency', 'woocommerce' ),
            'default'     => '',
            'desc_tip'    => true,
            'placeholder' => __( 'Currency', 'woocommerce' )
          ),
          'securepay_testmode' => array(
            'title'       => __( 'Securepay sandbox', 'woocommerce' ),
            'type'        => 'checkbox',
            'label'       => __( 'Enable Securepay sandbox', 'woocommerce' ),
            'default'     => 'no',
            'description' => __( 'Securepay sandbox can be used to test payments.', 'woocommerce' )
          )
        );
    }
    
    public function payment_fields(){
      ?>
      <table>
      	<tr>
        	<td><label class="" for="securepay_first_name"><?php echo __( 'First Name', 'woocommerce') ?></label></td>
            <td><input type="text" name="first_name" class="input-text" /></td>
        </tr>
        <tr>
        	<td><label class="" for="securepay_last_name"><?php echo __( 'Last Name', 'woocommerce') ?></label></td>
            <td><input type="text" name="last_name" class="input-text" /></td>
        </tr>
        <tr>
        	<td><label class="" for="securepay_cardno"><?php echo __( 'Card No.', 'woocommerce') ?></label></td>
            <td><input type="text" name="cardno" class="input-text" /></td>
        </tr>
        <tr>
        	<td><label class="" for="securepay_first_name"><?php echo __( 'Expiration date', 'woocommerce') ?>.</label></td>
            <td>
            	<select name="expmonth" id="expmonth">
                <option value=""><?php _e( 'Month', 'woocommerce' ) ?></option>
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>  
              </select>
              <select name="expyear" id="expyear">
                <option value=""><?php _e( 'Year', 'woocommerce' ) ?></option><?php
                $years = array();
                for ( $i = date( 'y' ); $i <= date( 'y' ) + 15; $i ++ ) {
                  printf( '<option value="20%u">20%u</option>', $i, $i );
                } ?>
              </select>
            </td>
        </tr>
        <tr>
        	<td><label class="" for="cardcvv"><?php echo __( 'Card CVV', 'woocommerce') ?></label></td>
            <td><input type="text" name="cardcvv" class="input-text" /></td>
        </tr>
      </table>
      <?php		
    }
    
    public function process_payment( $order_id ) {
      global $woocommerce;
      $order = new WC_Order( $order_id );
	  $billing_address = $order->get_formatted_billing_address();//$order->get_billing_address();get_formatted_billing_address
      if($this->securepay_testmode=="yes"){
        $secpay_url = 'https://test.securepay.com.au/xmlapi/payment';
      }else{
        $secpay_url = 'https://api.securepay.com.au/xmlapi/payment';
      }
      
      $firstname = $_POST['first_name'];
      $lastname = $_POST['last_name'];
      $card_number = $_POST['cardno'];
      $exp_month = $_POST['expmonth'];
      $exp_year = $_POST['expyear'];
      $card_ccv = $_POST['cardcvv'];
      $expire_date = $exp_month .'/'. substr($exp_year, 2, 2);
      
      $transaction_id=$order->id;
      $merchant_id =$this->securepay_merchant_id;
      $merchant_pass = $this->securepay_merchant_pass;
      $currtimestamp = date('YdmHis000000+000', time());
      $orderId = $order->id;
      $currency = $this->securepay_currency;
      
      //$amount='100';
      $amount = $order->order_total;
      $amount = $amount * 100;
	  
	  $xmldocs = '<?xml version="1.0" encoding="UTF-8"?>
				  <SecurePayMessage>
				  <MessageInfo>
				  <messageID>'.$transaction_id.'</messageID>
				  <messageTimestamp>'.$currtimestamp.'</messageTimestamp>
				  <timeoutValue>60</timeoutValue>
				  <apiVersion>xml-4.2</apiVersion>
				  </MessageInfo>
				  <MerchantInfo>
				  <merchantID>'.$merchant_id.'</merchantID>
				  <password>'.$merchant_pass.'</password>
				  </MerchantInfo>
				  <RequestType>Payment</RequestType>
				  <Payment>
				  <TxnList count="1">
				  <Txn ID="1">
				  <txnType>0</txnType>
				  <txnSource>0</txnSource>
				  <amount>'.$amount.'</amount>
				  <purchaseOrderNo>'.$orderId.'</purchaseOrderNo>
				  <CreditCardInfo>
				  <cardNumber>'.$card_number.'</cardNumber>
				  <expiryDate>'.$expire_date.'</expiryDate>
				  <cvv>'.$card_ccv.'</cvv>
				  </CreditCardInfo>
				  </Txn>
				  </TxnList>
				  </Payment>
				  </SecurePayMessage>';

	$secresult = $this->sec_gatewaycall($secpay_url,$xmldocs);
  //echo '<pre>';
  //print_r($secresult);
	  //die();
	if($merchant_id !='' || $merchant_pass !=''){  
	  $sec_stats = $secresult->xpath('/SecurePayMessage/Status/statusCode');
	  $sec_status = ($sec_stats !== FALSE && isset($sec_stats[0])) ? (string)$sec_stats[0] : '';
	  $sec_apvsts = $secresult->xpath('/SecurePayMessage/Payment/TxnList/Txn/approved');
	  $sec_approve = ($sec_apvsts !== FALSE && isset($sec_apvsts[0])) ? (string)$sec_apvsts[0] : '';
	  $sec_rescode = $secresult->xpath('/SecurePayMessage/Payment/TxnList/Txn/responseCode');
	  $sec_res_code = ($sec_rescode !== FALSE && isset($sec_rescode[0])) ? (string)$sec_rescode[0] : '';
	  $secrestext = $secresult->xpath('/SecurePayMessage/Payment/TxnList/Txn/responseText');
	  $sec_res_text = ($secrestext !== FALSE && isset($secrestext[0])) ? (string)$secrestext[0] : '';
    
    $sec_stats_desc = $secresult->xpath('/SecurePayMessage/Status/statusDescription');
	  $sec_status_desc = ($sec_stats_desc !== FALSE && isset($sec_stats_desc[0])) ? (string)$sec_stats_desc[0] : '';
    
	  //print_r($sec_status);
    //die();
	  if($sec_status=='000'){
		  if($sec_approve=='Yes'){
			$order->add_order_note( __( ' Securepay payment completed. ' , 'woocommerce' ) );
			$order->payment_complete();
			return array (
			  'result'   => 'success',
			  'redirect' => $this->get_return_url( $order ),
			);
		  }else{
			$order->add_order_note( __( 'Securepay payment failed. Payment declined. Error: '.$sec_status.' : '.$sec_status_desc, 'woocommerce' ) );
			//$woocommerce->add_error( __( 'Sorry, the transaction was declined. Error: '.$sec_res_code.' : '.$sec_res_text, 'woocommerce' ) );
      wc_add_notice( __( 'Sorry, the transaction was declined. Error: '.$sec_status.' : '.$sec_status_desc, 'error' ) );
		  }
		}else{
		  $order->add_order_note( __( 'Securepay payment failed. Payment declined. Error: '.$sec_status.' : '.$sec_status_desc, 'woocommerce' ) );
		  //$woocommerce->add_error( __( 'Sorry, the transaction was declined. Error: '.$sec_res_code.' : '.$sec_res_text, 'woocommerce' ) );
      wc_add_notice( __( 'Sorry, the transaction was declined. Error: '.$sec_status.' : '.$sec_status_desc, 'error' ) );
		}
	  }
	  else{
		  $order->add_order_note( __( 'Securepay payment failed. Payment declined. Please Check your Admin settings', 'woocommerce' ) );
		  //$woocommerce->add_error( __( 'Sorry, the transaction was declined. Please Check your Admin settings', 'woocommerce' ) );
      wc_add_notice( __( 'Sorry, the transaction was declined. Please Check your Admin settings', 'error' ) );
	  }
	}
    
    public function sec_gatewaycall($sec_url,$xmldocs){
	  $ch = curl_init();
	  curl_setopt($ch,CURLOPT_URL,$sec_url);
	  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	  curl_setopt($ch,CURLOPT_POSTFIELDS,$xmldocs);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  $result = curl_exec($ch);
	  curl_close($ch);
	  $result = simplexml_load_string($result);
	  return $result;
	}
  }
  }
}

add_action( 'plugins_loaded', 'init_securepay' );
?>