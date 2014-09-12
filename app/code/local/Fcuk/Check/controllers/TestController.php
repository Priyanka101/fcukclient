<?php

class Fcuk_Check_TestController extends Mage_Core_Controller_Front_Action{
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

	//echo "hello i m here";
	//echo '<pre>';
	//$data = $this->getRequest()->getParam('pincode');
	
    $data =753459;
    //echo $data;
	$resource = Mage::getSingleton('core/resource');
	$read = $resource->getConnection('core_read');
	$query = "SELECT * FROM cod_table WHERE pincode= '".$data."'";

echo $query;
	$result=$read->query($query);
	
	$query = "SELECT * FROM ncod_table WHERE pincode= '".$data."'";

	
		$result1=$read->query($query);
		$cod = $result->fetch();
		$ncod = $result1->fetch();

		print_r($cod['qcod']);
		print_r($ncod['qcod']);

	  if($cod['qcod']=='0' && $cod['bcod']=='0')
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
			Mage::getSingleton('core/session')->unsPayment();
			Mage::getSingleton('core/session')->setPayment('ncod');
	        echo 'ncod';
			
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
	
}