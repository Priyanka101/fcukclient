<?php
class SilkSoftware_Storelocator_Block_Index extends Mage_Core_Block_Template{

	private $stores = array();
	private function storeArray()
	{
		$stores = Mage::getSingleton('storelocator/storelocator')->getCollection()->addOrder("country_name","ASC")->getData();
		return $stores;
	}
	public function getAllCountries(){
		$storeArray1  = Mage::getSingleton('storelocator/storelocator')->getCollection()->addFieldToSelect('country_name')->distinct(true)->addOrder("country_name","ASC")->getData();
		$countries = array();
		foreach ($storeArray1 as $single_country) {
			array_push($countries, $single_country['country_name']);
		}
		return $countries;
	}
	public function getOpeningSoonStores(){
		$stores = Mage::getSingleton('storelocator/storelocator')->getCollection()->addFieldToFilter('is_opening_soon',1)->addOrder("country_name","ASC")->addFieldToSelect('city')->getData();
		$new_stores = array();
		foreach($stores as $new_store){
			array_push($new_stores ,$new_store['city'] );
		}
		sort($new_stores);
		$new_stores = array_map('strtolower', $new_stores);
		$states = array_unique($new_stores);
		return $states;
	}
 	public function getAllCities()
	{

		$total_countries = $this->getAllCountries();
		$storeArray  = $this->storeArray();
		$prev_city = "";
		$final_cities = array();
		foreach($total_countries as $one_country){

		 	$storecities = array();
		 	$new_stores_forcountry = array();
			foreach($storeArray as $city)
			{
				if($city['country_name'] == $one_country){
					if($city['is_opening_soon'] == 0){
						array_push($storecities,strtolower($city['city']));
					}
					else{
						array_push($new_stores_forcountry,strtolower($city['city']));
					}
				}
				sort($storecities);
				sort($new_stores_forcountry);
				$storecities = array_map('strtolower', $storecities);
				$new_stores_forcountry = array_map('strtolower', $new_stores_forcountry);
				$cities = array_unique($storecities);
				$new_cities = array_unique($new_stores_forcountry);
			}
			if(count($cities)>0){
				$final_cities[$one_country] = $cities;
			}
			if(count($new_cities)>0){
				$final_cities['Opening Soon in '.$one_country] = $new_cities;
			}
		}
		// $final_cities['New Stores Opening Soon'] = $this->getOpeningSoonStores();
		return $final_cities;
	}
	public function getCapitalized($word)
	{
		return ucwords($word);
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
		//$states = array_map(function($word){ return ucwords($word); }, $states);

		echo '<pre>';print_r($states);exit;
		return $states;
	}

	public function inclusiveStore($city){
		$addresses_exclusive = Mage::getSingleton('storelocator/storelocator')->getCollection()->addFieldToFilter('city',$city)->addFieldToFilter('exclusive','0')->getData();

		$totalExclusive = count($addresses_exclusive);
		for($i = 0;$i<$totalExclusive;$i++){
			for($j = 0;$j<$totalExclusive;$j++){
				if($addresses_exclusive[$j]['order'] > $addresses_exclusive[$j+1]['order']){
					$swap       = $addresses_exclusive[$j];
					$addresses_exclusive[$j]   = $addresses_exclusive[$j+1];
					$addresses_exclusive[$j+1] = $swap;
				}
			}
		}
		//echo '<pre>';print_r($addresses_exclusive);exit;
		$address_list_exclusive = '';
		$address_list = '';
		$latt_logni = '';
		foreach($addresses_exclusive as $address){
			if($address){
			$address_list.='<div class="add_wrapper"><div class="storename">'.$address['store'].'</div><div class="storeAddress">'.$address['address'].'</div><div class="storeContact">'.$address['tel_number'].'</div></div>';
			}
		}
		//echo $address_list;exit;
		return $address_list;
	}
	public function exclusiveStore($city){
		$addresses_exclusive = Mage::getSingleton('storelocator/storelocator')->getCollection()->addFieldToFilter('city',$city)->addFieldToFilter('exclusive','1')->getData();
		$totalExclusive = count($addresses_exclusive);
		for($i = 0;$i<$totalExclusive;$i++){
			for($j = 0;$j<$totalExclusive;$j++){

				//var_dump($addresses_exclusive[$j]['order']);exit;
				if($addresses_exclusive[$j]['order'] > $addresses_exclusive[$j+1]['order']){
					$swap       = $addresses_exclusive[$j];
					$addresses_exclusive[$j]   = $addresses_exclusive[$j+1];
					$addresses_exclusive[$j+1] = $swap;
				}
			}
		}
		//echo '<pre>';print_r($addresses_exclusive);exit;
		$address_list_exclusive = '';
		$address_list = '';
		$latt_logni = '';
		foreach($addresses_exclusive as $address){
			//echo '<pre>';print_r($address);exit;
			if($address){
				$address_list_exclusive.='<div class="add_wrapper"><div class="storename">'.$address['store'].'</div><div class="storeAddress">'.$address['address'].'</div><div class="storeContact">'.$address['tel_number'].'</div></div>';
			}
		}
		return $address_list_exclusive;
	}


}
