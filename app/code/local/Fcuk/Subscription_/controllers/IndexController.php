<?php
class Fcuk_Subscription_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
	  
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Subscription"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("subscription", array(
                "label" => $this->__("Subscription"),
                "title" => $this->__("Subscription")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public function StoreAction() {
	
	$email = $this->getRequest()->getPost('email');
	$mobileno = $this->getRequest()->getPost('mobileno');
   
	 $resource = Mage::getSingleton('core/resource');
	 $read = $resource->getConnection('core_write');
	 $query = "INSERT into subscription(email,mobileno) values('$email','$mobileno')";
     $result=$read->query($query);
	 echo "Thank you for subscription";
	 //return "Thank you for subscription";
	 
	}
	
}