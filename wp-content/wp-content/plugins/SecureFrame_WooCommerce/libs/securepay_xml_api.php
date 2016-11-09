<?php

/**
 * securepay_xml_api.php:
 *
 * Contains a class for sending transactions to SecurePay via the XML API
 * 
 * This class requires cURL to be available to PHP
 *
 * @author Andrew Dubbeld (support@securepay.com.au)
 * @date 19-Oct-2009
 */

/* Modes */
define('SECUREPAY_GATEWAY_MODE_TEST',			 1);
define('SECUREPAY_GATEWAY_MODE_LIVE',			 2);
define('SECUREPAY_GATEWAY_MODE_PERIODIC_TEST',	 3);
define('SECUREPAY_GATEWAY_MODE_PERIODIC_LIVE',	 4);
define('SECUREPAY_GATEWAY_MODE_FRAUD_TEST',	 5);
define('SECUREPAY_GATEWAY_MODE_FRAUD_LIVE',	 6);

/* Server URLs */
define('SECUREPAY_URL_TEST', 			'https://www.securepay.com.au/test/payment');
define('SECUREPAY_URL_LIVE', 			'https://www.securepay.com.au/xmlapi/payment');
define('SECUREPAY_URL_PERIODIC_TEST', 	'https://www.securepay.com.au/test/periodic');
define('SECUREPAY_URL_PERIODIC_LIVE', 	'https://www.securepay.com.au/xmlapi/periodic');
define('SECUREPAY_URL_FRAUD_TEST', 	'https://www.securepay.com.au/antifraud_test/payment');
define('SECUREPAY_URL_FRAUD_LIVE', 	'https://www.securepay.com.au/antifraud/payment');

/* Transaction types. */
define('SECUREPAY_TXN_STANDARD',		  0);
define('SECUREPAY_TXN_PERIODIC',		  3);
define('SECUREPAY_TXN_REFUND',			  4);
define('SECUREPAY_TXN_REVERSE',		  6);
define('SECUREPAY_TXN_PREAUTH', 		 10);
define('SECUREPAY_TXN_ADVICE', 		 11);
define('SECUREPAY_TXN_RECURRING',		 14);
define('SECUREPAY_TXN_DIRECTDEBIT',	 15);
define('SECUREPAY_TXN_DIRECTCREDIT', 	 17);
define('SECUREPAY_TXN_ANTIFRAUD_PAY', 	 21);
define('SECUREPAY_TXN_ANTIFRAUD_CHECK', 22);

/* Request types */
define('SECUREPAY_REQUEST_ECHO', 	 	'Echo');
define('SECUREPAY_REQUEST_PAYMENT', 	'Payment');
define('SECUREPAY_REQUEST_PERIODIC',	'Periodic');

/* Periodic types */
define('SECUREPAY_PERIODIC_ONCE',		1);
define('SECUREPAY_PERIODIC_DAY',		2);
define('SECUREPAY_PERIODIC_CALENDAR',	3);
define('SECUREPAY_PERIODIC_TRIGGERED',	4);

/* Periodic actions */
define('SECUREPAY_ACTION_ADD',			'add');
define('SECUREPAY_ACTION_DELETE',		'delete');
define('SECUREPAY_ACTION_TRIGGER',		'trigger');

/* Calendar Intervals */
define('SECUREPAY_CAL_WEEKLY',			1);
define('SECUREPAY_CAL_FORTNIGHTLY',	2);
define('SECUREPAY_CAL_MONTHLY',		3);
define('SECUREPAY_CAL_QUARTERLY',		4);
define('SECUREPAY_CAL_HALF_YEARLY',	5);
define('SECUREPAY_CAL_ANNUALLY',		6);

/* Currencies */
define('SECUREPAY_CURRENCY_DEFAULT',	'AUD');

/**
 * securepay_xml_transaction
 *
 * This class handles XML SecurePay transactions
 *
 * It supports the following tranactions:
 * 		Credit Payment (standard)
 *		Credit Refund
 *		Credit Reversal
 *		Credit Preauthorisation
 *		Credit Preauthorised completion (Advice)
 * 		Add Trigger/Peridic Payment
 *		Delete Trigger/Periodic Payment
 *		Trigger Triggered payment
 *
 * It partially supports the following transactions (which are not yet required):
 *		Direct Entry Credit
 *		Direct Entry Debit
 *
 * @param int mode - The kind of transaction object you would like to open. i.e. SECUREPAY_GATEWAY_MODE_TEST See top of this file for definitions.
 * @param string merchantID - The merchant's login ID, received from SecurePay
 * @param string merchantPW - The merchant's login password
 * @param string identifier - Support identifier
 *
 * @notes
 *		There are fifteen key public functions:
 *			__construct()					""
 *			initFraudGuard()				""
 *			processCreditStandard()			$txnid/false
 *			processCreditPreauth()			$preauthid/false
 *			processCreditRefund()			$txnid/false
 *			processCreditReverse()			$txnid/false
 *			processCreditAdvice()			$txnid/false
 *			processDirectDebit()			$txnid/false
 *			processDirectCredit()			$txnid/false
 *			processFraudGuard()				$txnid/false
 *			processFraudGuardCheck()		$txnid/false
 *			processStandardPeriodicAdd()	true/false
 *			processDirectPeriodicAdd()		true/false
 *			processTrigger()				true/false
 *			processPeriodicDelete()			true/false
 *
 *		 Fewer interface functions that take payment arrays would have been simpler. This way might require less knowledge of the API from users, and it is easier to figure out.
 */

class securepay_xml_transaction
{
	const TIMEOUT="60";

	const GATEWAY_ERROR_OBJECT_INVALID = "The Gateway Object is invalid";
	const GATEWAY_ERROR_CURL_ERROR = "CURL failed and reported the following error";
	const GATEWAY_ERROR_INVALID_CCNUMBER = "Parameter Check failure: Invalid credit card number";
	const GATEWAY_ERROR_INVALID_CCEXPIRY = "Parameter Check failure: Invalid credit card expiry date";
	const GATEWAY_ERROR_INVALID_CC_CVC = "Parameter Check failure: Invalid credit card verification code";
	const GATEWAY_ERROR_INVALID_TXN_AMT = "Parameter Check failure: Invalid transaction amount";
	const GATEWAY_ERROR_INVALID_REF_ID = "Parameter Check failure: Invalid transaction reference number";
	const GATEWAY_ERROR_INVALID_REQUEST = "Request failure: Tried to pass Periodic payment through Payment gateway or vice versa";
	const GATEWAY_ERROR_INVALID_ACCOUNTNUMBER = "Parameter Check failure: Invalid account number";
	const GATEWAY_ERROR_INVALID_ACCOUNTNAME = "Parameter Check failure: Invalid account name";
	const GATEWAY_ERROR_INVALID_ACCOUNTBSB = "Parameter Check failure: Invalid BSB";
	const GATEWAY_ERROR_RESPONSE_ERROR = "A general response error was detected";
	const GATEWAY_ERROR_RESPONSE_INVALID = "A unspecified error was detected in the response content";
	const GATEWAY_ERROR_XML_PARSE_FAILED = "The response message could not be parsed (invalid XML?)";
	const GATEWAY_ERROR_RESPONSE_XML_MESSAGE_ERROR = "An unspecified error was found in the response message (missing field?)";
	const GATEWAY_ERROR_SECUREPAY_STATUS = "The remote Gateway reported the following status error";
	const GATEWAY_ERROR_TXN_DECLINED = "Transaction Declined";

