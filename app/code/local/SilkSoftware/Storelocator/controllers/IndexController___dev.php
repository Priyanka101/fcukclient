<?php
class SilkSoftware_Storelocator_IndexController extends Mage_Core_Controller_Front_Action{
    
	private $storeCollection = array() ;
	public function storeCollection()
	{
		$storeCollection  = Mage::getSingleton('storelocator/storelocator')->getCollection();
		return $storeCollection;
	}
	
	public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("storelocator"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("storelocator", array(
                "label" => $this->__("storelocator"),
                "title" => $this->__("storelocator")
		   ));

      $this->renderLayout(); 
	  
    }
	public function StoreAction()
	{
		$name = $this->getRequest()->getParam('name');
		//echo $name;
		$storelocation = Mage::getSingleton('storelocator/storelocator')->getCollection()
			->addFieldToFilter('state', array('like' => $name));
			//echo '<pre>';print_r($storelocation->getData());
			$html = "<ul><li><p>store</p><p>address</p><p>city</p><p>pin code</p><p>telephone number</p></li>";
		foreach($storelocation as $store)
		{
			$html.="<li><p>".$store['store']."</p><p>".$store['address']."</p><p>".$store['city']."</p><p>".$store['pincode']."</p><p>".$store['tel_number']."</p></li>";
		}
		$html.="</ul>";
		echo $html;
	}
	
	
	public function StateAction()
	{
		$state = $this->getRequest()->getPost('state');
		//echo '<pre>';print_r($this->storeCollection()->getData());
		//echo $state;
		$cities = $this->storeCollection()->addFieldToFilter('state',array('like'=>$state))->getData();
		$selected_cities = array();
		//echo '<pre>';print_r($cities);
		$count = 0;
		$lower = "";
		foreach($cities as $city)
		{	//echo "";
			//echo $city['city'];
			
			
			array_push($selected_cities,strtolower($city['city']));
		}
			//echo '<pre>';print_r($selected_cities);
		$unique_cities = 	array_unique($selected_cities);
		
		$cities_option = "<select name=\"city\" id=\"city\">";
		
		foreach($unique_cities as $city)
		{	
			$cities_option.="<option value=".$city.">".ucfirst($city)."</option>" ;
				
			
			
		}
		$cities_option.="</select>";
		echo $cities_option;
		//print_r($selected_cities);
	}
	
	public function cityAction()
	{
		$city=$this->getRequest()->getParam('city');
		//echo $city;
		$addresses = $this->storeCollection()->addFieldToFilter('city',array('like'=>$city))->getData();
		//echo '<pre>';print_r($addresses);exit;
		$address_list = '';
		$latt_logni = '';
		foreach($addresses as $address)
		{	/* $address_list.='<div class="address_wrapper">';
			$address_list.='<div class="address">'.$address['address'].'</div>';
			$address_list.='<div class="no">'.$address['tel_number'].'</div>';
			$address_list.='</div>' ; */
			//$address_url = 	Mage::getUrl(). 'storelocator/index/gmapnew';
			
			$address_list.='<div class="add_wrapper"><div class="storename">'.$address['store'].'</div><div class="storeAddress">'.$address['address'].'</div><div class="storeContact">'.$address['tel_number'].'</div></div>';
			
			
			//$latt_logni .= $address['lattlong']."@".$address['address'].";";
			
		}
		
		echo $address_list;
	}
	public function gmapAction()
	{
		$city=$this->getRequest()->getParam('city');
		$map = Mage::getSingleton('storelocatormap/storelocatormap')->getCollection()->addFieldToFilter('city',array('like'=>$city))->getData();
		//echo '<pre>';print_r($map);
		echo $map[0]['iframe'];
	}
	
	public function gmapnewAction(){
		
		//print_r( $this->getRequest()->getParam('address'));
		//$layout = Mage::app()->getLayout();
		//$cart = $layout->getBlock('storelocator/googlemap')->toHtml();
//echo $cart;
		
		//$this->loadLayout();
		//$this->renderLayout(); 
		
		
		$this->loadLayout();
		$block = $this->getLayout()->createBlock(
		'Mage_Core_Block_Template',
		'storelocator_googlemap',
		array('template' => 'storelocator/googlemap.phtml')
		);

		echo $block->toHtml();

		//$this->getLayout()->getBlock('content')->append($block);
		//Release layout stream... lol... sounds fancy
		//$this->renderLayout();
		
		
		
		
	}
	
	public function getLattLongAction()
	{
		$store_id = $this->getRequest()->getParam('store_id');
		$store_lattlong = $this->storeCollection()->addFieldToFilter('store_id',$store_id)->addFieldToSelect(array('lattlong','address'))->getData();
		//return $store_id;
		//echo '<pre>';print_r($store_lattlong);exit;
		echo $store_lattlong[0]['lattlong']."@".$store_lattlong[0]['address'].";";
	
	}
	
	
}