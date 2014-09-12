<?php
class Fcuk_Pressreleases_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("pressreleases"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("pressreleases", array(
                "label" => $this->__("pressreleases"),
                "title" => $this->__("pressreleases")
		   ));

      $this->renderLayout(); 
	  
    }
	public function pressreleaseAction()
	{	
		$name = $this->getRequest()->getParam('release');
		//echo $name;exit;
		 $this->loadlayout();
		$this->getLayout()->getBlock("head")->setTitle($this->__("pressreleases"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
		  $breadcrumbs->addCrumb("home", array(
					"label" => $this->__("Home Page"),
					"title" => $this->__("Home Page"),
					"link"  => Mage::getBaseUrl()
			   ));

		  $breadcrumbs->addCrumb("pressreleases", array(
					"label" => $this->__("pressrelease"),
					"title" => $this->__("pressrelease")
			   ));
		$this->renderLayout(); 
		 //echo 123456;exit;
	}
}