	/* Common */
	private $txnReference, $amount;
	private $bankTxnID = 0;
	private $errorString;
	private $gatewayObjectValid = true;
	private $gatewayURL, $merchantID, $merchantPW;
	private $responseArray = array();
	private $txnType = 0;
	
	/* cc */
	private $ccNumber, $ccVerify, $ccExpiryMonth, $ccExpiryYear;
	private $currency=SECUREPAY_CURRENCY_DEFAULT;
	
	/* Direct Entry */
	private $accNumber, $accBSB, $accName;
	
	/* Periodic/Triggered */
	private $requestType, $periodicType, $periodicInterval, $startDate, $numberOfPayments;
	private $action = ""; private $clientID = "";
	
	/* fraudguard */
	private $fraudGuard = 0;
	private $fgFirstName = "";
	private $fgLastName = "";
	private $fgPostCode = "";
	private $fgTown = "";
	private $fgCountryB = "";
	private $fgCountryD = "";
	private $fgEmail = "";
	private $fgIP = "";
	
	/* Support Identifier. */
	private $identifier="";

	/**
	 * __construct
	 *
	 * @param integer $gatewaymode One of SECUREPAY_GATEWAY_MODE*
	 * @param string $setup_merchantID
	 * @param string $setup_merchantPW
	 * @param string $identifier "Cart/Module" Include this value to assist our support staff in diagnosing transaction issues. Details are subject to change.
	 */
	public function __construct($gatewaymode, $setup_merchantID, $setup_merchantPW, $identifier="")
	{
		$this->setRequestType(SECUREPAY_REQUEST_PAYMENT);
		
		$this->gatewayObjectValid = true;
		
		switch ($gatewaymode)
		{
			case SECUREPAY_GATEWAY_MODE_TEST:
				$this->gatewayURL = SECUREPAY_URL_TEST;
				break;

			case SECUREPAY_GATEWAY_MODE_LIVE:
				$this->gatewayURL = SECUREPAY_URL_LIVE;
				break;

			case SECUREPAY_GATEWAY_MODE_PERIODIC_TEST:
				$this->gatewayURL = SECUREPAY_URL_PERIODIC_TEST;
				$this->setRequestType(SECUREPAY_REQUEST_PERIODIC);
				break;
				
			case SECUREPAY_GATEWAY_MODE_PERIODIC_LIVE:
				$this->gatewayURL = SECUREPAY_URL_PERIODIC_LIVE;
				$this->setRequestType(SECUREPAY_REQUEST_PERIODIC);
				break;

			case SECUREPAY_GATEWAY_MODE_FRAUD_TEST:
				$this->gatewayURL = SECUREPAY_URL_FRAUD_TEST;
				break;
				
			case SECUREPAY_GATEWAY_MODE_FRAUD_LIVE:
				$this->gatewayURL = SECUREPAY_URL_FRAUD_LIVE;
				break;

			default:
				$this->gatewayObjectValid = false;
				return;
		}
		
		$this->setIdentifier($identifier);
		
		if (strlen($setup_merchantID) == 0 || strlen($setup_merchantPW) == 0)
		{
			$this->gatewayObjectValid = false;
			return;
		}
		
		$this->setAuth($setup_merchantID,$setup_merchantPW);
		
		return;
	}

	public function getIdentifier() { return $this->identifier; }
	public function setIdentifier($id) { $this->identifier = $id; }

	/**
	 * reset
	 * 
	 * Clears response variables, preventing mismatched results in certain failure cases.
	 * This is called before each transaction, so be sure to check these values between transactions.
	 */
	public function reset()
	{
		$this->errorString = NULL;
		$this->responseArray = array();
		$this->bankTxnID = 0;
		$this->txnType = 0;
	}
	
	public function isGatewayObjectValid() { return $this->gatewayObjectValid; }

	public function getAmount() { return $this->amount; }
	
	/**
	 * setAmount
	 *
	 * Takes amount as a decimal; requires currency to be set
	 *
	 * @param float amount
	 */
	public function setAmount($amount)
	{
		if($this->getCurrency() == 'JPY')
		{
			$this->amount = $amount;
		}
		else
		{
			$this->amount = round($amount*100,0);
		}
		return;
	}
	
	public function getCurrency() { return $this->currency; }
	public function setCurrency($cur) { $this->currency = $cur; }
	
	public function getTxnReference() { return $this->txnReference; }
	public function setTxnReference($ref) { $this->txnReference = $ref; }

	public function getTxnType() { return $this->txnType; }
	public function setTxnType($type) { $this->txnType = $type; }
	
	public function getPreauthID() { return $this->preauthID; }
	public function setPreauthID($id) { $this->preauthID = $id; }
	
	public function getAccBSB() { return $this->accBSB; }
	public function setAccBSB($bsb) { $this->accBSB = $bsb; }
	
	public function getAccNumber() { return $this->accNumber; }
	public function setAccNumber($Number) { $this->accNumber = $Number; }

	public function getAccName() { return $this->accName; }
	public function setAccName($name) { $this->accName = $name; }
	
	public function getCCNumber() { return $this->ccNumber; }
	public function setCCNumber($ccNumber) { $this->ccNumber = $ccNumber; }
	
	public function getCCVerify() { return $this->ccVerify; }
	public function setCCVerify($ver) { $this->ccVerify = $ver; }	

	/* @return string month MM*/
	public function getCCExpiryMonth() { return $this->ccExpiryMonth; }
	
	/* @return string year YY*/
	public function getCCExpiryYear() { return $this->ccExpiryYear; }
	
	/* @param string/int month MM or month M - If there are leading zeros, type needs to be string*/
	public function setCCExpiryMonth($month)
	{
		$l = strlen(trim($month));
		if($l == 1)
		{
			$this->ccExpiryMonth = sprintf("%02d",ltrim($month,'0'));
		}
		else
		{
			$this->ccExpiryMonth = $month;
		}
		
		return;
	}
	
	/* @param string/int year YY or year Y or year YYYY - If there are leading zeros, type needs to be string*/
	public function setCCExpiryYear($year)
	{
		$y = ltrim(trim((string)$year),"0");
		$l = strlen($y);
		if($l==4)
		{
			$this->ccExpiryYear = substr($y,2);
		}
		else if($l>=5)
		{
			$this->ccExpiryYear = 0;
		}
		else if($l==1)
		{
			$this->ccExpiryYear = sprintf("%02d",$y);
		}
		else
		{
			$this->ccExpiryYear = $year;
		}
		return;
	}

	public function getClearCCNumber()
	{
		$t = $this->getCCNumber();
		$this->setCCNumber("0");
		return $t;
	}
	
	public function getClearCCVerify()
	{
		$t = $this->getCCVerify();
		$this->setCCVerify(0);
		return $t;
	}

	public function getMerchantID() { return $this->merchantID; }
	public function setMerchantID($id) { $this->merchantID = $id; }
	
	public function getMerchantPW () { return $this->merchantPW; }
	public function setMerchantPW ($pw) { $this->merchantPW = $pw; }
	
	public function getBankTxnID () { return $this->bankTxnID; }
	public function setBankTxnID ($id) { $this->bankTxnID = $id; }
	
	public function getRequestType () { return $this->requestType; }
	public function setRequestType ($t) { $this->requestType = $t; }
	
	public function getPeriodicType () { return $this->periodicType; }
	public function setPeriodicType ($t) { $this->periodicType = $t; }
	
