<?php
class Fcuk_Outwardregister_Helper_Data extends Mage_Core_Helper_Abstract
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
		$newQty =  $olddata - $newQty ;
		if($newQty < 0){
			$newQty = 0;
			}
		
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
		
		//$connection->query($sql, array($newQty, $isInStock, $newQty, $stockStatus, $productId));
	}
	
	public function _updateStocksedit($data , $outwardregister_id){
	
	
    $connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('outwardproduct') . " WHERE itemsku = '".$data[0]."' AND outwardregister_id = ".$outwardregister_id;
																						
    $olddata = $connection->fetchAll($sql);
	if(empty($olddata)){
		
		$this->_updateStocks($data);
		
	}else{
		
		$old_qty = $olddata[0]['qty'];
		$sku            = $data[0];
    	$newQty         = $data[1];
    	$productId      = $this->_getIdFromSku($sku);
		$sql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    	$olddata = $connection->fetchOne($sql, array($productId));
		
		$olddata = $olddata + $old_qty; 
		$newQty = $olddata - $newQty;
		 
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

		
	}
	
    //$attributeId    = $this->_getAttributeId();
 	
   
}
	public function _checkUpdatestock($datacollection , $outwardregister_id){
		
	if(empty($datacollection)){
		return false;
	}
	$connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('outwardproduct') . " WHERE  outwardregister_id = ".$outwardregister_id;
	$olddata = $connection->fetchAll($sql);
	
	
	
	
	if(empty($olddata)){
		
		for($j=0;$j<count($datacollection);$j++){
			
			if($this->_checkIfSkuExists($datacollection[$j][0])){
			
			$productId      = $this->_getIdFromSku($datacollection[$j][0]);
			$productqtysql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    		$productqty = $connection->fetchOne($productqtysql, array($productId));
			$productqty = $productqty - $datacollection[$j][1] ;
			
			if($productqty < 0){
				return false;
			}
				}else{
				return false;
			}
			
			
			}
		
		}else{
			for($j=0;$j<count($datacollection);$j++){
				if($this->_checkIfSkuExists($datacollection[$j][0])){
					
					
					$entry = "no";
					$qty = 0;
					for($i=0;$i<count($olddata);$i++){
						if($datacollection[$j][0]==$olddata[$i]['itemsku']){
							$entry ="yes";
							$qty = $olddata[$i]['qty'];
						}
					}
					
					
					if($entry=="yes"){
						
						$productId      = $this->_getIdFromSku($datacollection[$j][0]);
						$productqtysql  = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    					$productqty = $connection->fetchOne($productqtysql, array($productId));
						$productqty = $productqty + $qty;
						
						
						
						$productqty = $productqty - $datacollection[$j][1] ;

							if($productqty < 0)
								{
									
									return false;
								}
							
					}else{
						
						$productId      = $this->_getIdFromSku($datacollection[$j][0]);
						$productqtysql  = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    					$productqty = $connection->fetchOne($productqtysql, array($productId));
						$productqty = $productqty - $datacollection[$j][1] ;
							if($productqty < 0)
								{
									return false;
								}
						
						
					}
					
					
				}else{
				return false;
			}
				}
			
			
			}
	
	
	return true;
}

public function _checkUpdatestocknew($dataCollection){
	if(empty($dataCollection)){
		return false;
	}
	$connection     = $this->_getConnection('core_write');
	for($j=0;$j<count($dataCollection);$j++){
	if($this->_checkIfSkuExists($dataCollection[$j][0])){
		
		
		
		$productId  = $this->_getIdFromSku($dataCollection[$j][0]);
		$productqtysql  = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    	$productqty = $connection->fetchOne($productqtysql, array($productId));
		$productqty = $productqty - $dataCollection[$j][1] ;
		if($productqty < 0)
			{
				return false;
			}
		
		}
		else{
			return false;
		}
	}
	return true;
}
	
	/***************** UTILITY FUNCTIONS ********************/
	
	public function _addDataProduct($data , $outwardregister_id){
		
	$new_data['outwardregister_id'] = $outwardregister_id;
	$new_data['itemsku'] = $data[0];
	$new_data['itemdescription'] = $data[3];
	$new_data['qty'] = $data[1];
	$new_data['price'] = $data[2];
	$new_data['total'] =$new_data['qty'] * $new_data['price'];
	
	$model_outwardproduct = Mage::getModel('outwardproduct/outwardproduct');
	$model_outwardproduct->setData($new_data);
	$model_outwardproduct->save();
	
	
	}
	
	public function _addDataProductedit($data , $outwardregister_id){
	
	
    $connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('outwardproduct') . " WHERE itemsku = '".$data[0]."' AND outwardregister_id = ".$outwardregister_id;
																						
    $olddata = $connection->fetchAll($sql);
	if(empty($olddata)){
		
		$this->_addDataProduct($data ,$outwardregister_id);
		
	}else{
		$new_data['outwardproduct_id'] = $olddata[0]['outwardproduct_id'];
		$new_data['outwardregister_id'] = $outwardregister_id;
		$new_data['itemsku'] = $data[0];
		$new_data['itemdescription'] = $data[3];
		$new_data['qty'] = $data[1];
		$new_data['price'] = $data[2];
		$new_data['total'] =$new_data['qty'] * $new_data['price'];
		$model_outwardproduct = Mage::getModel('outwardproduct/outwardproduct')->load($olddata[0]['outwardproduct_id']);
		$model_outwardproduct->setData($new_data);
		$model_outwardproduct->save();
	}
	
	}
	
	public function checkDelete($id){
	 $connection     = $this->_getConnection('core_write');
	 $sql        = "SELECT * FROM " . $this->_getTableName('outwardproduct') . " WHERE  outwardregister_id = ".$id;
																						
    $olddata = $connection->fetchAll($sql);
	for($i=0;$i<count($olddata);$i++)
	{
		if($this->_checkIfSkuExists($olddata[$i]['itemsku'])){
			/*
			$productId      = $this->_getIdFromSku($olddata[$i]['itemsku']);
			$productqtysql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    		$productqty = $connection->fetchOne($productqtysql, array($productId));
			
			
			if($olddata[$i]['qty'] > $productqty ){
				return false;
			}
			
			*/
		
			}else{
				return false;
			}
		
	}
	
	
	return true;
	
}
public function deleteOutward($id){
	$connection     = $this->_getConnection('core_write');
	$sql        = "SELECT * FROM " . $this->_getTableName('outwardproduct') . " WHERE  outwardregister_id = ".$id;
	$olddata = $connection->fetchAll($sql);
	for($i=0;$i<count($olddata);$i++)
	{
			$productId      = $this->_getIdFromSku($olddata[$i]['itemsku']);
			$productqtysql        = "SELECT qty FROM " . $this->_getTableName('cataloginventory_stock_item') . " WHERE product_id = ?";
    		$productqty = $connection->fetchOne($productqtysql, array($productId));
			
			$newQty = $productqty + $olddata[$i]['qty'];
			
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
	$connection->query("delete from outwardproduct where outwardproduct_id = ".$olddata[$i]['outwardproduct_id']);
	
		
	}
	
	}
		

	

}