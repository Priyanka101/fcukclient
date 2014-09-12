<?php
class Fcuk_Shiptrack_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Shiptrack"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("shiptrack", array(
                "label" => $this->__("Shiptrack"),
                "title" => $this->__("Shiptrack")
		   ));

      $this->renderLayout(); 
	  
    }
}