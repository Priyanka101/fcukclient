<?php
class Addons_Storelocator_IndexController extends Mage_Core_Controller_Front_Action
{	  
	public function indexAction(){
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle('Find a Store');
        $this->renderLayout();
	}
	
	public function getSession(){
		return Mage::getSingleton('core/session');
	}
	public function storeAction(){
		$requestVar = $this->getRequest()->getParam('search');
		$store = Mage::getModel("storelocator/storelocator")->searchBy($requestVar);
		if(isset($_SESSION['store'])){
			unset($_SESSION['store']);
		}
		$_SESSION['store'] = $store;
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle('Find a Store');
        $this->renderLayout();
    }
	public function shipAction(){
		$requestVar = $this->getRequest()->getParam('search');
		$store = Mage::getModel("storelocator/storelocator")->searchBy($requestVar);
		if(isset($_SESSION['store'])){
			unset($_SESSION['store']);
		}
		$_SESSION['store'] = $store;
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle('Find a Store');
        $this->renderLayout();
    }
	
	public function shiptostoreAction(){
		$session = $this->getSession();
		if(isset($_SESSION['isShipToStore'])){
			unset($_SESSION['isShipToStore']);
		}
		$requestVar = $this->getRequest()->getParam('isship');
		//echo $requestVar; exit;
		
		if($requestVar=='1'){
			unset($_SESSION['isShipToStore']);
			$_SESSION['isShipToStore'] = 1;
		}else{
			unset($_SESSION['isShipToStore']);
			$_SESSION['isShipToStore'] = 0;
			
		}
		echo $_SESSION['isShipToStore'];
		
		
	}
}
	
	
	
