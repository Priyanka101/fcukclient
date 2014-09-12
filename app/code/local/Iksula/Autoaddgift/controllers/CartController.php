<?php require_once 'Mage/Checkout/controllers/CartController.php';

class Iksula_Autoaddgift_CartController extends Mage_Checkout_CartController{

	public function indexAction(){
		$quote = Mage::getSingleton('checkout/cart')->getQuote();
		$flag = true;
		$grandTotal = $quote->getGrandTotal();
		$subTotal =  $quote->getSubtotal();
		$product_model = Mage::getModel('catalog/product');
		$my_product_sku = Mage::getStoreConfig('configuration/configuration/product_sku');
    	$my_product_id  = $product_model->getIdBySku($my_product_sku);

    	$cartAmount = (int)Mage::getStoreConfig('configuration/configuration/cart_amount');

		if(intval($grandTotal) >= $cartAmount && $flag){
			$customPrice = 0;
			$my_product = $product_model->load($my_product_id);
			
			$stocklevel = (int)Mage::getModel('cataloginventory/stock_item')
                ->loadByProduct($my_product)->getQty();


			if(!$quote->hasProductId($my_product_id) && $stocklevel != 0)
			{
				//Add Product to cart
		   		 $cartHelper = Mage::helper('checkout/cart')->getCart();
		   		 $cartHelper->addProduct($my_product, array('qty' => 1));
		   		 $cartHelper->save();


	   		}else{
	  			//update product qty to 1
	 			$cartHelper = Mage::helper('checkout/cart');
				$items = $cartHelper->getCart()->getItems();

	   			foreach ($items as $item) {
	   				//print_r($item->getData('sku'));
				    if ($item->getData('sku') == $my_product_sku) {
				        $itemId = $item->getItemId();
				        $cartHelper->getCart()->updateItem($itemId,array('qty'=>'1'))->save();
				        break;
				    }
				}
				      // exit;
	   		}
   		}else{

   			//Remove product from cart
   			$cartHelper = Mage::helper('checkout/cart');
			$items = $cartHelper->getCart()->getItems();
			foreach ($items as $item) {
			    if ($item->getProduct()->getId() == $my_product_id) {
			        $itemId = $item->getItemId();
			        $cartHelper->getCart()->removeItem($itemId)->save();
			        break;
			    }
			}
   		}

		parent::indexAction();
		//echo $grandTotal;exit;

	}
}
