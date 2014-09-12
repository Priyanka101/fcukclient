<?php
class Addons_Storelocator_Block_Storelocator extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        
    	parent::_construct();
    }
 
    protected function getAllCity()
	{
		$storeId = (int) Mage::app()->getStore()->getStoreId();
		if($storeId == 1){
			$gender="1";
		}
		else{ 
			$gender="0";
		}	
       $cityModel = Mage::getModel("storelocator/storelocator")
	    				->getCollection()
						->addFieldToFilter('gender',$gender)
	    				->addFieldToSelect('city')->setOrder('city','ASC');
						
				
		return $cityModel;
    }
    protected function getStoreByCity($city)
	{
       	$storeModel = Mage::getModel("storelocator/storelocator")
       				  ->getCollection()
       				  ->addFieldToFilter('id',$city);
       	return $storeModel;	
       
       
    }
    protected function getStoreData($id)
	{
       	$storeModel = Mage::getModel("storelocator/storelocator")
       				  ->getCollection()
       				  ->addFieldToFilter('id',$id);
       	return $storeModel;	
       
       
    }
}