	public function getPeriodicInterval () { return $this->periodicInterval; }
	public function setPeriodicInterval ($t) { $this->periodicInterval = $t; }

	public function getStartDate () { return $this->startDate; }
	public function setStartDate ($t) { $this->startDate = $t; }

	public function getClientID () { return $this->clientID; }
	public function setClientID ($t) { $this->clientID = $t; }
	
	public function getAction () { return $this->action; }
	public function setAction ($t) { $this->action = $t; }
	
	public function getNumberOfPayments () { return $this->numberOfPayments; }
	public function setNumberOfPayments ($t) { $this->numberOfPayments = $t; }
	
	public function getErrorString () { return $this->errorString; }
	
	public function getResultArray () { return $this->responseArray; }

	public function getResultByKeyName ($keyName)
	{
		if (array_key_exists($keyName, $this->responseArray) === true)
		{
			return $this->responseArray[$keyName];
		}
		return false;
	}
	
	public function getTxnWasSuccesful()
	{
		if (array_key_exists("txnResult", $this->responseArray)	&& $this->responseArray["txnResult"] === true)
		{
			return true;
		}
		return false;
	}
	
	public function setAuth($id, $pw)
	{
		$this->setMerchantID($id);
		$this->setMerchantPW($pw);
		return;
	}
	
	public function setFraudGuard($val)
	{
		if($val)
		{
			$this->fraudGuard = 1;
		}
		else
		{
			$this->fraudGuard = 0;
		}
		
		return;
	}
	
	public function isFraudGuard() { return $this->fraudGuard; }
	
	public function setFirstName($i) { $this->fgFirstName = $i; }
	public function getFirstName() { return $this->fgFirstName; }

	public function setLastName($i) { $this->fgLastName = $i; }
	public function getLastName() { return $this->fgLastName; }

	public function setPostCode($i) { $this->fgPostCode = $i; }
	public function getPostCode() { return $this->fgPostCode; }
	
	public function setTown($i) { $this->fgTown = $i; }
	public function getTown() { return $this->fgTown; }
	
	public function setCountryB($i) { $this->fgCountryB = $i; }
	public function getCountryB() { return $this->fgCountryB; }
	
	public function setCountryD($i) { $this->fgCountryD = $i; }
	public function getCountryD() { return $this->fgCountryD; }
	
	public function setEmail($i) { $this->fgEmail = $i; }
	public function getEmail() { return $this->fgEmail; }
	
	public function setIP($i) { $this->fgIP = $i; }
	public function getIP() { return $this->fgIP; }
	
	public function getFraudGuardCode()
	{
		if (array_key_exists("fraudGuardCode", $this->responseArray) === true)
		{
			return $this->$responseArray["fraudGuardCode"];
		}
		return false;
	}
	public function getFraudGuardText()
	{
		if (array_key_exists("fraudGuardText", $this->responseArray) === true)
		{
			return $this->$responseArray["fraudGuardText"];
		}
		return false;
	}

	/**
	 * clearFraudGuard
	 *
	 * Clears Fraud-Guard details. For reusing class instances in unit tests.
	 */
	public function clearFraudGuard()
	{
		$this->setFraudGuard(0);
		$this->setFirstName("");
		$this->setLastName("");
		$this->setPostCode("");
		$this->setTown("");
		$this->setCountryB("");
		$this->setCountryD("");
		$this->setEmail("");
		$this->setIP("");
		
		return;
	}
	
	//FraudGuard & associated methods are untested
	/**
	 * initFraudGuard
	 *
	 * Sets up FraudGuard details for FraudGuard transactions. Call this before the processFraudguard* function.
	 *
	 * @param string $ip - IP address
	 * @param string $first - First name
	 * @param string $last - Last name
	 * @param string $post - Post code
	 * @param string $town
	 * @param string $country_bill - Billing country (2-3 Character ISO numeric or alphabetical code)
	 * @param string $country_delivery (2-3 Character ISO numeric or alphabetical code)
	 * @param string $email
	 *
	 * All except IP are optional.
	 */
	public function initFraudGuard($ip, $first = '', $last = '', $post = '', $town = '', $country_bill = '', $country_delivery = '', $email = '')
	{
		$this->setFraudGuard(1);
		$this->setFirstName($first);
		$this->setLastName($last);
		$this->setPostCode($post);
		$this->setTown($town);
		$this->setCountryB($country_bill);
		$this->setCountryD($country_delivery);
		$this->setEmail($email);
		$this->setIP($ip);
		
		return;
	}

	/**
	 * processCreditStandard:
	 *
	 * Process a standard credit card payment
	 *
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string txnReference - Merchant's unique transaction ID
	 * @param int cardNumber - 12-18 digit credit-card number
	 * @param int cardMonth - 2 digit month
	 * @param int cardYear - 2 or 4 digit year
	 * @param int cardVerify - 3 or 4 digit CVV (optional)
	 * @param string currency - Exactly three characters. See SecurePay documentation for list of valid currencies. (optional)
	 *
	 * @return string txnID - Bank's unique transaction ID (use for reversal or refund), or FALSE in case of failure (check $this->getErrorText() afterwards).
	 */
	public function processCreditStandard($amount, $txnReference, $cardNumber, $cardMonth, $cardYear, $cardVerify=0, $currency=SECUREPAY_CURRENCY_DEFAULT)
	{
		$this->reset();
		
		if(!$this->getTxnType()) //i.e. If not already set to FraudGuard
		{
			$this->setTxnType(SECUREPAY_TXN_STANDARD);
		}
		
		if($currency)
		{
			$this->setCurrency($currency);
		}
		
		/* This indicates to the XML constructor that payment details should be included in the request. */
		$this->setAction(SECUREPAY_ACTION_ADD);
		
		$this->setAmount($amount);
		
		$this->setTxnReference($txnReference);
		$this->setCCNumber($cardNumber);
		
		if($cardVerify == true && strlen($cardVerify)!=0)
		{
			$this->setCCVerify($cardVerify);
		}
		
		$this->setCCExpiryYear($cardYear);
		$this->setCCExpiryMonth($cardMonth);
		
		if($this->processTransaction())
		{
			if(array_key_exists('banktxnID',$this->responseArray))
			{
				return $this->responseArray['banktxnID'];
			}
		}
		return false;
	}

	/**
	 * processCreditRefund:
	 *
	 * Refund a standard credit card payment. $amount can be less than the original transaction.
	 *
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string txnReference - Merchant's unique transaction ID: must be same as in initial transaction
	 * @param int txnID - Transaction ID of original transaction, received as a response on approval
	 *
	 * @return string txnID - Bank's unique transaction ID, or FALSE in case of failure (check $this->getErrorText() afterwards).
	 */
	public function processCreditRefund($amount, $txnReference, $txnID)
	{
		$this->reset();
		
		$this->setTxnType(SECUREPAY_TXN_REFUND);
		
		$this->setAmount($amount);
		$this->setTxnReference($txnReference);
		
		$this->setBankTxnID($txnID);
		
		if($this->processTransaction())
		{
			if(array_key_exists('banktxnID',$this->responseArray))
			{
				return $this->responseArray['banktxnID'];
			}
		}
		return false;
	}

