<?php

class Iksula_Customorder_Model_Observer
{
    public function refund(Varien_Event_Observer $observer) {
     
      
     }

    public function customattributeset(Varien_Event_Observer $observer){
          $event = $observer->getEvent();
          $order = $event->getOrder(); 
         // $order = Mage::getModel('sales/order')->load('1185');
      foreach($order->getAllItems() as $item){
        $order_price = $item->getData('price_incl_tax');
        $_product = Mage::getModel('catalog/product')->load($item->getData('product_id'));
        $original_price = $_product->getData('price');
        if($_product->getTypeId() == 'simple'){
          $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable') ->getParentIdsByChild($item->getData('product_id')); 
          $conf_product = Mage::getModel('catalog/product')->load($parentIds[0]); 
          $special_price = $conf_product->getData('special_price');
        }else{
          $special_price = $_product->getData('special_price');
        }
        $item->setData('custom_price',$order_price);
        $item->setData('custom_original_price',$original_price);
        $item->setData('custom_special_price',$special_price);
        $item->save();
      }   
    }

    public function refundCustomOrderInventory($observer)
    {
		$creditmemo = $observer->getEvent()->getCreditmemo();
        $items = array();
        foreach ($creditmemo->getAllItems() as $item) {
            /* @var $item Mage_Sales_Model_Order_Creditmemo_Item */
            $return = false;
            if ($item->hasBackToStock()) {
                if ($item->getBackToStock() && $item->getQty()) {
                    $return = true;
                }
            } elseif (Mage::helper('cataloginventory')->isAutoReturnEnabled()) {
                $return = true;
            }
            if ($return) {
                $parentOrderId = $item->getOrderItem()->getParentItemId();
                /* @var $parentItem Mage_Sales_Model_Order_Creditmemo_Item */
                $parentItem = $parentOrderId ? $creditmemo->getItemByOrderId($parentOrderId) : false;
                $qty = $parentItem ? ($parentItem->getQty() * $item->getQty()) : $item->getQty();
                if (isset($items[$item->getProductId()])) {
                    $items[$item->getProductId()]['qty'] += $qty;
                } else {
                    $items[$item->getProductId()] = array(
                        'qty' => $qty,
                        'item'=> null,
                    );
                }
            }
        }
        Mage::getSingleton('cataloginventory/stock')->revertProductsSale($items);
		

        /* Added By Shaily For IsinStock Status Starts */
        foreach ($creditmemo->getAllItems() as $item) {
			$productId = $item->getProductId();
			$product = Mage::getModel('catalog/product')->load($productId);

			if(!$product->isConfigurable()){

				$stockItem = $product->getStockItem();

				//$stockItem->setQty($item->getQty());
				$stockItem->setIsInStock(1);
				$stockItem->save();

				$product->setStockItem($stockItem);
				$product->save();
			}
		}

    }
     
	 public function orderpricevalue(Varien_Event_Observer $observer){
          $event = $observer->getEvent();
          $order = $event->getOrder(); 
          $order = Mage::getModel('sales/order')->load('262');
          print_r($order->getData());
          exit;
      foreach($order->getAllItems() as $item){
        $order_price = $item->getData('price_incl_tax');
        $_product = Mage::getModel('catalog/product')->load($item->getData('product_id'));
        $original_price = $_product->getData('price');
        if($_product->getTypeId() == 'simple'){
          $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable') ->getParentIdsByChild($item->getData('product_id')); 
          $conf_product = Mage::getModel('catalog/product')->load($parentIds[0]); 
          $special_price = $conf_product->getData('special_price');
        }else{
          $special_price = $_product->getData('special_price');
        }
        $item->setData('custom_price',$order_price);
        $item->setData('custom_original_price',$original_price);
        //$item->setData('custom_special_price',$special_price);
        $item->setData('custom_special_price',$order_price);
        $item->save();
      }   
    }
		
//	}		
}
