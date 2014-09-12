<?php
class Iksula_Hsbcbincheck_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {

	  $this->loadLayout();
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Titlename"),
                "title" => $this->__("Titlename")
		   ));

      $this->renderLayout();

    }

    public function CheckdebitbinAction(){
      $debit_pin = $this->getRequest()->getParam('bin_number');
      $arr= Mage::getModel("hsbcbincheck/debitbinnumbers")->getCollection()->addFieldToFilter('debit_bins',$debit_pin)->getData();
      if(count($arr) > 0){
        Mage::getSingleton('checkout/cart')
        ->getQuote()
        ->setCouponCode('hsbc5%off')
        ->collectTotals()
        ->save();
        $response['msg'] = "success";
      }
      else{
        $response['msg'] = "failed";
      }
      $response['data'] = $this->getLayout()->createBlock('checkout/cart_totals')->setTemplate('checkout/cart/totals.phtml')->toHtml();
      return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

    }

    public function loadccformAction(){
      $layout = $this->loadLayout();
      //print_r($block = $this->getLayout()->createBlock('fcuk_requestproduct/requestproduct')->setTemplate('requestproduct/requestproduct.phtml')->toHtml());
      /*$block = $this->getLayout()->createBlock('Mage_Core_Block_Template','PPWD_Custom',array('template' => 'hsbcbincheck/bincheck.phtml'));
      echo $block->toHtml();*/
      $this->renderLayout();

    }
    public function loaddcformAction(){
      $layout = $this->loadLayout();
      $this->renderLayout();

    }
    public function CheckcreditbinAction(){
      $credit_pin = $this->getRequest()->getParam('bin_number');
      $arr= Mage::getModel("hsbcbincheck/creditbinnumbers")->getCollection()->addFieldToFilter('credit_bins',$credit_pin)->getData();
      if(count($arr) > 0){
        Mage::getSingleton('checkout/cart')
        ->getQuote()
        ->setCouponCode('hsbc5%off')
        ->collectTotals()
        ->save();
        $response['msg'] = "success";
      }
      else{
        $response['msg'] = "failed";
      }
      $response['data'] = $this->getLayout()->createBlock('checkout/cart_totals')->setTemplate('checkout/cart/totals.phtml')->toHtml();
      return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }

    public function removeCouponAction(){
     
      Mage::getSingleton('checkout/cart')
        ->getQuote()
        ->setCouponCode('')
        ->collectTotals()
        ->save();
      $response['msg'] = "success";
      $response['data'] = $this->getLayout()->createBlock('checkout/cart_totals')->setTemplate('checkout/cart/totals.phtml')->toHtml();
      return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}