	/**
	 * processCreditReverse:
	 *
	 * Reverse a standard credit card payment. $amount should be same as in original transaction.
	 *
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string txnReference - Merchant's unique transaction ID: must be same as in initial transaction
	 * @param int txnID - Transaction ID of original transaction, received as a response on approval
	 *
	 * @return string txnID - Bank's unique transaction ID, or FALSE in case of failure (check $this->getErrorText() afterwards).
	 */
	public function processCreditReverse($amount, $txnReference, $txnID)
	{
		$this->reset();
		
		$this->setTxnType(SECUREPAY_TXN_REVERSE);
		
		$this->setAmount($amount);
		$this->setTxnReference($txnReference);
		
		$this->setBankTxnID($txnID);
		
		if($this->processTransaction())
		{
			if(array_key_exists('banktxnID',$this->responseArray))
			{
				return $this->responseArray['banktxnID'];
			}
		}
		return false;
	}

	/**
	 * processCreditPreauth:
	 * 
	 * Preauthorise a credit card payment
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string txnReference - Merchant's unique transaction ID
	 * @param int cardNumber - 12-18 digit credit-card number
	 * @param int cardMonth - 2 digit month
	 * @param int cardYear - 2 or 4 digit year
	 * @param int cardVerify - 3 or 4 digit CVV (optional)
	 * @param string currency - Exactly three characters. See SecurePay documentation for list of valid currencies. (optional)
	 * 
	 * @return string preauthID - preauthorisation ID (use to execute transaction later (processCreditAdvice)), or FALSE (check $this->getErrorText() afterwards).
	 */
	public function processCreditPreauth($amount, $txnReference, $cardNumber, $cardMonth, $cardYear, $cardVerify=0, $currency=SECUREPAY_CURRENCY_DEFAULT)
	{
		$this->reset();
		
		$this->setTxnType(SECUREPAY_TXN_PREAUTH);
		
		if($currency)
		{
			$this->setCurrency($currency);
		}
		
		$this->setAction(SECUREPAY_ACTION_ADD);
		
		$this->setAmount($amount);
		$this->setTxnReference($txnReference);
		$this->setCCNumber($cardNumber);
		
		if(strlen($cardVerify)!=0)
		{
			$this->setCCVerify($cardVerify);
		}
		
		$this->setCCExpiryYear($cardYear);
		$this->setCCExpiryMonth($cardMonth);
		
		if($this->processTransaction())
		{
			if(array_key_exists('preauthID',$this->responseArray))
			{
				return $this->responseArray['preauthID'];
			}
		}
		return false;
	}

	/**
	 * processCreditAdvice:
	 *
	 * Execute a preauthorised transaction
	 *
	 * @param float amount - Numeric and decimal only: no thousand separators. Should be same as preauthorised amount.
	 * @param string txnReference - Merchant's unique transaction ID: must be same as in initial transaction
	 * @param string preauthID - Preauthorisation code which was returned from processCreditPreauth
	 *
	 * @return string txnID - Bank's unique transaction ID, or FALSE in case of failure (check $this->getErrorText() afterwards).
	 */
	public function processCreditAdvice($amount, $txnReference, $preauthID)
	{
		$this->reset();
		
		$this->setTxnType(SECUREPAY_TXN_ADVICE);
		
		$this->setAmount($amount);
		$this->setTxnReference($txnReference);
		$this->setPreauthID($preauthID);
		
		if($this->processTransaction())
		{
			if(array_key_exists('banktxnID',$this->responseArray))
			{
				return $this->responseArray['banktxnID'];
			}
		}
		return false;
	}
	
	//Not used/tested yet
	/**
	 * processDirectCredit:
	 * 
	 * Execute a Direct Entry/Credit transaction
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators. Should be same as preauthorised amount.
	 * @param string txnReference - Merchant's unique transaction ID: must be same as in initial transaction
	 * @param string accName - Account name
	 * @param string accBSB - Account BSB: 6 digits
	 * @param string accNumber - Account number. Digits only
	 * 
	 * @return string txnID - Bank's unique transaction ID, or FALSE in case of failure (check $this->getErrorText() afterwards).
	 */
	public function processDirectCredit($amount, $txnReference, $accName, $accBSB, $accNumber)
	{
		$this->reset();
		
		$this->setTxnType(SECUREPAY_TXN_DIRECTCREDIT);
		
		$this->setAction(SECUREPAY_ACTION_ADD);
		
		$this->setAmount($amount);
		$this->setTxnReference($txnReference);
		$this->setAccName($accName);
		$this->setAccNumber($accNumber);
		$this->setAccBSB($accBSB);

		if($this->processTransaction())
		{
			if(array_key_exists('banktxnID',$this->responseArray))
			{
				return $this->responseArray['banktxnID'];
			}
		}
		return false;
	}
	
	//Not used/tested yet
	/**
	 * processDirectDebit:
	 * 
	 * Execute a Direct Entry/Debit transaction
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators. Should be same as preauthorised amount.
	 * @param string txnReference - Merchant's unique transaction ID: must be same as in initial transaction
	 * @param string accName - Account name
	 * @param string accBSB - Account BSB: 6 digits
	 * @param string accNumber - Account number. Digits only
	 * 
	 * @return string txnID - Bank's unique transaction ID, or FALSE in case of failure (check $this->getErrorText() afterwards).
	 */
	public function processDirectDebit($amount, $txnReference, $accName, $accBSB, $accNumber)
	{
		$this->reset();
		$this->setTxnType(SECUREPAY_TXN_DIRECTDEBIT);
		
		$this->setAction(SECUREPAY_ACTION_ADD);
		
		$this->setAmount($amount);
		$this->setTxnReference($txnReference);
		$this->setAccName($accName);
		$this->setAccNumber($accNumber);
		$this->setAccBSB($accBSB);
		
		if($this->processTransaction())
		{
			if(array_key_exists('banktxnID',$this->responseArray))
			{
				return $this->responseArray['banktxnID'];
			}
		}
		return false;
	}
	
	//Not used/tested yet
	/**
	 * processFraudGuard:
	 * 
	 * Execute a FraudGuard/Credit transaction
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string txnReference - Merchant's unique transaction ID
	 * @param int cardNumber - 12-18 digit credit-card number
	 * @param int cardMonth - 2 digit month
	 * @param int cardYear - 2 or 4 digit year
	 * @param int cardVerify - 3 or 4 digit CVV (optional)
	 * @param string currency - Exactly three characters. See SecurePay documentation for list of valid currencies. (optional)
	 * 
	 * @return string txnID - Bank's unique transaction ID, or FALSE in case of failure (check $this->getErrorText() afterwards).
	 * 
	 * @notes Check $this->getFraudGuardCode() and $this->getFraudGuardText() afterwards for details.
	 */
	public function processFraudGuard($amount, $txnReference, $cardNumber, $cardMonth, $cardYear, $cardVerify=0, $currency=SECUREPAY_CURRENCY_DEFAULT)
	{
		$this->reset();
		$this->setTxnType(SECUREPAY_TXN_ANTIFRAUD_PAY);
		
		return $this->processCreditStandard($amount, $txnReference, $cardNumber, $cardMonth, $cardYear, $cardVerify, $currency);
	}
	
	//Not used/tested yet
	/**
	 * processFraudGuardCheck:
	 * 
	 * Execute a FraudGuard/Check transaction
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string txnReference - Merchant's unique transaction ID
	 * @param int cardNumber - 12-18 digit credit-card number
	 * @param int cardMonth - 2 digit month
	 * @param int cardYear - 2 or 4 digit year
	 * @param int cardVerify - 3 or 4 digit CVV (optional)
	 * @param string currency - Exactly three characters. See SecurePay documentation for list of valid currencies. (optional)
	 * 
	 * @return string txnID - Bank's unique transaction ID, or FALSE in case of failure (check $this->getErrorText() afterwards).
	 * 
	 * @notes Check $this->getFraudGuardCode() and $this->getFraudGuardText() afterwards for details.
	 */
	public function processFraudGuardCheck($amount, $txnReference, $cardNumber, $cardMonth, $cardYear, $cardVerify=0, $currency=SECUREPAY_CURRENCY_DEFAULT)
	{
		$this->reset();
		$this->setTxnType(SECUREPAY_TXN_ANTIFRAUD_CHECK);
		
		return $this->processCreditStandard($amount, $txnReference, $cardNumber, $cardMonth, $cardYear, $cardVerify, $currency);
	}
	
