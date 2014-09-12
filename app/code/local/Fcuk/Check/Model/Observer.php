<?php class Fcuk_Check_Model_Observer
{
	
	
	public function curl_get($url, array $get = NULL, array $options = array()){   
			$defaults = array(
				CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get),
				CURLOPT_HEADER => 0,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_TIMEOUT => 4
			);
		   
			$ch = curl_init();
			curl_setopt_array($ch, ($options + $defaults));
			if( ! $result = curl_exec($ch))
			{
				trigger_error(curl_error($ch));
			}
		//	var_dump ($result);
	//var_dump (curl_getinfo($ch));
			curl_close($ch);
			return $result;
	}
	public function placeOrderSuccess(Varien_Event_Observer $observer) {
        
		 $order_ids = $observer->getEvent()->getOrderIds(); 
		
		 $order = Mage::getModel('sales/order')->load($order_ids[0]);
	$increment_id = $order->getData('increment_id');
	$total = $order->getData('grand_total');
	$customer = Mage::getModel('customer/customer')->load($order->getCustomerId()); 

    // Get the id of the orders shipping address
    $billingId = $order->getBillingAddress()->getId();
    // Get shipping address data using the id
    $address = Mage::getModel('sales/order_address')->load($billingId);
	$telephone = $address->getData('telephone');

		
		$feedId = 339848;
		$username = 9820032460;
		$password = 'wgwmm';
		$To = $telephone;
		$text = 'Thank you for shopping on FrenchConnection.in. Your order no: #'.$increment_id.' amounting to Rs. '.$total.' is being processed. Do check your email for further details.';
	//$time = 200812110950;
	$time = date("YmdHi");
	$senderid = 'FCUKFC';
		$fields = array('feedid' => $feedId,
        'username' => $username,
        'password' => $password,
        'To' =>$To,
        'Text' => $text,
        'time' => $time,
        'senderid' => $senderid);
		
		/* Call function */
		$callcheck = $this->curl_get('http://bulkpush.mytoday.com/BulkSms/SingleMsgApi',$fields);
		
		return $this;
		  
		 
    }
	
	 
		public function customattributeset(Varien_Event_Observer $observer) {
				echo 'checkobserver';
				exit;
		}
}