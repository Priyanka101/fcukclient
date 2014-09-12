<?php
class Mac_Landingpage_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
    
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Home"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home"),
                "title" => $this->__("Home")
		   ));

      $this->renderLayout(); 
	  
    }
	  public function viewAction() {
    
	  $this->loadLayout();   
	  $this->renderLayout(); 
	  
    }
}