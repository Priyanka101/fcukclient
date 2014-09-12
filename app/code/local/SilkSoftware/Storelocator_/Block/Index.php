<?php   
class SilkSoftware_Storelocator_Block_Index extends Mage_Core_Block_Template{   

	private $stores = array();
	private function storeArray()
	{
		$stores = Mage::getSingleton('storelocator/storelocator')->getCollection()->getData();
		return $stores;
	}
 	public function getAllCities()
	{
		
		$storeArray  = $this->storeArray();
		$storecities = array();
		$prev_city = "";
		foreach($storeArray as $city)
		{							
			array_push($storecities,$city['city']);			
		}
		sort($storecities);
		$storecities = array_map('strtolower', $storecities);
		$cities = array_unique($storecities);
		//echo '<pre>';print_r($cities);exit;
		//return json_encode($cities);
		$cities = array_map(function($word){ return ucwords($word); }, $cities);
		return $cities;
	} 
	public function getAllStates()
	{
		$storeArray  = $this->storeArray();
		$storestates = array();
		$prev_city = "";
		foreach($storeArray as $city)
		{							
			array_push($storestates,$city['state']);			
		}
		sort($storestates);
		$storestates = array_map('strtolower', $storestates);
		$states = array_unique($storestates);
		$states = array_map(function($word){ return ucwords($word); }, $states);
		
		//echo '<pre>';print_r($states);exit;
		return $states;
	} 
	



}