	/**
	 * processStandardPeriodicAdd:
	 * 
	 * Schedules a credit-card transaction (either periodic or triggered).
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string clientID The client identifier; payment details are stored against this value.
	 * 
	 * @param int type The periodic type. 1-4, see constants at top of file
	 * @param int interval The frequency/interval of scheduled payments on these acc details. If type is DAY, this is the number of days in between payments. If type is CALENDAR, this is one of the SECUREPAY_CAL constants. If type is Once or Triggered, this is irrelevant.
	 * @param string start When to process the first payment. string format: YYYYMMDD; "" for Triggered
	 * @param int numPayments How many times should this account be charged according to the schedule defined above? N/A for Once, Triggered
	 * 
	 * @param int cardNumber - 12-18 digit credit-card number
	 * @param int cardMonth - 2 digit month
	 * @param int cardYear - 2 or 4 digit year
	 * @param int cardVerify - 3 or 4 digit CVV (optional)
	 * @param string currency - Exactly three characters. See SecurePay documentation for list of valid currencies. (optional)
	 * 
	 * @return boolean true for success, false for failure
	 */
	public function processStandardPeriodicAdd($amount, $clientID, $type, $interval, $start, $numPayments, $cardNumber, $cardMonth, $cardYear, $cardVerify=0)
	{
		$this->reset();
		$this->setTxnType(SECUREPAY_TXN_STANDARD);
		$this->setAction(SECUREPAY_ACTION_ADD);
		
		$this->setClientID($clientID);
		
		$this->setAmount($amount);
		
		$this->setCCNumber($cardNumber);
		$this->setCCExpiryYear($cardYear);
		$this->setCCExpiryMonth($cardMonth);
		
		if($cardVerify == true && strlen($cardVerify)!=0)
		{
			$this->setCCVerify($cardVerify);
		}
		
		$this->setPeriodicType($type);
		$this->setPeriodicInterval($interval);
		$this->setStartDate($start);
		$this->setNumberOfPayments($numPayments);
		
		if($this->processTransaction())
		{
			return (strtoupper($this->getResultByKeyName('approved'))=='YES'?true:false);
		}
		return false;
	}
	
	
	//Direct Entry is untested
	/**
	 * processDirectPeriodicAdd:
	 * 
	 * Schedules a direct debit/credit transaction (either periodic or triggered).
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string clientID The client identifier; payment details are stored against this value.
	 * 
	 * @param int type The periodic type. 1-4, see constants at top of file
	 * @param int interval The frequency/interval of scheduled payments on these acc details. If type is DAY, this is the number of days in between payments. If type is CALENDAR, this is one of the SECUREPAY_CAL constants. If type is Once or Triggered, this is irrelevant.
	 * @param string start When to process the first payment. string format: YYYYMMDD; "" for Triggered
	 * @param int numPayments How many times should this account be charged according to the schedule defined above? N/A for Once, Triggered
	 * 
	 * @param int accName - Account Name: alphanumeric
	 * @param int accBSB - Account BSB, 6 digits
	 * @param int accNumber - account number, digits only
	 * @param string credit - Debit or credit? "yes" for credit, "no" for debit
	 * 
	 * @return boolean true for success, false for failure
	 */
	public function processDirectPeriodicAdd($amount, $clientID, $type, $interval, $start, $numPayments, $accountName, $accountBSB, $accountNumber, $credit="no")
	{
		$this->reset();
		
		if($credit == "no")
		{
			$this->setTxnType(SECUREPAY_TXN_DIRECTDEBIT);
		}
		else if ($credit == "yes")
		{
			$this->setTxnType(SECUREPAY_TXN_DIRECTCREDIT);
		}
		else
		{
			$this->errorString = 'Error: Bad $credit value';
			return false;
		}
		
		$this->setAction(SECUREPAY_ACTION_ADD);
		
		$this->setClientID($clientID);
		$this->setAmount($amount);
		
		$this->setAccName($accountName);
		$this->setAccNumber($accountNumber);
		$this->setAccBSB($accountBSB);
		$this->setCredit($credit);
		
		$this->setPeriodicType($type);
		$this->setPeriodicInterval($interval);
		$this->setStartDate($start);
		$this->setNumberOfPayments($numPayments);
		
		if($this->processTransaction())
		{
			return (strtoupper($this->getResultByKeyName('approved'))=='YES'?true:false);
		}
		return false;
	}
	
	/**
	 * processTrigger:
	 * 
	 * Triggers a payment against a client id which has Trigger payment associations
	 * 
	 * @param float amount - Numeric and decimal only: no thousand separators
	 * @param string clientID The client identifier; payment details are stored against this value.
	 * 
	 * @return boolean true for success, false for failure
	 */
	public function processTrigger($amount, $clientID)
	{
		$this->reset();
		
		$this->setTxnType(SECUREPAY_TXN_PERIODIC);
		$this->setAction(SECUREPAY_ACTION_TRIGGER);
		$this->setPeriodicType(SECUREPAY_PERIODIC_TRIGGERED);
		
		$this->setClientID($clientID);
		$this->setAmount($amount);
		
		if($this->processTransaction())
		{
			if(array_key_exists('banktxnID',$this->responseArray))
			{
				return $this->responseArray['banktxnID'];
			}
		}
		return false;
	}
	
	/**
	 * processPeriodicDelete:
	 * 
	 * Delete a periodic client id from the gateway, along with the associated payment details (and scheduled payments)
	 * 
	 * @param string txnid The Triggered transaction identifier. Returned from processTriggerAdd, and used in Delete/Trigger transactions.
	 * 
	 * @return boolean true for success, false for failure
	 */
	public function processPeriodicDelete($clientID)
	{
		$this->reset();
		$this->setTxnType(SECUREPAY_TXN_PERIODIC);
		$this->setAction(SECUREPAY_ACTION_DELETE);
		
		$this->setClientID($clientID);
		
		if($this->processTransaction())
		{
			return (strtoupper($this->getResultByKeyName('approved'))=='YES'?true:false);
		}
		return false;
	}
	
	
	/**
	 * processTransaction:
	 * 
	 * Attempts to process the transaction using the supplied details
	 * 
	 * @return boolean Returns true for succesful (approved) transaction / false for failure (declined) or error
	 */
	private function processTransaction ()
	{
		//Check for gateway validity
		if (!$this->gatewayObjectValid)
		{
			$this->errorString = self::GATEWAY_ERROR_OBJECT_INVALID;
			return false;
		}
		
		//Check the relevant unique parameters
		if($this->getTxnType()==SECUREPAY_TXN_STANDARD || $this->getTxnType()==SECUREPAY_TXN_PREAUTH || $this->getTxnType()==SECUREPAY_TXN_ANTIFRAUD_PAY || $this->getTxnType()==SECUREPAY_TXN_ANTIFRAUD_CHECK)
		{
			if ($this->checkCCParameters() == false)
			{
				return false;
			}
		}
		else if ($this->getTxnType()==SECUREPAY_TXN_DIRECTDEBIT || $this->getTxnType()==SECUREPAY_TXN_DIRECTCREDIT)
		{
			if ($this->checkDirectParameters() == false)
			{
				return false;
			}
		}
		
		//Check the common parameters
		if ($this->checkTxnParameters() == false)
		{
			return false;
		}
		
		//Create request message. Destroys CC/CCV values if present
		$requestMessage = $this->createXMLTransactionRequestString();
		
		//Send request
		$response = $this->sendRequest($this->gatewayURL, $requestMessage);
		
		//Remove the request from memory
		unset($requestMessage);
		
		//Confirm response
		if ($response === false)
		{
			if (strlen($this->errorString) == 0)
			{
				$this->errorString = self::GATEWAY_ERROR_RESPONSE_ERROR;
			}
			return false;
		}
		
		//Save the response
		$this->responseArray["raw-response"] = htmlentities($response);
		
		//Validate it
		if ($this->responseToArray($response) === false)
		{
			if (strlen($this->errorString) == 0)
			{
				$this->errorString = self::GATEWAY_ERROR_RESPONSE_INVALID;
			}
			return false;
		}
		
		//The transaction is successful and "approved" if the above tests have been passed
		$this->responseArray["txnResult"] = true;
		
		return true;
	}
	
