<?php

class Fcuk_Subscription_Model_Observer
{
    public function refund(Varien_Event_Observer $observer) {
     
       // echo 'gggggg';
       // exit;
     }

     
	 public function orderpricevalue(Varien_Event_Observer $observer){
    // echo 'testing';
    // exit;
    // $event = $observer->getEvent();
    // $order = $event->getOrder(); 
    // for($orderno=1;$orderno<=1181;$orderno++){
    //  $order = Mage::getModel('sales/order')->load($orderno);
    //  foreach($order->getAllItems() as $item){
    //   $order_price = $item->getData('price_incl_tax');
    //   $_product = Mage::getModel('catalog/product')->load($item->getData('product_id'));
    //   $original_price = $_product->getData('price');
    //   if($_product->getTypeId() == 'simple'){
    //     $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($item->getData('product_id')); 
    //     $conf_product = Mage::getModel('catalog/product')->load($parentIds[0]); 
    //     $special_price = $conf_product->getData('special_price');
    //   }else{
    //     $special_price = $_product->getData('special_price');
    //   }
    //   $item->setData('custom_price',$order_price);
    //   $item->setData('custom_original_price',$original_price);
    //     //$item->setData('custom_special_price',$special_price);
    //   $item->setData('custom_special_price',$order_price);
    //   $item->save();
    // } 
  }
         
      
    }
		
}
