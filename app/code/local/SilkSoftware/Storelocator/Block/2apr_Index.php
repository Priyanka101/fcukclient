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
			array_push($storecities,strtolower($city['city']));			
		}
		sort($storecities);
		$storecities = array_map('strtolower', $storecities);
		$cities = array_unique($storecities);
		//return json_encode($cities);
		//$cities = array_map("getCapitalized",$cities);
			//echo '<pre>';print_r($cities);exit;
		return $cities;
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