	/**
	 * checkCCParameters
	 *
	 * Check the input parameters are valid for a credit card transaction
	 * 
	 * @return boolean Return TRUE for all checks passed OK, or FALSE if an error is detected
	 */
	private function checkCCParameters()
	{
		//$ccNumber must be numeric, and have between 12 and 19 digits
		if (strlen($this->getCCNumber()) < 12 || strlen($this->getCCNumber()) > 19 || preg_match("/\D/",$this->getCCNumber()))//Regex matches non-digit
		{
			$this->errorString = self::GATEWAY_ERROR_INVALID_CCNUMBER;
			return false;
		}
		
		//$ccExpiryMonth must be numeric between 1 and 12
		if (preg_match("/\D/", $this->getCCExpiryMonth()) || (int) $this->getCCExpiryMonth() < 1 || (int) $this->getCCExpiryMonth() > 12)
		{
			$this->errorString = self::GATEWAY_ERROR_INVALID_CCEXPIRY;
			return false;
		}
		
		//$ccExpiryYear is in YY format, and must be between this year and +12 years from now
		if (preg_match("/\D/", $this->getCCExpiryYear()) || (strlen($this->getCCExpiryYear()) != 2) || 
			(int) $this->getCCExpiryYear() < (int) substr(date("Y"),2) || (int) $this->getCCExpiryYear() > ((int) substr(date("Y"),2) + 12))
		{
			$this->errorString = self::GATEWAY_ERROR_INVALID_CCEXPIRY;
			return false;
		}
		
		//CVV is optional
		if ($this->getCCVerify() != false)
		{
			//$ccVericationNumber must be numeric between 000 and 9999
			if (preg_match("/\D/", $this->getCCVerify()) || strlen($this->getCCVerify()) < 3 || strlen($this->getCCVerify()) > 4 ||
				(int) $this->getCCVerify() < 0 || (int) $this->getCCVerify() > 9999)
			{
				$this->errorString = self::GATEWAY_ERROR_INVALID_CC_CVC;
				return false;
			}
		}
		return true;
	}
	
	//Not used/tested yet
	/**
	 * checkDirectParameters
	 * 
	 * Check the input parameters are valid for a direct entry transaction
	 * 
	 * @return boolean Return TRUE for all checks passed OK, or FALSE if an error is detected
	 */
	private function checkDirectParameters()
	{
		//$accNumber must be numeric between 12 and 19 digits long
		if (preg_match("/\D/", $this->getAccNumber())) //Match non-numeral
		{
			$this->errorString = self::GATEWAY_ERROR_INVALID_ACCOUNTNUMBER;
			return false;
		}
		
		if (!preg_match("/[a-zA-Z0-9 _]+/", $this->getAccName())) //Match non alpha-numeric, space & underscore
		{
			$this->errorString = self::GATEWAY_ERROR_INVALID_ACCOUNTNAME;
			return false;
		}
		
		//$accBSB must be numeric between 000000 and 999999
		if (preg_match("/\D/", $this->getAccBSB())) //Match non-numeral
		{
			$this->errorString = self::GATEWAY_ERROR_INVALID_BSB;
			return false;
		}
		
		return true;
	}
	
	/**
	 * checkTxnParameters
	 * 
	 * Check that the common values are within requirements
	 * 
	 * @param string $txnAmount
	 * @param string $txnReference
	 * 
	 * @return TRUE for pass, FALSE for fail
	 */
	private function checkTxnParameters ()
	{
		$amount = $this->getAmount();
		if (preg_match("/^[0-9]/", $amount)==false || (float)$amount < 0)
		{
			$this->errorString = self::GATEWAY_ERROR_INVALID_TXN_AMT;
			return false;
		}
		
		if($this->getRequestType() == SECUREPAY_REQUEST_PAYMENT)
		{
			$ref = $this->getTxnReference();
			if ($this->getTxnType()==SECUREPAY_TXN_DIRECTDEBIT ||
				$this->getTxnType()==SECUREPAY_TXN_DIRECTCREDIT)
			{
				//Direct Entry references need to conform to EBCDIC, and should be <= 18 characters
				if (strlen($ref) == 0 || strlen($ref)>18 ||
					preg_match('/[^0-9a-zA-Z*\.&\/-_\']/', $ref)) //Matches non-EBCDIC characters
				{
					$this->errorString = self::GATEWAY_ERROR_INVALID_REF_ID;
					return false;
				}
			}
			else
			{
				//Credit transaction references can have any character except space and single quote and need to be less than 60 characters
				if (strlen($ref) == 0 || strlen($ref)>60 ||
					preg_match('/[^ \']/', $ref)==false) //Matches space and '
				{
					$this->errorString = self::GATEWAY_ERROR_INVALID_REF_ID;
					return false;
				}
			}
		}
		return true;
	}
	
