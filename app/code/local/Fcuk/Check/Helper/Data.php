<?php
class Fcuk_Check_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function _getConnection($type = 'core_read'){
		return Mage::getSingleton('core/resource')->getConnection($type);
	}
	 
	public function _getTableName($tableName){
		return Mage::getSingleton('core/resource')->getTableName($tableName);
	}
	public function _addDataProduct($data){
				
//	$new_data['cod_id'] = $cod_id;
	/* $new_data['pincode'] = $data[0];
	$new_data['city'] = $data[1];
	$new_data['location'] = $data[2];
	$new_data['state'] = $data[3];
	$new_data['cod'] = $data[4];
	$new_data['zone'] = $data[5];
	$new_data['eastzone'] =$data[6];
	$model_product = Mage::getModel("check/cod");
	$model_product->setData($new_data);
	$model_product->save(); */
	echo "jgjkgbkgbgbbb";
	exit;
	
	
	}	

}
	 