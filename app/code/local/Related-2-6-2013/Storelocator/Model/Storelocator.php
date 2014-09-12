<?php
class Addons_Storelocator_Model_Storelocator extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('storelocator/storelocator');
    }
	public function searchBy($searchParam){

		$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		$store=array();
		$storeId = (int) Mage::app()->getStore()->getStoreId();
		if($storeId == 1){
		  $gender="1";
		}
		else{ 
		  $gender="0";
		}	
		$brandQuery = "SELECT * FROM store_location WHERE city like '$searchParam%' AND Gender like '$gender' ";
		$resultSet = $connection->fetchAll($brandQuery);
		if(count($resultSet) > 0){
		 foreach($resultSet as $record){					
		   $store[] = $record['id'];
		 }
		}
		$storeArray = array_unique($store);
		return $storeArray;
	}
}