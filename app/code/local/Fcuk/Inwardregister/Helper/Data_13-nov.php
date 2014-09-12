<?php

class Fcuk_Inwardregister_Helper_Data extends Mage_Core_Helper_Abstract
{
	
public function _getConnection($type = 'core_read'){
    return Mage::getSingleton('core/resource')->getConnection($type);
}
 
public function _getTableName($tableName){
    return Mage::getSingleton('core/resource')->getTableName($tableName);
}
 
public function _getAttributeId($attribute_code = 'price'){
    $connection = $this->_getConnection('core_read');
    $sql = "SELECT attribute_id
                FROM " . $this->_getTableName('eav_attribute') . "
            WHERE
                entity_type_id = ?
                AND attribute_code = ?";
    $entity_type_id = $this->_getEntityTypeId();
    return $connection->fetchOne($sql, array($entity_type_id, $attribute_code));
}
 
public function _getEntityTypeId($entity_type_code = 'catalog_product'){
    $connection = $this->_getConnection('core_read');
    $sql        = "SELECT entity_type_id FROM " . $this->_getTableName('eav_entity_type') . " WHERE entity_type_code = ?";
    return $connection->fetchOne($sql, array($entity_type_code));
}
 
public function _checkIfSkuExists($sku){
	
    $connection = $this->_getConnection('core_read');
	$sql        = "SELECT COUNT(*) AS count_no FROM " . $this->_getTableName('catalog_product_entity') . " WHERE sku = ?";
    $count      = $connection->fetchOne($sql, array($sku));
	
    if($count > 0){
        return true;
    }else{
	
        return false;
	}
}
 
public function _getIdFromSku($sku){
    $connection = $this->_getConnection('core_read');
    $sql        = "SELECT entity_id FROM " . $this->_getTableName('catalog_product_entity') . " WHERE sku = ?";
    return $connection->fetchOne($sql, array($sku));
}
 
public function _updateStocks($data){
	
	
    $connection     = $this->_getConnection('core_write');
    $sku            = $data[0];
    $newQty         = $data[1];
    $productId      = $this->_getIdFromSku($sku);
    //$attributeId    = $this->_getAttributeId();
	 $sql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    $olddata = $connection->fetchOne($sql, array($productId));
	$newQty = $newQty + $olddata;
	
    $isInStock      = $newQty > 0 ? 1 : 0;
    $stockStatus    = $newQty > 0 ? 1 : 0;
	
		if($newQty > 0){
			$this->setEnable($productId, $newQty);
		}
   // $connection->query($sql, array($newQty, $isInStock, $newQty, $stockStatus, $productId));
}

public function _updateStocksedit($data , $inwardregister_id){
	
	
    $connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('inwardproduct') . " WHERE itemsku = '".$data[0]."' AND inwardregister_id = ".$inwardregister_id;
																						
    $olddata = $connection->fetchAll($sql);
	/*if(empty($olddata)){
		
		$this->_updateStocks($data);

	}else{*/

		$old_qty = $olddata[0]['qty'];
		$sku            = $data[0];
    	$newQty         = $data[1];
    	$productId      = $this->_getIdFromSku($sku);
		$sql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    	$olddata = $connection->fetchOne($sql, array($productId));
		/*$newQty = $newQty + $olddata;
		$newQty = $newQty - $old_qty;*/
		 
		$newQty			= $newQty > 0 ? $newQty : 0;
		$isInStock      = $newQty > 0 ? 1 : 0;
	    $stockStatus    = $newQty > 0 ? 1 : 0;
	
       
       if($newQty > 0 ){
   			$this->setEnable($productId, $newQty);
		}                    		
	/*}*/

}

public function setEnable($productId, $newQty){

		$parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($productId);
      
		$productStatus    = Mage::getModel('catalog/product');
		$parentProductStatus = Mage::getModel('catalog/product');
		// Load product using product id
 		$productStatus->load($productId);
		 		// get product's general info such price, status, description
		$productInfoData = $productStatus->getData();
		 //echo '<pre>';print_r($productInfoData);
		// update general info using new data
		//$productInfoData['status'] = 1;
		 $productStatus->setStatus(1);
		 
		// get product's stock data such quantity, in_stock etc
		$stockData = $productStatus->getStockItem()->getData();
		
		$stockData['qty'] = $newQty;
		$stockData['is_in_stock'] = 1;
		 
		// then set product's stock data to update
		$productStatus->setStockData($stockData);
		 
		// call save() method to save your product with updated data
		$productStatus->save();
		//echo '<pre>';print_r($productStatus->getData());exit;
		//for configurable  products
		$parentProductStatus->load($parentIds[0]);
		$productImages = $parentProductStatus->getMediaGalleryImages();
		$total_images = array();
		foreach ($productImages as $_image ){
			$imageUrl = $_image->getData('url');
			if(strpos($imageUrl,'.jpg')){
				array_push($total_images,$_image);
			}
		}
		//echo '<pre>';print_r($total_images);
		//var_dump(count($total_images));exit;
		if(count($total_images) > 0){
			//echo 123;
			$parentProductStatus->setStatus(1);
			 
			// get product's stock data such quantity, in_stock etc
			$stockData = $parentProductStatus->getStockItem()->getData();
			
			$stockData['qty'] = 0;
			$stockData['is_in_stock'] = 1;
			 
			// then set product's stock data to update
			$parentProductStatus->setStockData($stockData);
			 
			// call save() method to save your product with updated data
			$parentProductStatus->save();
		}else{
			//echo 'i am here';exit;
			$parentProductStatus->setStatus(2);
			 
			// get product's stock data such quantity, in_stock etc
			$stockData = $parentProductStatus->getStockItem()->getData();
			
			$stockData['qty'] = 0;
			$stockData['is_in_stock'] = 0;
			 
			// then set product's stock data to update
			$parentProductStatus->setStockData($stockData);
			 
			// call save() method to save your product with updated data

			$parentProductStatus->save();
			//echo '<pre>';print_r($parentProductStatus->getData());exit;
		}

}

public function _checkUpdatestock($datacollection , $inwardregister_id){
	
	if(empty($datacollection)){
		return false;
	}
	
	$connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('inwardproduct') . " WHERE  inwardregister_id = ".$inwardregister_id;
	//echo $sql;exit;																		
    $olddata = $connection->fetchAll($sql);
    //echo '<pre>';print_r($olddata);exit;
	for($i=0;$i<count($olddata);$i++){
		for($j=0;$j<count($datacollection);$j++){
			
			if($olddata[$i]['itemsku'] == $datacollection[$j][0]){
				
				if($this->_checkIfSkuExists($olddata[$i]['itemsku'])){
			
			$productId      = $this->_getIdFromSku($olddata[$i]['itemsku']);
			$productqtysql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    		$productqty = $connection->fetchOne($productqtysql, array($productId));
			
			$productqty = $productqty + $datacollection[$j][1];
			$productqty = $productqty - $olddata[$i]['qty'];
			
			if($productqty < 0){
				return false;
			}
				}else{
				return false;
			}
				
			}
			
		}
	}
	
	return true;
}

public function _checkAddstocknew($datacollection){
$connection     = $this->_getConnection('core_write');

for($j=0;$j<count($datacollection);$j++){
			
			
				
				if($this->_checkIfSkuExists($datacollection[$j][0])){
			
					
			
			if($datacollection[$j][1] < 0){
				return false;
			}
				}else{
				return false;
			}
				
		
			
		}

return true;

}




/***************** UTILITY FUNCTIONS ********************/

public function _addData($data){
	$connection     = $this->_getConnection('core_write');
	
	
	
	 $sql        = "SELECT * FROM " . $this->_getTableName('inwardregister') . " WHERE sku = ?
	 																					AND supplier_id = ?";
    $olddata = $connection->fetchOne($sql, array($data[0],$data[3]));
	
	$model = Mage::getModel('inwardregister/inwardregister');
	$data_inward['sku'] = $data[0];
	$data_inward['qty'] = $data[1];
	$data_inward['status'] = 1;
	$data_inward['stock_move_to_live'] = $data[2];
	$data_inward['stock_remain_not_move_to_live'] = $data[1] - $data[2];
	$data_inward['supplier_id'] = $data[3];
	$data_inward['comment'] = $data[4];
		if($olddata){
			
	$oldModel = 	Mage::getModel('inwardregister/inwardregister')->load($olddata);
	
		$data_inward['qty'] = $data_inward['qty'] + $oldModel->getData('qty');
		$data_inward['stock_move_to_live'] = $data_inward['stock_move_to_live'] + $oldModel->getData('stock_move_to_live');
		$data_inward['stock_remain_not_move_to_live'] = $data_inward['stock_remain_not_move_to_live'] + $oldModel->getData('stock_remain_not_move_to_live');
		$newModel = Mage::getModel('inwardregister/inwardregister');
			$newModel->setData($data_inward);
			$newModel->setUpdateTime(now());
			$newModel ->setInwardregisterId($oldModel->getData('inwardregister_id'));
			$newModel->save();
			
			
		}else{
			
			$model->setData($data_inward);
			$model->setCreatedTime(now())->setUpdateTime(now());
			$model->save();
		}
	
	
	}
	
public function _addDataProduct($data , $inwardregister_id){
	$new_data['inwardregister_id'] = $inwardregister_id;
	$new_data['itemsku'] = $data[0];
	$new_data['itemdescription'] =$data[3];
	$new_data['qty'] = $data[1];
	$new_data['price'] = $data[2];
	$new_data['total'] =$new_data['qty'] * $new_data['price'];
	$model_inwardproduct = Mage::getModel('inwardproduct/inwardproduct');
	$model_inwardproduct->setData($new_data);
	$model_inwardproduct->save();}

public function _addDataProductedit($data , $inwardregister_id){
	
	
    $connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('inwardproduct') . " WHERE itemsku = '".$data[0]."' AND inwardregister_id = ".$inwardregister_id;
																						
    $olddata = $connection->fetchAll($sql);
	if(empty($olddata)){
		
		$this->_addDataProduct($data ,$inwardregister_id );
		
	}else{
		$new_data['inwardproduct_id'] = $olddata[0]['inwardproduct_id'];
		$new_data['inwardregister_id'] = $inwardregister_id;
		$new_data['itemsku'] = $data[0];
		$new_data['itemdescription'] = $data[3];
		$new_data['qty'] = $data[1];
		$new_data['price'] = $data[2];
		$new_data['total'] =$new_data['qty'] * $new_data['price'];
		$model_inwardproduct = Mage::getModel('inwardproduct/inwardproduct')->load($olddata[0]['inwardproduct_id']);
		$model_inwardproduct->setData($new_data);
		$model_inwardproduct->save();
		
	}
	
	}

	
	
public function _updatePrice($data){
	
	$sku            = $data[0];
    $newPrice       = $data[2];

	$productId      = $this->_getIdFromSku($sku);
		
	$catalog_product_entity_decimal_query = "update  ". $this->_getTableName('catalog_product_entity_decimal') ." set value = ".$newPrice ." where attribute_id = 75 and entity_id = ".$productId ;
	$write = Mage::getSingleton('core/resource')->getConnection('core_write');
	$read = Mage::getSingleton('core/resource')->getConnection('core_read');			
	$write->query($catalog_product_entity_decimal_query);
	
	}	
	
public function checkDelete($id){
	
	
	
	 $connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('inwardproduct') . " WHERE  inwardregister_id = ".$id;
																						
    $olddata = $connection->fetchAll($sql);
	for($i=0;$i<count($olddata);$i++)
	{
		if($this->_checkIfSkuExists($olddata[$i]['itemsku'])){
			
			$productId      = $this->_getIdFromSku($olddata[$i]['itemsku']);
			$productqtysql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    		$productqty = $connection->fetchOne($productqtysql, array($productId));
			
			
			if($olddata[$i]['qty'] > $productqty ){
				return false;
			}
			
			
		
			}else{
				return false;
			}
		
	}
	
	
	return true;
	
}
public function deleteInward($id){
	$connection     = $this->_getConnection('core_write');
	$sql        = "SELECT * FROM " . $this->_getTableName('inwardproduct') . " WHERE  inwardregister_id = ".$id;
																						
    $olddata = $connection->fetchAll($sql);
	for($i=0;$i<count($olddata);$i++)
	{
			$productId      = $this->_getIdFromSku($olddata[$i]['itemsku']);
			$productqtysql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    		$productqty = $connection->fetchOne($productqtysql, array($productId));
			
			$newQty = $productqty - $olddata[$i]['qty'];
			
			$newQty			= $newQty > 0 ? $newQty : 0;
			$isInStock      = $newQty > 0 ? 1 : 0;
    		$stockStatus    = $newQty > 0 ? 1 : 0;
	
		$sql            = "UPDATE " . $this->_getTableName('cataloginventory_stock_item') . " SET
                       qty = ".$newQty.",
                       is_in_stock = ".$isInStock."
                       WHERE
                       product_id = ".$productId;
					   
	
		$sql2            = "UPDATE " . $this->_getTableName('cataloginventory_stock_status') . " SET
                       qty = ".$newQty.",
                       stock_status = ".$stockStatus."
                       WHERE
                       product_id = ".$productId;
    $connection->query($sql);
	$connection->query($sql2);
	$connection->query("delete from inwardproduct where inwardproduct_id = ".$olddata[$i]['inwardproduct_id']);
	
		
	}
	
	}
	
		

public function _massmovetoLive($data , $inwardregister_id , $oldstockmovetolive){
			$newModel = Mage::getModel('inwardregister/inwardregister');
			$stock_move_to_live = $oldstockmovetolive + $data[1];
			$movelive['stock_move_to_live'] = $stock_move_to_live;
    		$movelive['stock_remain_not_move_to_live'] = 0;
			$newModel->setData($movelive);
			$newModel->setUpdateTime(now());
			$newModel ->setInwardregisterId($inwardregister_id);
			$newModel->save();
	
}

	

}