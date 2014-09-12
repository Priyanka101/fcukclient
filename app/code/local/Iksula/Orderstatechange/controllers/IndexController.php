<?php
class Iksula_Orderstatechange_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Titlename"),
                "title" => $this->__("Titlename")
		   ));

      $this->renderLayout(); 
	  
    }
	
	public $attrSetId = 9;
	public $i;
	public $simpleProducts = array(); 
	public $lowestPrice;
	public $configurable_attribute = "ring_size"; 
	public $attr_id = 143; 
	public $magento_categories = array(9);
	
	
	public function importProductsAction(){
		  $databasetable = "sample";
		  $fieldseparator = ",";
		  $lineseparator = "\n";
		  $csvfile = "product-import.csv";
		  echo '<pre>';
		  $row = 0;
			if (($handle = fopen($csvfile, "r")) !== FALSE) {
				$products = array();
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					
					$this->i++;
					$num = count($data);
					//echo "<p> $num fields in line $row: <br /></p>\n";
					$row++; 
				//if($row > 6){print_r($products);exit;}
					if($row > 1){
						if($data[1] != ''){
							
							if(!empty($products['configurable'])){
								//print_r($products); exit;
								if(is_object(Mage::getSingleton('catalog/product')->loadByAttribute('sku',$products['configurable']['sku']))){
									
									echo 'Data Collected. Starting Creation...<br />';
									$this->createSimpleProduct($products['configurable']);
									echo 'Simple Created <br />';
									$this->assignSimple($products,$data);
									//$this->createConfigurableProduct($products,$data);
									echo 'Simple Associated <br />';
								}else{
									echo 'SKU:'.$products['configurable']['sku'].' : ==> does not Exist, going to next <br />'; 
								}	
								
								echo 'SKU:'.$products['configurable']['sku'].' : ==> done <br />
								===================================NEXT=====================================
								<br />'; //exit;
								//reset variables
								$this->i = 0;
								$this->simpleProducts = array();
								$this->lowestPrice = 99999999;
								$products = array();
							}
							echo 'SKU:'.$data[1].' : ==> Collecting Configurable data set  <br />';
							$products['configurable'] = $this->getConfigurable($data);
							echo 'SKU:'.$data[1].' : ==> Collecting simples '.$data[1].'- option: '.$data[3].' <br />';
							$products['configurable']['simple'][] = $this->getSimple($data, $products['configurable']);
						}else{
							echo 'SKU:'.$products['configurable']['sku'].' : ==> Collecting simples '.$data[1].'- option : '.$data[3].' <br />';
							$products['configurable']['simple'][] = $this->getSimple($data, $products['configurable']);
						}

					}
				}
				//print_r($this->_ordersToCreate);exit; 
				fclose($handle);
			}
			
		
		echo 'Complete';	
	}
	
	public function getOptionId($attr, $attr_value){
		
		$configurableAttributeOptionId = $this->getAttributeOptionValue($attr, $attr_value); 
		if (!$configurableAttributeOptionId) { 
			$configurableAttributeOptionId = $this->addAttributeOption($attr, $attr_value); 
		}  
		return $configurableAttributeOptionId;
	}
	
	public function createSimpleProduct($main_product_data){
		// There's some more advanced logic above the foreach loop which determines how to define $configurable_attribute, 
		// which is beyond the scope of this article. For reference purposes, I'm hard coding a value for 
		// $configurable_attribute here, and it's associated numerical attribute ID... 
		
		$this->lowestPrice = 999999;
		//echo 'here';exit;
		// Loop through a pre-populated array of data gathered from the CSV files (or database) of old system.. 
		foreach ($main_product_data['simple'] as $simple_product_data) { 
			// Again, I have more logic to determine these fields, but for clarity, I'm still including the variables here hardcoded.. 
			$attr_value = trim($simple_product_data['ring_size']); 
			$this->attr_id = 143;   
			// We need the actual option ID of the attribute value ("XXL", "Large", etc..) so we can assign it to the product model later.. 
			// The code for getAttributeOptionValue and addAttributeOption is part of another article (linked below this code snippet) 
			
			$configurableAttributeOptionId = $this->getAttributeOptionValue($this->configurable_attribute, $attr_value); 
			if (!$configurableAttributeOptionId) { 
				$configurableAttributeOptionId = $this->addAttributeOption($this->configurable_attribute, $attr_value); 
			}  
			$sProduct = Mage::getSingleton('catalog/product')->loadByAttribute('sku',$simple_product_data['sku']. " - " . $attr_value);
			if(!is_object($sProduct)){
				//print_r($configurableAttributeOptionId);exit;
				// Create the Magento product model 
				
				
				
				
				$sProduct = Mage::getModel('catalog/product'); 
				$sProduct ->setTypeId(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) 
						->setWebsiteIds(array(2)) 
						->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) 	
						->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE) 
						->setTaxClassId(0) 
						->setAttributeSetId($this->attrSetId) 
						->setCategoryIds($main_product_data['categories'])// Populated further up the script 
						->setSku($simple_product_data['sku']. " - " . $attr_value) // $main_product_data is an array created as part of a wider foreach loop, which this code is inside of 
						->setName($main_product_data['name'] . " - " . $attr_value) 
						->setDescription($main_product_data['name']) 
						->setPrice(sprintf("%0.2f", $simple_product_data['price'])) 
						->setData($this->configurable_attribute, $configurableAttributeOptionId) ;   
				// Set the stock data. Let Magento handle this as opposed to manually creating a cataloginventory/stock_item model.. 
						$sProduct->setStockData(array( 'is_in_stock' => 1, 'qty' => 99999 ));   
						$sProduct->save();   
				// Store some data for later once we've created the configurable product, so we can 
				// associate this simple product to it later.. 
						array_push( 
							$this->simpleProducts, 
								array( 
									"id" => $sProduct->getId(), 
									"price" => $sProduct->getPrice(), 
									"attr_code" => $this->configurable_attribute, 
									"attr_id" => $this->attr_id, 
									"value" => $configurableAttributeOptionId, 
									"label" => $attr_value 
								) 
						);   
				if ($simple_product_data['price'] < $this->lowestPrice) { 
					$this->lowestPrice = $simple_product_data['price']; 
				} 
			}else{
				array_push( 
							$this->simpleProducts, 
								array( 
									"id" => $sProduct->getId(), 
									"price" => $sProduct->getPrice(), 
									"attr_code" => $this->configurable_attribute, 
									"attr_id" => $this->attr_id, 
									"value" => $configurableAttributeOptionId, 
									"label" => $attr_value 
								) 
						);
				echo $simple_product_data['sku']. " - " . $attr_value .' :Skipping Already exist simple';
			}
		}
	}
	
	public function assignSimple($main_product_data,$data){
	
		$main_product_data = $main_product_data['configurable'];
		
		$product = Mage::getSingleton('catalog/product');
		$productId = $product->getIdBySku($main_product_data['sku']);
		$parent = $product->setWebsiteId(2)->setStoreId(2)->load($productId);

		$childIds = $parent->getTypeInstance()->getUsedProductIds();
		foreach ($this->simpleProducts as $simpleArray) { 
			$childIds[] = $simpleArray['id']; 
		}	

		$product = Mage::getResourceModel( 'catalog/product_type_configurable' )->load( $parent, $parent->getId() );
		//print_r(get_class_methods($product));exit;
		
			echo "\n\rSaving configurable product...\n\r";

			$product->saveProducts( $parent, $childIds );

		
	}
	
	
	public function createConfigurableProduct($main_product_data,$data){
		
		$main_product_data = $main_product_data['configurable'];
		
		if(is_object(Mage::getSingleton('catalog/product')->loadByAttribute('sku',$main_product_data['sku']))){
			
			$product = Mage::getSingleton('catalog/product');
			$productId = $product->getIdBySku($main_product_data['sku']);
			$cProduct = Mage::getSingleton('catalog/product');
			$cProduct->setStoreId(2)->load($productId);
			
			$cProduct->setCanSaveConfigurableAttributes(true);
			$cProduct->setCanSaveCustomOptions(true);
			 
			$cProductTypeInstance = $cProduct->getTypeInstance();
			// This array is is an array of attribute ID's which the configurable product swings around (i.e; where you say when you 
			// create a configurable product in the admin area what attributes to use as options) 
			// $_attributeIds is an array which maps the attribute(s) used for configuration so their numerical counterparts. 
			// (there's probably a better way of doing this, but i was lazy, and it saved extra db calls); 
			$_attributeIds = array("ring_size" => 143); 
			// etc..  
			$cProductTypeInstance->setUsedProductAttributeIds(array($_attributeIds[$this->configurable_attribute]));


			// Now we need to get the information back in Magento's own format, and add bits of data to what it gives us..
			$attributes_array = $cProductTypeInstance->getConfigurableAttributesAsArray(); 
			foreach($attributes_array as $key => $attribute_array) { 
				$attributes_array[$key]['use_default'] = 1; 
				$attributes_array[$key]['position'] = 0;   
				if (isset($attribute_array['frontend_label'])) { 
					$attributes_array[$key]['label'] = $attribute_array['frontend_label']; 
				} else { 
					$attributes_array[$key]['label'] = $attribute_array['attribute_code']; 
				} 
			}
			
			
			// Add it back to the configurable product..
			$cProduct->setConfigurableAttributesData($attributes_array);
			
			// Remember that $simpleProducts array we created earlier? Now we need that data..
			
			$dataArray = array(); 
			foreach ($this->simpleProducts as $simpleArray) { 
				$dataArray[$simpleArray['id']] = array(); 
				foreach ($attributes_array as $attrArray) { 
					array_push( $dataArray[$simpleArray['id']], 
						array( 
							"attribute_id" => $simpleArray['attr_id'], 
							"label" => $simpleArray['label'], 
							"is_percent" => false, 
							"pricing_value" => $simpleArray['price'] 
						) 
					); 
				} 
			}
			//print_r($dataArray);exit;
			// This tells Magento to associate the given simple products to this configurable product.. 
			$cProduct->setConfigurableProductsData($dataArray);   
			// Set stock data. Yes, it needs stock data. No qty, but we need to tell it to manage stock, and that it's actually 
			// in stock, else we'll end up with problems later.. 
			$cProduct->setStockData(
						array( 
							'use_config_manage_stock' => 1, 
							'is_in_stock' => 1, 
							'is_salable' => 1 
							)
					);   
			// Finally...! 
			//print_r($cProduct->getData());exit;	
			$cProduct->save();
		}



	}
	
	public function getProductUrlKey($name){
		$name =  strtolower($name);
		return $name = str_replace(' ','-', $name);
		
	}
	
	//$optionValue = $this->getAttributeOptionValue("size", "XL");
	public function getAttributeOptionValue($arg_attribute, $arg_value) { 
		if(trim($arg_value) == '' || trim($arg_value) == '-'){
			$arg_value = 'NA';
		}
		
		$attribute_model = Mage::getModel('eav/entity_attribute'); 
		$attribute_options_model= Mage::getModel('eav/entity_attribute_source_table') ;   
		$attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute); 
		$attribute = $attribute_model->load($attribute_code);   
		$attribute_table = $attribute_options_model->setAttribute($attribute); 
		$options = $attribute_options_model->getAllOptions(false);   
		
		foreach($options as $option) { 
			if (trim($option['label']) == trim($arg_value)) { 
				return $option['value']; 
				//echo trim($option['label']) .'=='. trim($arg_value);
			}
		}   
		return false; 
	}
		
	// $optionValue = $this->addAttributeOption("size", "XXL");
	public function addAttributeOption($arg_attribute, $arg_value) {
		$arg_value = trim($arg_value);
		
		if(trim($arg_value) == '' || trim($arg_value) == '-'){
			$arg_value = 'NA';
		}
		
		$attribute_model        = Mage::getModel('eav/entity_attribute');
		$attribute_options_model= Mage::getModel('eav/entity_attribute_source_table') ;
	 
		$attribute_code         = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
		$attribute              = $attribute_model->load($attribute_code);
	 
		$attribute_table        = $attribute_options_model->setAttribute($attribute);
		$options                = $attribute_options_model->getAllOptions(false);
	 
		$value['option'] = array($arg_value,$arg_value);
		$result = array('value' => $value);
		
		$attribute->setData('option',$result);
		$attribute->save();
	 
		return $this->getAttributeOptionValue($arg_attribute, $arg_value);
	}



	
	private function getConfigurable($row){
		$product['sku'] = str_replace(' ', '-',strtoupper($row[1]));
		$product['name'] = $row[2];
		//$product['ring_size'] = $row[3];
		//$product['unit_price'] = $row[5];
		$product['categories'] = explode(',',$row[4]);
		
		
		return $product;
		
	}
	
	private function getSimple($row, $configurable){
		//$product['brand_generic'] = $configurable['brand_generic'];
		$product['sku'] = str_replace(' ', '-',strtoupper($configurable['sku']));
		$product['name'] = $configurable['name'];
		$product['ring_size'] = $row[3];
		$product['categories'] = explode(',',$configurable['categories'][0]);
		
		return $product;
	}
	
	
	
	
	
}