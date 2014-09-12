<?php

class Fcuk_Check_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Check"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("check", array(
                "label" => $this->__("Check"),
                "title" => $this->__("Check")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function CheckAction() {

	$data = $this->getRequest()->getParam('pincode');
    // $data =$_REQUEST['pincode'];

	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_read');
	$query = "SELECT * FROM cod WHERE pincode= '".$data."' ORDER BY cod desc";


	$result=$read->query($query);
	$query = "SELECT * FROM ncod WHERE pincode= '".$data."' ORDER BY ncod desc";

	
		$result1=$read->query($query);
		$cod = $result->fetch();
		$ncod = $result1->fetch();

	  if($cod['cod']=='1' && $ncod['ncod']=='1')
	  {
		  if($cod['eastzone']=='E')
		  {
		  	Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('ncod');
			  echo "ncod";

		  }
	     else
		  { 
			Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('cod');
			echo 'cod';
				 
	      }
	  }
	  else
	  {
	  if($cod['cod']=='1' && $ncod['ncod']=='0')
		{
		  if($cod['eastzone']=='E' ||$ncod['eastzone']=='E')
		  {		 
			Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('ncod');
			echo 'ncod';
	
	       }
			else{
		    Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('ocod');
			echo 'ocod';
		}
		}
		elseif($cod['cod']=='0' && $ncod['ncod']=='1')
	   {
			Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('ncod');
	        echo 'ncod';
	 	   
	   }
	   elseif($cod['cod']=='0'||$ncod['ncod']=='1')
	   {
			if($cod['cod']=='0' && $ncod['ncod']=='1')
			{
			Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('ncod');
	        echo 'ncod';
			}
			else
			{
			  echo 'none';
			}
			
	   }
	   
	   elseif($cod['cod']=='1'||$ncod['ncod']=='0')
	   {
	   
			Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('ocod');
	        echo 'ocod';
	    }
	   else
	   {
	   echo "none";
	   }
	   
	   }
	   }
	   
	public function getAreaServiceAction() {	
		
		$layout = $this->loadLayout();
		$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','PPWD_Custom',
		array('template' => 'cms/policy.phtml'));
		echo $block->toHtml(); 
	}
	
	
	public function customerExistsAction()
{
	
	
	$email =Mage::app()->getRequest()->getParams();
	$websiteId = Mage::app()->getWebsite()->getId();
	
	$customer = Mage::getModel('customer/customer');
	if ($websiteId) {
		$customer->setWebsiteId($websiteId);
	}
	$customer->loadByEmail($email['email']);
	if ($customer->getId()) {
		echo "yes";
	}else{
		echo "no";
	}
}
	public function superpriceAction() {
	//	echo 'manoj';

		$productid =Mage::app()->getRequest()->getParams();
		//print_r($productid);

	 	$model = Mage::getModel('catalog/product'); 

	 	$_product = $model->load($productid['productid']); 

		$productModel = Mage::getModel('catalog/product');

		$attrcolor = $_product->getResource()->getAttribute("color");
		$attrsize = $_product->getResource()->getAttribute("size");
		$color_label = $attrcolor->getSource()->getOptionText($productid['color']);
		$size_label = $attrsize->getSource()->getOptionText($productid['size']);

		//echo $color_label.','.$size_label;

		$_attributes = $_product->getTypeInstance(true)->getConfigurableAttributes($_product); 
		$arrVal = array();

		$i = 0;
		foreach($_attributes as $attribute){
			$arrVal[]=$attribute->getPrices();

			$i++;
		}
		//print_r($arrVal);
		//print_r(strlen($arrVal[0][0]['label']));
		//print_r(strlen($arrVal[0][1]['label']));

		$colorcount=count($arrVal[1]);
		$sizecount=count($arrVal[0]);
		
		$finalArray = array();
		if($colorcount>$sizecount){

			$sizecount=count($arrVal[1]);
			$colorcount=count($arrVal[0]);

			for ($colorcounter=0; $colorcounter < $colorcount ; $colorcounter++) { 

			for ($sizecounter=0; $sizecounter < $sizecount ; $sizecounter++){
			//echo $arrVal[1][$colorcounter]['label'];
			$finalArray[$arrVal[0][$colorcounter]['label']][$arrVal[1][$sizecounter]['label']]=$arrVal[1][$sizecounter]['pricing_value']+$arrVal[0][$colorcounter]['pricing_value'];

			}


			}

		}
		else
		{
			for ($colorcounter=0; $colorcounter < $colorcount ; $colorcounter++) { 

				for ($sizecounter=0; $sizecounter < $sizecount ; $sizecounter++){
					//echo $arrVal[1][$colorcounter]['label'];
					$finalArray[$arrVal[1][$colorcounter]['label']][$arrVal[0][$sizecounter]['label']]=$arrVal[0][$sizecounter]['pricing_value']+$arrVal[1][$colorcounter]['pricing_value'];
			
				}


		}

		}
		
			//print_r($finalArray);
			//echo $color_label.''.$size_label;

			//echo $finalArray[$color_label][$size_label];
			//echo '$finalArray['.$color_label.']['.$size_label.']';
			if($finalArray[$color_label][$size_label]=='')
			{
				echo $finalArray[$size_label][$color_label];
			}
			else{
				echo $finalArray[$color_label][$size_label];
			}
	}

	
}