    /**
	 * createXMLTransactionRequestString:
	 * 
	 * Creates the XML request string for a transaction request message. Destroys CC/CVV values.
	 * 
	 * @return string xml_transaction
     */
	private function createXMLTransactionRequestString()
	{
		$requestType = $this->getRequestType();
		
		if($requestType == SECUREPAY_REQUEST_PAYMENT)
		{
			$list = 'TxnList';
			$item = 'Txn';
			$apiVer = 'xml-4.2';
		}
		else if ($requestType == SECUREPAY_REQUEST_PERIODIC)
		{
			$list = 'PeriodicList';
			$item = 'PeriodicItem';
			$apiVer = 'spxml-4.2';
		}
		else
		{
			$apiVer = 'xml-4.2';
		}
		
		$x =
				'<?xml version="1.0" encoding="UTF-8" ?>'.
				'<SecurePayMessage>' .
					'<MessageInfo>' .
						'<messageID>'.htmlentities($this->getTxnReference().date('His').current(split(' ',microtime()))).'</messageID>'.
						'<messageTimestamp>'.htmlentities($this->getGMTTimeStamp()).'</messageTimestamp>'.
						'<timeoutValue>'.htmlentities(self::TIMEOUT).'</timeoutValue>'.
						'<apiVersion>'.$apiVer.'</apiVersion>'.
					'</MessageInfo>'.
					'<MerchantInfo>'.
						'<merchantID>'.htmlentities($this->getMerchantID()).'</merchantID>' .
						'<password>'.htmlentities($this->getMerchantPW()).'</password>' .
					'</MerchantInfo>'.
					'<RequestType>'.$requestType.'</RequestType>';
					
		if($requestType != SECUREPAY_REQUEST_ECHO)
		{
			$x .=	'<'.$requestType.'>'.
						'<'.$list.' count="1">'.
							'<'.$item.' ID="1">';
			if($requestType==SECUREPAY_REQUEST_PERIODIC)
			{
				$x .=			'<actionType>'.htmlentities($this->getAction()).'</actionType>';
				$x .=	 		'<clientID>'.htmlentities($this->getClientID()).'</clientID>';
					
				if($this->getAction()==SECUREPAY_ACTION_ADD)
				{
					$x .= 		'<amount>'.htmlentities($this->getAmount()).'</amount>';
					$x .= 		'<periodicType>'.htmlentities($this->getPeriodicType()).'</periodicType>';
					
					if($this->getPeriodicType()!=SECUREPAY_PERIODIC_TRIGGERED)
					{
						$x .=	'<startDate>'.htmlentities($this->getStartDate()).'</startDate>';
						if($this->getPeriodicType()!=SECUREPAY_PERIODIC_ONCE)
						{
							$x.='<paymentInterval>'.htmlentities($this->getPeriodicInterval()).'</paymentInterval>';
							$x.='<numberOfPayments>'.htmlentities($this->getNumberOfPayments()).'</numberOfPayments>';
						}
					}
				}
				else if ($this->getAction()==SECUREPAY_ACTION_TRIGGER)
				{
					if($this->getAmount())
					{
						$x .=	'<amount>'.htmlentities($this->getAmount()).'</amount>';
					}
				}
			}
			else if ($requestType==SECUREPAY_REQUEST_PAYMENT)
			{
				$x .=			'<txnType>'.htmlentities($this->getTxnType()).'</txnType>'.
								'<txnSource>23</txnSource>'. //23 is the XML API
								'<amount>'.htmlentities($this->getAmount()).'</amount>'.
								'<purchaseOrderNo>'.htmlentities($this->getTxnReference()).'</purchaseOrderNo>';
				if($this->getTxnType()==SECUREPAY_TXN_ADVICE)
				{
					$x .=		'<preauthID>'.htmlentities($this->getPreauthID()).'</preauthID>';
				}
				if(	$this->getTxnType()==SECUREPAY_TXN_REFUND ||
					$this->getTxnType()==SECUREPAY_TXN_REVERSE &&
					$this->getBankTxnID() != 0)
				{
					$x .=		'<txnID>'.htmlentities($this->getBankTxnID()).'</txnID>';
				}
			}
			
			if(($this->getTxnType()==SECUREPAY_TXN_STANDARD ||
				$this->getTxnType()==SECUREPAY_TXN_PREAUTH) &&
				$this->getCurrency()!=SECUREPAY_CURRENCY_DEFAULT)
			{
				$x .=			'<currency>'.htmlentities($this->getCurrency()).'</currency>';
			}
				
			if(($this->getTxnType()==SECUREPAY_TXN_STANDARD	||
				$this->getTxnType()==SECUREPAY_TXN_PREAUTH) && $this->getAction() == SECUREPAY_ACTION_ADD)
			{
				$x .=			'<CreditCardInfo>'.
									'<cardNumber>'.htmlentities($this->getClearCCNumber()).'</cardNumber>';
				if (trim($this->getCCVerify()) != false)
				{
					$x .=			'<cvv>'.htmlentities($this->getClearCCVerify()).'</cvv>';
				}
				$x .=				'<expiryDate>'.htmlentities(sprintf('%02d',$this->getCCExpiryMonth()).'/'.sprintf('%02d',$this->getCCExpiryYear())).'</expiryDate>'.
								'</CreditCardInfo>';
			}
			else if (($this->getTxnType()==SECUREPAY_TXN_DIRECTDEBIT ||
					  $this->getTxnType()==SECUREPAY_TXN_DIRECTCREDIT) && $this->getAction() == SECUREPAY_ACTION_ADD)
			{
				$x .=			'<DirectEntryInfo>'.
									'<bsbNumber>'.htmlentities($this->getAccBSB()).'</bsbNumber>'.
									'<accountNumber>'.htmlentities($this->getAccNumber()).'</accountNumber>'.
									'<accountName>'.htmlentities($this->getAccName()).'</accountName>'.
								'</DirectEntryInfo>';
			}
			
			if ($this->isFraudGuard())
			{
				$x .=			'<BuyerInfo>'.
									'<firstName>'.htmlentities($this->getFirstName()).'</firstName>'.
									'<lastName>'.htmlentities($this->getLastName()).'</lastName>'.
									'<zipCode>'.htmlentities($this->getPostCode()).'</zipCode>'.
									'<town>'.htmlentities($this->getTown()).'</town>'.
									'<billingCountry>'.htmlentities($this->getCountryB()).'</billingCountry>'.
									'<deliveryCountry>'.htmlentities($this->getCountryD()).'</deliveryCountry>'.
									'<emailAddress>'.htmlentities($this->getEmail()).'</emailAddress>'.
									'<ip>'.htmlentities($this->getIP()).'</ip>'.
								'</BuyerInfo>';
			}
			
			$x .=			'</'.$item.'>'.
						'</'.$list.'>'.
					'</'.$requestType.'>';
		} //!echo
		
		if ($this->getIdentifier())
		{
			$x .=	'<identifier>'.htmlentities($this->getIdentifier()).'</identifier>';
		}
		
		$x .=	'</SecurePayMessage>';
		
		return $x;
	}
	
	/**
	 * getGMTTimeStamp:
	 * 
	 * this function creates a timestamp formatted as per requirement in the
	 * SecureXML documentation
	 *
	 * @return string The formatted timestamp
	 */
	public function getGMTTimeStamp()
	{
		/* Format: YYYYDDMMHHNNSSKKK000sOOO
			YYYY is a 4-digit year
			DD is a 2-digit zero-padded day of month
			MM is a 2-digit zero-padded month of year (January = 01)
			HH is a 2-digit zero-padded hour of day in 24-hour clock format (midnight =0)
			NN is a 2-digit zero-padded minute of hour
			SS is a 2-digit zero-padded second of minute
			KKK is a 3-digit zero-padded millisecond of second
			000 is a Static 0 characters, as SecurePay does not store nanoseconds
			sOOO is a Time zone offset, where s is + or -, and OOO = minutes, from GMT.
		*/
		$tz_minutes = date('Z') / 60;
		
		if ($tz_minutes >= 0)
		{
			$tz_minutes = '+' . strval($tz_minutes);
		}
		
		$stamp = date('YdmGis000000') . $tz_minutes;
		
		return $stamp;
	}
	
	/**
	 * sendRequest: 
	 *
	 * uses cURL to open a Secure Socket connection to the gateway,
	 * sends the transaction request and then returns the response
	 * data
	 * 
	 * @param $postURL The URL of the remote gateway to which the request is sent
	 * @param $requestMessage
	 */
	private function sendRequest($postURL, $requestMessage)
	{
		$ch = curl_init();
		
		//Set up curl parameters
		curl_setopt($ch, CURLOPT_URL, $postURL);		// set remote address
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	// Make CURL pass the response as a curl_exec return value instead of outputting to STDOUT
		curl_setopt($ch, CURLOPT_POST, 1);	 			// Activate the POST method
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestMessage);	// add the request message itself
		
