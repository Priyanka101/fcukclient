<?php

Class Strands_Recommender_Model_Api extends Strands_Recommender_Model_Abstract
{
	const DEBUG = false;
	
	protected $_items = null;
	protected $_param = array();
	
	
	public function _construct()
	{
		$this->setBaseApiUrl("http://bizsolutions.strands.com/api2/event/");
	}
	
	
	/**
	 * Method for Api Call 
	 * 
	 * @param $args array of different args for the call
	 */
	public function callApi()
	{
		$session = Mage::getSingleton('core/session');
		
		//if (!$this->isActive()) return;
	
		///$apiCall = $this->getBaseApiUrl() . $this->getApiAction() . '.sbs?apid=' . $this->getApiId();
		
		$apiCall = $this->getBaseApiUrl();
		
		if ($this->getApiAction()) {
			$apiCall = $apiCall . $this->getApiAction() . '.sbs?apid=' . $this->getApiId();
		} else {
			$apiCall = $apiCall . '?apid=' . $this->getApiId() . '&token=' . $this->getCustomerToken();
			$apiCall = $apiCall . '&version=' . $this->getVersion();
			if ($this->getTarget() == 'setup') {
				$apiCall = $apiCall . '&id=id&title=title&link=link&description=description&image_link=image_link&price=saleprice&tag=tag&category=category';
			}
		}
		

		if ($this->getApiAction() == 'userlogged'){
			/*
			 * Block for user logged in action
			 */
			$apiCall .= "&olduser=" . $this->getOldUser();			
		} 
		elseif ($this->getApiAction() == "addshoppingcart") {
			/*
			 * Block for modifying the shopping cart
			 */
			
			if (count($this->getCartItems())) {
				$_items = '';
							
				foreach ($this->getCartItems() as $item) {
					if ($item->getHasChildren()) {
						if ($item->getParentItem() != null) {
							continue;
						} else {
							continue;
						}
					} else {
						if ($item->getParentItem() != null)	{
							$_items .= "&item=" . urlencode($item->getParentItem()->getProductId());		
						} else {
							$_items .= "&item=" . urlencode($item->getProductId());
						}
					}
				}
				$apiCall .= $_items;
			}
		}
		
		if ($this->hasData('product')) $apiCall .= "&item=" . urlencode($this->getProduct());
		if ($this->hasData('items')) $apiCall .= $this->getItems();
		if ($this->hasData('order_id')) $apiCall .= "&orderid=" . $this->getOrderId();
		if ($this->hasData('search_keywords')) $apiCall .= "&searchstring=" . urlencode($this->getSearchKeywords());
		if ($this->hasData('user') && strlen($this->getUser())) $apiCall .= "&user=" . $this->getUser();
		if ($this->hasData('type')) $apiCall .= "&type=" . $this->getType();
		if ($this->hasData('passv_api_url')) $apiCall .= "&feed=" . $this->getPassvApiUrl();
		if ($this->hasData('feed_active')) $apiCall .= "&feedactive=" . $this->getFeedActive();
		if ($this->hasData('currency')) $apiCall .= "&currency=" . $this->getCurrency();
		
		$response = $this->makeCall($apiCall);
		
		
		if ($this->getLogStatus()) {
			$message = ($response['success']) ? 'Success' : 'Failed';
			$message .= ": Request Call: $apiCall\r\n";
			$message .= $response['message'];
			
			
			if (!$success = Mage::helper('recommender/logger')->log($message)) {
				//$session->addError('Recommender log failed to instantate or write');
			}			 
		}
		
		//if ($response['success']) $session->addError($response['message']);
		//else $session->addError($response['message']);
		
		return $this;
	}
	
	
	/**
	 * Method for cURL call
	 * 
	 * @param $url is the URL we are calling
	 * @return array response
	 */
	protected function makeCall($url, $params = array())
	{
		$ret = array('success' => true);
		
		try {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
    		curl_setopt($curl, CURLOPT_HEADER, false);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //
    		//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($curl, CURLOPT_USERAGENT, "Magento Strands Recommender v1.0");
    		
			if (isset($params['CURLOPT']) && count($params['CURLOPT'])) {
    			foreach ($params['CURLOPT'] as $k => $v) {
    				curl_setopt($curl, constant("CURLOPT_$k"), $v);
    			} 
    		}
    	
    		$ret['message'] = curl_exec($curl);
    		$ret['message'] = ($this->getMessage()) ? $ret['message'] : 'Success';
    		
    		curl_close($curl);
		} catch(Exception $e) {
			$ret['success'] = false;
			$ret['message'] = $e->getMessage();
		}
		
    	return $ret;
	}

	public function callApiTwo()
	{
		$apiCall = $this->getBaseApiUrl() . "?";
		$session = Mage::getModel('adminhtml/session');
		
		$i = 0;
		$params_data = '';
		foreach ($this->_param as $key => $val) {
			$params_data .= ($i > 0) ? "&$key=$val" : "$key=$val";
			$i++;
		}
		
		$options = array(
					'CURLOPT' => array(
						'POST' => true,
						'POSTFIELDS' => $params_data
					));
					
		$response = $this->makeCall($apiCall, $options);

		$serialOpts = serialize($options);
		if ($this->getLogStatus()) {
			$message = ($response['success']) ? 'Success' : 'Failed';
			$message .= ": Request Call: $apiCall\r\n";
			$message .= "Params: $params_data\r\n";
			$message .= "Options: $options\r\n";
			$message .= $response['message'];
			
			
			if (!$success = Mage::helper('recommender/logger')->log($message)) {
				//$session->addError('Recommender log failed to instantate or write');
			}			 
		}
		
		return $this;	
	}
	
	public function setParam($key, $val) 
	{
		$this->_param[$key] = $val;
		return $this;
	}
	
	protected function getMessage()
	{
		if (!$this->hasData('message')) $this->setMessage(true);
		return $this->getData('message');
	}
	
	public function checkCatalogFeed()
	{
		$apiCall = 'http://recommender.strands.com/account/plugin/feedtest/';
		$apiCall.= '?apid='.$this->getApiId();
		$apiCall.= '&token='.$this->getCustomerToken();
		$apiCall.= '&type=magento';
		$apiCall.= '&url=';
		$apiCall.= htmlentities(Mage::getUrl("recommender/index", array('_secure' => true)));
		$apiCall.= 'feedtest?';
		$apiCall.= 'api_id='.$this->getApiId();
		$apiCall.= '&customer_id='.$this->getCustomerToken();

		$response = $this->makeCall($apiCall);
		if ($response['success']) {
			$xml = simplexml_load_string($response['message']);
			$result = (string) $xml->status;
			if ($result == 'SUCCESS')
				return true;
			else 
				return false;
		} 
		return false;
	}
	
	
	//// Changes done for automatic insertion of widgets
	public function insertWidgets($automatic,$package,$themes,$js_tracking, $homepage,$homepagePos,$product,$productPos,$category,$categoryPos,$cart,$cartPos,$checkout,$checkoutPos)
	{
		
		$absPath = Mage::getBaseDir();
		$relPath = '/app/design/frontend/';
		$defPackage = 'default';
		$defThemes = 'default';

		$layout = 'layout';
		$template = 'template';
		$layoutRec = 'strands_recommender.xml';
		$pathWidget = 'strands/recommender';
		$fileWidget = 'widget.phtml';
		$widgetRec = $pathWidget.'/'.$fileWidget;
		
		$finalPackage = $package;
		$finalThemes = $themes;
		
		$dirFinalP = $absPath.$relPath.$finalPackage;
		$dirFinalPT = $dirFinalP.'/'.$finalThemes;
		
		$checkFinalP = file_exists($dirFinalP);
		// If Package directory does not exist, it takes default
		if (!$checkFinalP) {
			$dirFinalP = $absPath.$relPath.$defPackage;
			$dirFinalPT = $dirFinalP.'/'.$finalThemes;
		}
		// If Themes directory does not exist, it takes default
		$checkFinalPT = file_exists($dirFinalPT);
		if (!$checkFinalPT) {
			$dirFinalPT = $dirFinalP.'/'.$defThemes;	
		}
		
		$checkFinalPT = file_exists($dirFinalPT);
		if (!$checkFinalPT) {
			// It is not possible to locate the right directory
			Mage::getConfig()->saveConfig('recommender/setup/widgets','not possible to locate the right package/theme in '.$dirFinalPT);
			return;
		}
		
		$dirFinalLayout = $dirFinalPT.'/'.$layout;
		$dirFinalTemplates = $dirFinalPT.'/'.$template;
		
		$checkFinalLayout = file_exists($dirFinalLayout);
		$checkFinalTemplates = file_exists($dirFinalTemplates);
		
		if ($checkFinalPT && !$checkFinalLayout) {
			mkdir($dirFinalLayout,0755,true);
		}
		
		
		if ($checkFinalPT && !$checkFinalTemplates) {
			mkdir($dirFinalTemplates,0755,true);
		}
		
		$checkFinalLayout = file_exists($dirFinalLayout);
		$checkFinalTemplates = file_exists($dirFinalTemplates);
		
		if (!$checkFinalLayout || !$checkFinalTemplates) {
			Mage::getConfig()->saveConfig('recommender/setup/widgets','layout or template are not available in '.$dirFinalPT);
			return ;
		}
		
		if ($automatic) {
			if ($homepage !== '') {
				if ($homepage == 'before_body_end') {
					$homepageD = 
'		<reference name="before_body_end" before="recommender.js">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="before_body_end" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
				} else {
					$homepageD = 
'		<reference name="'.$homepage.'" '.$homepagePos.'="-">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="'.$homepage.'" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
				}
			} else {
				$homepageD = '';
			}
			
			if ($product !== '') {
				if ($product == 'before_body_end') {
					$productD = 
'		<reference name="before_body_end" before="recommender.js">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="before_body_end" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';			
				} else {
					$productD = 
'		<reference name="'.$product.'" '.$productPos.'="-">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="'.$product.'" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';					
				}
			} elseif ($js_tracking) {
				$productD = 
'
		<reference name="before_body_end">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
			} else {
				$productD = '';
			}
			
			if ($category !== '') {
				if ($category == 'before_body_end') {
					$categoryD = 
'		<reference name="before_body_end" before="recommender.js">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="before_body_end" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
				} else {
					$categoryD = 
'		<reference name="'.$category.'" '.$categoryPos.'="-">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="'.$category.'" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
				}
			} else {
				$categoryD = '';
			}
			
			if ($cart !== '') {
				if ($cart == 'before_body_end') {
					$cartD = 
'		<reference name="before_body_end" before="recommender.js">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="before_body_end" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
				} else {
					$cartD = 
'		<reference name="'.$cart.'" '.$cartPos.'="-">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="'.$cart.'" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
				}
			} else {
				$cartD = '';
			}
			
			if ($checkout !== '') {
				if ($checkout == 'before_body_end') {
					$checkoutD = 
'		<reference name="before_body_end" before="recommender.js">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="before_body_end" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';	
				} else {
					$checkoutD = 
'		<reference name="'.$checkout.'" '.$checkoutPos.'="-">
			<block type="recommender/widget" name="recommender.widget" />
		</reference>
		<reference name="'.$checkout.'" after="recommender.widget">
			<block type="recommender/js" name="recommender.js"/>
		</reference>
';
				}
			} else {
				$checkoutD = '';
			}
			
		} 
		
		$layoutSuccess = $this->writeInLayout($dirFinalLayout.'/'.$layoutRec, $homepageD, $productD, $categoryD, $cartD, $checkoutD);
		$templateSuccess = $this->writeInTemplate($dirFinalTemplates,$pathWidget,$fileWidget);
		
		if (!$layoutSuccess) {
			Mage::getConfig()->saveConfig('recommender/setup/widgets','not possible to write layout in '.$dirFinalPT);
			return;
		} elseif (!$templateSuccess) {
			Mage::getConfig()->saveConfig('recommender/setup/widgets','not possible to write template in '.$dirFinalPT);
			return;
		} else {
			Mage::getConfig()->saveConfig('recommender/setup/widgets','successful installation in '.$dirFinalPT);
			return;
		}
		
	}
	
	
	private function writeInLayout ($file,$homepageD,$productD,$categoryD,$cartD,$checkoutD)
	{
		$fh = fopen($file,'w');
		$dataHeader = 
'<?xml version="1.0"?>
<layout version="1.0.0">
	
';
		$dataHomepage = 
'	<!--
	Load Recommender on the homepage
	-->
	<cms_index_index>
'.
$homepageD.
'	</cms_index_index>
	
';	
		$dataProduct = 
'	<!--
	Load Recommender on the product page
	-->
	<catalog_product_view>
'.
$productD.
'	</catalog_product_view>	

';
		$dataCategory = 
'	<!--
	Load Recommender on the category page
	-->
	<catalog_category_view>		
'.
$categoryD.
'	</catalog_category_view>
	
';
		$dataCart =
'	<!--
	Load Recommender on the shopping cart page
	-->
	<checkout_cart_index>
'.
$cartD.
'	</checkout_cart_index>
	
';	
		$dataCheckoutOne =
'	<!--
	Load Recommender on the success purchase page for onepage checkout page
	-->
	<checkout_onepage_success>
'.
$checkoutD.
'	</checkout_onepage_success>
	
';
		$dataCheckoutMulti =
'	<!--
	Load Recommender on the success purchase page for multishipping checkout page
	-->
	<checkout_multishipping_success>
'.
$checkoutD.
'	</checkout_multishipping_success>

';
		$dataEnd =
'</layout>

';		

		fwrite($fh, $dataHeader);
		fwrite($fh, $dataHomepage);
		fwrite($fh, $dataProduct);
		fwrite($fh, $dataCategory);
		fwrite($fh, $dataCart);
		fwrite($fh, $dataCheckoutOne);
		fwrite($fh, $dataCheckoutMulti);
		fwrite($fh, $dataEnd);
		fclose($fh);
		chmod($file,0755);
		
		if (file_exists($file)) {
			return true;
		} else { 
			return false;
		}
	}
	
	
	private function writeInTemplate ($destPath,$relPath,$sourceFile) {
		$finalPath = $destPath.'/'.$relPath;
		$fileName = $finalPath.'/'.$sourceFile;
		if (!file_exists($finalPath)) {
			$successDir = mkdir($finalPath,0755,true);
		} else
			$successDir = true;
		//if (!file_exists($fileName)) {
		if (true) {
			$fh = fopen($fileName, 'w');
			$data1 = 
'<div 	class="strandsRecs"
';
			$data2 =
'		tpl="<?php echo $this->getWidgetName() ?>"
';
			$data3 =
'		<?php echo ($this->getStrandsId()) 	? "user=\\"{$this->getStrandsId()}\\"" : \'\' ?>
';
			$data4 =
'		<?php echo ($this->getItem()) 		? "item=\\"{$this->getItem()}\\"" : \'\' ?>
';
			$data5 = 
'		<?php echo ($this->getDFilter()) 	? "dfilter=\\"{$this->getDFilter()}\\"" : \'\' ?>></div>	
';

			fwrite($fh, $data1);
			fwrite($fh, $data2);
			fwrite($fh, $data3);
			fwrite($fh, $data4);
			fwrite($fh, $data5);	
			
			fclose($fh);
			chmod($fileName,0755);
			if (file_exists($fileName)) { 
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	

	
	private function copyFileFromDir ($absPath, $relPath, $sourceFile, $destPath)
	{
		$finalPath = $destPath.'/'.$relPath;
		if (!file_exists($finalPath)) {
			$successDir = mkdir($finalPath,0755,true);
		} else 
			$successDir = true;	
			
		$sourcePath = $absPath.'/'.$relPath.'/'.$sourceFile;
		$successCopy = copy($sourcePath, $finalPath.'/'.$sourceFile);
		$successChmodFile = chmod($finalPath.'/'.$sourceFile,0755);
		
	}
	
	
}

?>