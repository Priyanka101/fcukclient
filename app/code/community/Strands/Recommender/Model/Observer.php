<?php

Class Strands_Recommender_Model_Observer extends Strands_Recommender_Model_Abstract
{
	
	
	/**
	 * replacement constructor method
	 */
	protected function _construct()
	{
		parent::_construct();
	}
	
	
	/**
	 * call method for events
	 * At call we make a url call to strands
	 * 
	 * @param $observer observer from the dispatch Event
	 */
	public function eventCartChange($observer)
	{
		if (!$this->isActive()) return;
		$api = Mage::getSingleton('recommender/api');
		
		$api->setApiAction('addshoppingcart')
				->setUser($this->getStrandsId(true))
				->setCartItems($this->getCartItems())
				->callApi();
	
		return $this;
	}	

	
	public function eventWishlistAdd($observer)
	{
		if (!$this->isActive()) return;
		$api = Mage::getSingleton('recommender/api');
		$product = $observer->getEvent()->getProduct();
		
		$api->setApiAction('addwishlist')
				->setUser($this->getStrandsId(true))
				->setProduct($product->getId())
				->callApi();
	
		return $this;
	}
	
	
	public function eventUserLogin($observer)
	{
		if (!$this->isActive()) return;
		$api = Mage::getSingleton('recommender/api');
		$session = Mage::getSingleton("customer/session");
		
		if (strlen(Mage::app()->getFrontController()->getRequest()->getCookie('strandsSBS_P_UserId'))) {
			Mage::getModel('core/cookie')->set('strandsSBS_P_UserId',$session->getCustomerId(),true,'/',null,null,false);
		} else {
			if (strlen(Mage::app()->getFrontController()->getRequest()->getCookie('strandsSBS_S_UserId'))) {
				$api->setApiAction('userlogged')
					->setOldUser(Mage::app()->getFrontController()->getRequest()->getCookie('strandsSBS_S_UserId'))
					->setUser($this->getStrandsId(true))
					->callApi();
			} else {
				Mage::getModel('core/cookie')->set('strandsSBS_P_UserId',$session->getCustomerId(),true,'/',null,null,false);
			}
		} 

		return $this;
	}
	
	
	public function eventPostDispatchSearch($observer)
	{
		if (!$this->isActive()) return;
		$api = Mage::getSingleton('recommender/api');
		$data = Mage::helper('recommender');
		
		$api->setApiAction('searched')
			->setSearchKeywords(Mage::app()->getFrontController()->getRequest()->getParam('q'))
			->setUser($this->getStrandsId(true))
			->callApi();
		
		return $this;
	}
	
	
	public function eventPostDispatchProductView($observer)
	{
		if (!$this->isActive()) return;
		
		if (Mage::getStoreConfigFlag('recommender/tracking/js_tracking')) return;
		
		$api = Mage::getSingleton('recommender/api');
		$data = Mage::helper('recommender');
		
		$api->setApiAction('visited')
			->setProduct($this->getCurrentProduct()->getId())
			->setUser($this->getStrandsId(true))
			->callApi();
			
		return $this;
	}
	
	
	public function eventPreDispatch($observer)
	{
		$api = Mage::getSingleton('recommender/api');
		$data = Mage::helper('recommender');
		
		$cont = $observer->getEvent()->getControllerAction();
		$groups = $cont->getRequest()->getPost('groups');
		
		if ($cont->getRequest()->getParam('section') == 'recommender') {
			$callApi = false;
			$freedirectory = false;
			
			//$fields = $cont->getRequest()->getParam('section');
			if (intval(Mage::getStoreConfigFlag('recommender/account/active')) != intval($groups['account']['fields']['active']['value'])) {
				if ($groups['account']['fields']['active']['value']) {
					//$api->setBaseApiUrl('https://recommender.strands.com/signup_activate');
					$api->setBaseApiUrl('https://recommender.strands.com/account/plugin/setup/');
					$api->setTarget('setup');
					$callApi = true;	
				} else {
					//$api->setBaseApiUrl('https://recommender.strands.com/signup_deactivate');
					$api->setBaseApiUrl('https://recommender.strands.com/account/plugin/deactivate/');
					$api->setTarget('deactivate');
					$callApi = true;
				}	
			}
			
			elseif (Mage::getStoreConfig('recommender/account/strands_api_id') != $groups['account']['fields']['strands_api_id']['value']) {
				//$api->setBaseApiUrl('https://recommender.strands.com/signup_activate');
				$api->setBaseApiUrl('https://recommender.strands.com/account/plugin/setup/');
				$api->setTarget('setup');
				$callApi = true;			
			} 
			
			elseif (Mage::getStoreConfig('recommender/account/strands_customer_token') != $groups['account']['fields']['strands_customer_token']['value']) {
				$api->setBaseApiUrl('https://recommender.strands.com/account/plugin/setup/');
				$api->setTarget('setup');
				$callApi = true;
			}
			
			elseif (Mage::getStoreConfig('recommender/catalog/select') != $groups['catalog']['fields']['select']['value']) {
				$api->setBaseApiUrl('https://recommender.strands.com/account/plugin/setup/');
				$api->setTarget('setup');
				$callApi = true;
			}
			
			
			
			if ($callApi) {
				if ($groups['catalog']['fields']['select']['value'] === '0')
					$feedactive = 'true';
				else
					$feedactive = 'false';				
					
				$api->setType('magento')
					->setMessage(false)
					->setRecommenderApiId($groups['account']['fields']['strands_api_id']['value'])
					->setRecommenderCustomerToken($groups['account']['fields']['strands_customer_token']['value'])
					->setPassvApiUrl(htmlentities(Mage::app()->getStore()->getBaseUrl()."recommender/index"))
					->setFeedActive($feedactive)
					->callApi();
			}	
					
			if (intval($groups['cron']['fields']['strands_catalog_upload_now']['value']) == 1) {
				Mage::getConfig()->saveConfig('recommender/cron/strands_uploadcatalognow',time());
			}
			
				
			
			$coreResource = Mage::getSingleton('core/resource');
			$read = $coreResource->getConnection('core_read');
			$config_data = $coreResource->getTableName ('core_config_data');
			$termDB = '"design/package/name"';
			$sql = "SELECT value FROM $config_data WHERE path=$termDB";
			$packageDB = $read->fetchAll($sql);
			if ($packageDB[0]['value'] !== '')
				$package = $packageDB[0]['value'];
			else 
				$package = 'default';		
			
			$termDB = '"design/theme/default"';
			$sql = "SELECT value FROM $config_data WHERE path=$termDB";
			$themesDB = $read->fetchAll($sql);
			if ($themesDB[0]['value'] !== '')
				$themes = $themesDB[0]['value'];
			else
				$themes = 'default';
				
				
			if (count($packageDB) == 0)
				$package = 'default';
			elseif ($packageDB[0]['value'] !== '')
				$package = $packageDB[0]['value'];
			else 
				$package = 'default';		
			
			$termDB = '"design/theme/default"';
			$sql = "SELECT value FROM $config_data WHERE path=$termDB";
			$themesDB = $read->fetchAll($sql);
			if (count($themesDB) == 0)
				$themes = 'default';
			elseif ($themesDB[0]['value'] !== '')
				$themes = $themesDB[0]['value'];
			else
				$themes = 'default';	
				
				
			
/*			$package = Mage::getStoreConfig('design/package/name');
			if ($package == '') 
    			$package = 'default';
			$themes = Mage::getStoreConfig('design/theme/default');
			if ($themes == '')
				$themes = 'default';
*/			
				
			$automatic = true;
			
			if (intval($groups['tracking']['fields']['js_tracking']['value']) == 0) {
				$js_tracking = false;
			} else {
				$js_tracking = true;
			}
			
			if (intval($groups['widgets-homepage']['fields']['active']['value']) == 0) {
				if ($groups['widgets-homepage']['fields']['block']['value'] != '') {
					$homepage = $groups['widgets-homepage']['fields']['block']['value'];
					if ($groups['widgets-homepage']['fields']['position']['value'] == '0')
						$homepagePos = 'before';
					else
						$homepagePos = 'after';
				} else {
					$homepage = 'before_body_end';
					$homepagePos = '';
				}
			} else {
				$homepage = '';
				$homepagePos = '';
			}
			if (intval($groups['widgets-product']['fields']['active']['value']) == 0) {
				if ($groups['widgets-product']['fields']['block']['value'] != '') {
					$product = $groups['widgets-product']['fields']['block']['value'];
					if ($groups['widgets-product']['fields']['position']['value'] == '0')
						$productPos = 'before';
					else
						$productPos = 'after';
				} else {
					$product = 'before_body_end';
					$productPos = '';
				}
			} else {
				$product = '';
				$productPos = '';
			}
			if (intval($groups['widgets-category']['fields']['active']['value']) == 0) {
				if ($groups['widgets-category']['fields']['block']['value'] != '') {
					$category = $groups['widgets-category']['fields']['block']['value'];
					if ($groups['widgets-category']['fields']['position']['value'] == '0')
						$categoryPos = 'before';
					else
						$categoryPos = 'after';
				} else {
					$category = 'before_body_end';
					$categoryPos = '';
				}
			} else {
				$category = '';
				$categoryPos = '';
			}
			if (intval($groups['widgets-cart']['fields']['active']['value']) == 0) {
				if ($groups['widgets-cart']['fields']['block']['value'] != '') {
					$cart = $groups['widgets-cart']['fields']['block']['value'];
					if ($groups['widgets-cart']['fields']['position']['value'] == '0')
						$cartPos = 'before';
					else
						$cartPos = 'after';
				} else {
					$cart = 'before_body_end';
					$cartPos = '';
				}
			} else {
				$cart = '';
				$cartPos = '';
			}
			if (intval($groups['widgets-checkout']['fields']['active']['value']) == 0) {
				if ($groups['widgets-checkout']['fields']['block']['value'] != '') {
					$checkout = $groups['widgets-checkout']['fields']['block']['value'];
					if ($groups['widgets-checkout']['fields']['position']['value'] == '0')
						$checkoutPos = 'before';
					else
						$checkoutPos = 'after';
				} else {
					$checkout = 'before_body_end';
					$checkoutPos = '';
				}
			} else {
				$checkout = '';
				$checkoutPos = '';
			}
				
			$api->insertWidgets($automatic,$package,$themes, $js_tracking, $homepage,$homepagePos,$product,$productPos,$category,$categoryPos,$cart,$cartPos,$checkout,$checkoutPos);
			
		}
		
		return $this;
	}
	
	
	public function eventPayInvoice($observer)
	{
		if (!$this->isActive()) return;
		$api = Mage::getSingleton('recommender/api');
		$order = $observer->getEvent()->getPayment()->getOrder();
		$items = $order->getItemsCollection();
		
		$itemsUrl = '';
		
		foreach ($items as $item) {
			if ($item->getHasChildren()) {
				if ($item->getParentItem() != null) {
					continue;
				} else {
					continue;
				}
			} else {
				if ($item->getParentItem() != null)	{
					$itemsUrl .= "&item=" . urlencode($item->getParentItem()->getProductId() . "::" . $item->getParentItem()->getPriceInclTax() . "::" . $item->getParentItem()->getQtyOrdered());		
				} else {
					$itemsUrl .= "&item=" . urlencode($item->getProductId() . "::" . $item->getPriceInclTax() . "::" . $item->getQtyOrdered());
				}
			}			
			
		}
		
		if ($order->getOrderCurrencyCode() != null)
			$currency_code = $order->getOrderCurrencyCode();
		else 
			$currency_code = Mage::app()->getStore()->getCurrentCurrencyCode();
			
		$orderId = $order->getIncrementId();
		
		$api->setApiAction('purchased')
			->setUser($this->getStrandsId(true))
			->setItems($itemsUrl)
			->setOrderId($orderId)
			->setCurrency($currency_code)
			->callApi();
	}
	
	
	public function uploadCatalog()
	{
		
		if (!$this->isActive()) return;
		
		Mage::getConfig()->saveConfig('recommender/cron/last_cron_action', Mage::getModel('core/date')->timestamp(time()));
		
		$timeBefore = date(DATE_RSS);
		
		$timeCatalog = $this->getDesiredCatalogTime();		
		
		if ($timeCatalog == null)
			$timeCatalog = '00:00:00';

		$currentTime = date ("H:i:s", Mage::getModel('core/date')->timestamp(time()));
		$currentHour = $currentTime[0].$currentTime[1];
		$currentMinute = $currentTime[3].$currentTime[4];	
		$catalogHour = $timeCatalog[0].$timeCatalog[1];
		$catalogMinute = $timeCatalog[3].$timeCatalog[4];
			
		if (($this->getUploadCatalogNow()+65 < time()) && (($currentHour != $catalogHour) || ($currentMinute != $catalogMinute))) { 	
			return;
		}
		
		$ftpuser = $this->getLoginCron();
		$ftppass = $this->getPasswordCron();

		$ftp = $this->ftpCatalog($ftpuser,$ftppass);
		
		if ($ftp) {
			Mage::getConfig()->saveConfig('recommender/catalog/strands_catalog_time',date('D, d M Y H:i:s' , Mage::getModel('core/date')->timestamp(time())));
			Mage::getConfig()->saveConfig('recommender/cron/strands_catalog_upload_now',0);
		}
	
	}
	
	public function ftpCatalog($ftpuser,$ftppass)
	{
		$localfile = "strandsCatalog.xml";
		$absPath = Mage::getBaseDir();
		$localpath = $absPath."/media/";
		
		//$this->extractCatalog($localpath,$localfile);
		$this->writeCatalog($localpath, $localfile);
		
		$timeAfter = date(DATE_RSS);
		
		$ftpserver = "recommender.strands.com";
		$ftppath = "/catalog/complete";
		
		$remoteurl = "ftp://${ftpuser}:${ftppass}@${ftpserver}${ftppath}/${localfile}";
		
		$fp = curl_init(); 
		
		$lc = fopen("$localpath$localfile","r");
		
		curl_setopt($fp, CURLOPT_URL, $remoteurl);
//		curl_setopt($fp, CURLOPT_BINARYTRANSFER, 0);
		curl_setopt($fp, CURLOPT_UPLOAD, 1);
		curl_setopt($fp, CURLOPT_INFILE, $lc);
		
		$success = curl_exec($fp);
		curl_close($fp);
		fclose($lc);
		
		if ($success) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Method to retrive cart collection
	 * 
	 * @return Mage_Sales_Model_Qoute?
	 */
	protected function getCartItems()
	{
		 return Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection(); 
	}
	
	
}

?>