		//execute the connection
		$result = curl_exec($ch);
		
		$debugoutput = curl_getinfo($ch);
		$curl_error_message = curl_error($ch); // must retrieve an error message (if any) before closing the curl object 
		
		curl_close($ch);
		
		if ($result === false)
		{
			$this->errorString = self::GATEWAY_ERROR_CURL_ERROR.' : '.$curl_error_message;
			return false;
		}
		
		//Trim headers
		$pos = strstr($result, "\n");
		$result = substr($result, $pos);
		
		return $result;
	}
	
	/**
	 * responseToArray: 
	 *
	 * Pulls the important values out of the response message and stores them in $this->responseArray
	 * 
	 * @param string $responseMessage - An XML response from the gateway
	 * @return boolean True to indicate succesful decoding of response message AND succesful txn result, false to indicate an error or declined result
	 */
	private function responseToArray ($responseMessage)
	{
		$xmlres = array();
		$xmlres = $this->convertXMLToNestedArray($responseMessage);
		
		if ($xmlres === false)
		{
			if (strlen($this->errorString) == 0)
			{
				$this->errorString = self::GATEWAY_ERROR_RESPONSE_XML_MESSAGE_ERROR;
			}
			return false;
		}
		
		$responseArray['raw-XML-response'] = htmlentities($responseMessage);
		
		$statusCode = trim($xmlres['SecurePayMessage']['Status']['statusCode']);
		$statusDescription = trim($xmlres['SecurePayMessage']['Status']['statusDescription']);
		$requestType = $this->getRequestType();
		
		$responseArray['statusCode'] = $statusCode;
		$responseArray['statusDescription'] = $statusDescription;
		$responseArray['RequestType'] = $requestType;
		
		//Three digit codes indicate a response from the Securepay gateway (error detected by gateway) 
		if (strcmp($statusCode, '000') != 0 && strcmp($statusCode, '00') != 0 && strcmp($statusCode, '0') != 0)
		{
			$this->errorString = self::GATEWAY_ERROR_SECUREPAY_STATUS.' : '.$statusCode.' '.$statusDescription;
			return false;
		}
		
		if($requestType == SECUREPAY_REQUEST_PAYMENT)
		{
			$list = 'TxnList';
			$item = 'Txn';
			$approved = 'approved';
		}
		else if ($requestType == SECUREPAY_REQUEST_PERIODIC)
		{
			$list = 'PeriodicList';
			$item = 'PeriodicItem';
			$approved = 'successful';
		}

		/* Common response values */
		$responseArray['messageID'] = trim($xmlres['SecurePayMessage']['MessageInfo']['messageID']);
		$responseArray['messageTimestamp'] = trim($xmlres['SecurePayMessage']['MessageInfo']['messageTimestamp']);
		$responseArray['apiVersion'] = trim($xmlres['SecurePayMessage']['MessageInfo']['apiVersion']);
		$responseArray['merchantID'] = trim($xmlres['SecurePayMessage']['MerchantInfo']['merchantID']);		
		
		$responseArray['approved'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item][$approved]);
		$responseArray['responseCode'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['responseCode']);
		$responseArray['responseText'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['responseText']);
		
		
		if($requestType==SECUREPAY_REQUEST_PERIODIC)
		{
			if(array_key_exists('txnID',$xmlres['SecurePayMessage'][$requestType][$list][$item]))
			{
				$responseArray['banktxnID'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['txnID']);
			}
		}
		else
		{
			$responseArray['banktxnID'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['txnID']);
			
			$responseArray['txnType'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['txnType']);
			$responseArray['txnSource'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['txnSource']);
			$responseArray['amount'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['amount']);
			
			$responseArray['settlementDate'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['settlementDate']);
			
			if($this->isFraudGuard())
			{
				$responseArray['fraudGuardCode'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['antiFraudResponseCode']);
				$responseArray['fraudGuardText'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['antiFraudResponseText']);
			}
			
			if($this->getTxnType()==SECUREPAY_TXN_PREAUTH && array_key_exists('preauthID',$xmlres['SecurePayMessage'][$requestType][$list][$item]))
			{
				$responseArray['preauthID'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['preauthID']);
			}
		}
		
		if(	$this->getTxnType()==SECUREPAY_TXN_STANDARD	||
			$this->getTxnType()==SECUREPAY_TXN_PREAUTH)
		{
			$responseArray['creditCardPAN'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['CreditCardInfo']['pan']);
			$responseArray['expiryDate'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['CreditCardInfo']['expiryDate']);
		}
		else if (strtoupper($responseArray['approved']) == 'YES' &&
				($this->getTxnType()==SECUREPAY_TXN_DIRECTDEBIT ||
				 $this->getTxnType()==SECUREPAY_TXN_DIRECTCREDIT))
		{
			$responseArray['bsbNumber'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['DirectEntryInfo']['bsbNumber']);
			$responseArray['accountNumber'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['DirectEntryInfo']['accountNumber']);
			$responseArray['accountName'] = trim($xmlres['SecurePayMessage'][$requestType][$list][$item]['DirectEntryInfo']['accountName']);
		}
		
		$this->responseArray = $responseArray;
		
		/* field 'successful' = 'Yes' means 'triggered transaction successfully registered', anything else is failure */
		/* Tests for the known Approved response codes. */
		if ((strcasecmp($responseArray['approved'], 'Yes') ==  0) &&
			(strcmp($responseArray['responseCode'], '0') === 0 ||
			 strcmp($responseArray['responseCode'], '00') === 0 ||
			 strcmp($responseArray['responseCode'], '08') === 0 ||
			 strcmp($responseArray['responseCode'], '000') === 0 ||
			 strcmp($responseArray['responseCode'], '77') === 0))
		{
			return true;
		}
		else
		{
			$this->errorString = self::GATEWAY_ERROR_TXN_DECLINED.' ('.trim($responseArray['responseCode']).'): '.trim($responseArray['responseText']);
			return false;
		}
	}
	
	
	/**
	 * convertXMLToNestedArray: 
	 * converts an XML document into a nested array structure 
	 * 
	 * @param string $XMLDocument An XML document
	 * @return boolean True to indicate succesful conversion of document, false to indicate an error 
	 */
	private function convertXMLToNestedArray ($XMLDocument)
	{
		$output = array();
		
		$parser = xml_parser_create();
		
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		$parse_result = xml_parse_into_struct($parser, $XMLDocument, $values);
		
		if ($parse_result === 0)
		{
			$this->errorString = self::GATEWAY_ERROR_XML_PARSE_FAILED.": ".xml_get_error_code ($parser)." ".xml_error_string (xml_get_error_code ($parser));
			xml_parser_free($parser);
			
			return false;
		}
		
		xml_parser_free($parser);
		
		$hash_stack = array();
		
		foreach ($values as $val)
		{
			switch ($val['type'])
			{
				case 'open':
					array_push($hash_stack, $val['tag']);
					break;
				
				case 'close':
					array_pop($hash_stack);
					break;
				
				case 'complete':
					array_push($hash_stack, $val['tag']);
					if (array_key_exists('value', $val))
					{
						eval("\$output['" . implode($hash_stack, "']['") . "'] = \"{$val['value']}\";");
					}
					else // to handle empty self closing tags i.e. <paymentInterval/>
					{
						eval("\$output['" . implode($hash_stack, "']['") . "'] = null;");
					}
					array_pop($hash_stack);
					break;
			}
		}
		return $output;
	}
}
