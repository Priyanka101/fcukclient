<?php
class Mac_Requestcatalog_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Request Catalog"));
	    //    $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
    /*   $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("request catalog", array(
                "label" => $this->__("Request Catalog"),
                "title" => $this->__("Request Catalog")
		   )); */

      $this->renderLayout(); 
	  
    } 
	public function AddressAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Request Catalog"));
      $this->renderLayout(); 
	  
    }
	public function AutomatedAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Request Catalog"));
      $this->renderLayout(); 
	  
    }	
	public function StoreAction() {
      $pData = array();
	  $id   = $this->getRequest()->getParams();
//print_r($id);
		$insertArray = array();
		$insertArray['title'] =$this->getRequest()->getParam('title');
		$insertArray['firstname'] =$this->getRequest()->getParam('firstname');
		$insertArray['lastname'] =$this->getRequest()->getParam('lastname');
		$insertArray['email'] =$this->getRequest()->getParam('email');
		$insertArray['address'] =$this->getRequest()->getParam('address');
	//	$insertArray['address1'] =$this->getRequest()->getParam('address[1]');
	//	$insertArray['address'] =$this->getRequest()->getParam('address[0]').''.$this->getRequest()->getParam('address[1]');;
		$insertArray['city'] =$this->getRequest()->getParam('city');
		$insertArray['state'] =$this->getRequest()->getParam('region');
		
					if($this->getRequest()->getParam('country_id'))
			        {
	
						// $countryselected looks like "US"
						$country = Mage::getModel('directory/country')->loadByCode($this->getRequest()->getParam('country_id'));
						$countryname= $country->getName();

			
					}
		$insertArray['country'] =$countryname;
		
		$insertArray['postcode'] =$this->getRequest()->getParam('postcode');
		$insertArray['subscriptionstatus'] =$this->getRequest()->getParam('chkReceiveEmails');
		$insertArray['hearaboutus'] =$this->getRequest()->getParam('WhereDidYouHearAboutUsselect');
		//print_r($insertArray);
		$model = Mage::getModel('requestcatalog/requestcatalog');
		$model->setData($insertArray);
		$model->save();
		/* 
		$this->loadLayout();   
		
		$this->getLayout()->getBlock("head")->setTitle($this->__("Request Catalog"));
		$this->renderLayout(); */ 
		$layout = $this->loadLayout();
	    $this->renderLayout(); 
/*
	$block = $this->getLayout()->createBlock(
	'Mage_Core_Block_Template',
	'PPWD_Custom',
	array('template' => 'cms/thankyou.phtml')
	);
	echo $block->toHtml();
	*/
	  
    }
	public function ViewAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Request Catalog"));
      $this->renderLayout(); 
	  
    }
}