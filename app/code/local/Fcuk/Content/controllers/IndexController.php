<?php
class Fcuk_Content_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Content"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
     //  $breadcrumbs->addCrumb("home", array(
     //            "label" => $this->__("Home Page"),
     //            "title" => $this->__("Home Page"),
     //            "link"  => Mage::getBaseUrl()
		   // ));

     //  $breadcrumbs->addCrumb("content", array(
     //            "label" => $this->__("Content"),
     //            "title" => $this->__("Content")
		   // ));

      $this->renderLayout(); 
	  
    }
}