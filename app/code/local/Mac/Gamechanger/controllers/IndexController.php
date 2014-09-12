<?php
class Mac_Gamechanger_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Game Changer"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("game changer", array(
                "label" => $this->__("Game Changer"),
                "title" => $this->__("Game Changer")
		   ));

      $this->renderLayout(); 
	  
    }
	public function DeleteshippingAction()
    {
	   $addressId = $this->getRequest()->getParam('id', false);
	   //$addressId = 5;
		//  echo $addressId;
	   $resource=Mage::getSingleton('core/resource');;
	   $connection = $resource->getConnection('core_read');
	   $connection = $resource->getConnection('core_write');
	  
	/* $sql = "DELETE FROM `customer_address_entity_varchar`
                       WHERE `entity_id` = ".$addressId;
					   
	echo $sql;
	$connection->query($sql); */
/* 	$sql2   = "DELETE FROM `customer_address_entity_text` WHERE `entity_id`=".$addressId;
					   echo $sql2; */ 
   // $connection->query($sql);
	//$connection->query($sql2);
      /*  $this->loadLayout();
       $this->getLayout()->getBlock('head')->setTitle($this->__('Account Information'));
	   $this->getLayout()->getBlock('messages')->setEscapeMessageFlag(true);
       $this->renderLayout(); */
    }
}