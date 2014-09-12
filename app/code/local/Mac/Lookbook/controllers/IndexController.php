<?php
class Mac_Lookbook_IndexController extends Mage_Core_Controller_Front_Action{
	public function IndexAction() {

		$this->loadLayout();   
		$this->getLayout()->getBlock("head")->setTitle($this->__("Lookbook"));
		$breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
		$breadcrumbs->addCrumb("home", array(
			"label" => $this->__("Home Page"),
			"title" => $this->__("Home Page"),
			"link"  => Mage::getBaseUrl()
			));

		$breadcrumbs->addCrumb("lookbook", array(
			"label" => $this->__("Lookbook"),
			"title" => $this->__("Lookbook")
			));

		$this->renderLayout(); 

	}
	public function viewAction() {

		$this->loadLayout();   
		$this->renderLayout(); 

	}	 
	
	public function shopbylookAction() {
		$idval=$this->getRequest()->getParams(); 
		$value=explode(',',$idval['email']);
		
		
		$productModel = Mage::getModel('catalog/product');
		$attr = $productModel->getResource()->getAttribute("size");
		$slabel = $attr->getSource()->getOptionText($value[0]);	

		$attr = $productModel->getResource()->getAttribute("color");
		$clabel = $attr->getSource()->getOptionText($value[1]);
		$eavAttribute = new Mage_Eav_Model_Mysql4_Entity_Attribute();
		$ccode = $eavAttribute->getIdByCode('catalog_product', 'color');
		$scode = $eavAttribute->getIdByCode('catalog_product', 'size');
		
		echo $checkouturl=Mage::getUrl('checkout/cart/').'add?product='.$value[2].'&super_attribute['.$scode.']='.$value[0].'&super_attribute['.$ccode.']='.$value[1].'&qty='.$value[3];

  	 /*  $this->loadLayout();   
  	 $this->renderLayout();  */


  	}

  	public function sizeguideAction() {

  		$this->loadLayout();   
  		$this->renderLayout(); 

  	}	 

  }