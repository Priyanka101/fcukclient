<?php

class CommerceStack_Recommender_Block_Product_List_Related extends Mage_Catalog_Block_Product_List_Related
{
    protected $_linkSource = array('useLinkSourceManual', 'useLinkSourceCommerceStack'); // from most to least authoritative

    protected function _prepareData()
    {
		
        $limit = Mage::getStoreConfig('recommender/relatedproducts/numberofrelatedproducts');
        
        /* @var $product Mage_Catalog_Model_Product */
        $product = Mage::registry('product');
        
        // A bit of a hack, but return an empty collection if user selected 0 recommendations to show in config
        if($limit < 1)
        {
			$this->_itemCollection = $product->getRelatedProductCollection();
            $this->_itemCollection->load();
            $this->_itemCollection->clear();
            return $this;
        }

        $unionLinkedItemCollection = null;
        foreach($this->_linkSource as $linkSource)
        {
            $numRecsToGet = $limit;
            if(!is_null($unionLinkedItemCollection))
            {
                $numRecsToGet = $limit - count($unionLinkedItemCollection);
            }
            
            if($numRecsToGet > 0)
            {
				
                // Set link source to manual or automated CommerceStack recommendations
                $linkModel = $product->getLinkInstance();
                $linkModel->{$linkSource}();
                
                $linkedItemCollection = $product->getRelatedProductCollection()
				//print_r(get_class_methods($linkedItemCollection->addCategoryIds(15,12)));exit;
				->addCategoryIds(38)
                ->addAttributeToSelect('required_options')
			    ->setGroupBy()
                ->setPositionOrder()
                ->addStoreFilter(); 
               
                $linkedItemCollection->getSelect()->limit($numRecsToGet);
				//print_r($linkedItemCollection->getData());exit;
				
                
                if(!is_null($unionLinkedItemCollection))
                {
                    //$linkedItemCollection->addExcludeProductFilter($unionLinkedItemCollection->getAllIds());
                }
                
                Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($linkedItemCollection,
                    Mage::getSingleton('checkout/session')->getQuoteId() );
               //echo 1234;
                $this->_addProductAttributesAndPrices($linkedItemCollection);
        
        //        Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection);
                Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($linkedItemCollection);
        
                $linkedItemCollection->load();
                //print_r($unionLinkedItemCollection->getData());exit;
                if(is_null($unionLinkedItemCollection))
                {
					//echo 'empty';
                    $unionLinkedItemCollection = $linkedItemCollection;
					//var_dump($unionLinkedItemCollection);exit;
                }
                else
                {	//echo 'notempty';exit;
                    // Add new source linked items to existing union of linked items
                    foreach($linkedItemCollection as $linkedProduct)
                    {
                        //$unionLinkedItemCollection->addItem($linkedProduct);
                        //$unionLinkedItemCollection->addItem();
                    }
                }
            }
        }

        // Get category of current product
        $currentCategory = null;
        if(count($unionLinkedItemCollection) < $limit)
        {
            $currentCategory = Mage::registry('current_category');
            if(is_null($currentCategory))
            {
                // This could be a recently viewed or a search page. Try to get category collection and arbitrarily use first
                /* @var $currentProduct Mage_Catalog_Model_Product */
                $currentProduct = Mage::registry('current_product');
                $currentCategory = $currentProduct->getCategoryCollection();
                $currentCategory = $currentCategory->getFirstItem();
            }
        }
		
		$useCategoryFilter = !is_null($currentCategory);
        while(count($unionLinkedItemCollection) < $limit)
        {
			
            // We still don't have enough recommendations. Fill out the remaining with randoms.
            $numRecsToGet = $limit - count($unionLinkedItemCollection); 
             
            $randCollectionnew = Mage::getModel('catalog/product')->getCollection()
							->addAttributeToSelect('*');
							
            //Mage::getModel('catalog/layer')->prepareProductCollection($randCollection);
            //$randCollection->getSelect()->order('rand()');
            $randCollectionnew->addStoreFilter();
            $randCollectionnew->setPage(1, $numRecsToGet);
            //$randCollection->addIdFilter(array_merge($unionLinkedItemCollection->getAllIds(), array($product->getId())), true);
           if($currentCategory->getParentId() == 2)
			{
				$parentId = $currentCategory['entity_id'];
			//echo '<pre>';print_r($currentCategory->getData());exit;
			//echo $parentId;exit;
			}
			else
			{
				$parentId = $currentCategory->getParentId();
			}
			
			if($parentId==57)
			{
				$parentId = 4;
			}
			$currentCategoryId = $currentCategory->getId(); 
			//$currentCategoryId = Mage::getSingleton('catalog/layer')->getCurrentCategory()->getId();
			
			$categoryCollection = array();
			$children = Mage::getModel('catalog/category')->getCategories($parentId);
			$i =0;
			
			if($currentCategoryId==57)
			{
				foreach($children as $category)
				{
					if($category->getId()!= 58)
					{
						$categoryCollection[$i] =  $category->getId();
						$i++;
					}
				}
			}
			else
			{
				foreach ($children as $category) {
				
				if($currentCategoryId != $category->getId()){
					$categoryCollection[$i] =  $category->getId();
					$i++;
				}
				
				}
			}
			
			//print_r($categoryCollection);exit;
			$cat1 = array();
			$productIds = array();
			$adapter = Mage::getSingleton('core/resource')->getConnection('core_read');
			//echo $parentId;exit;
			if($parentId == 52)
			{
				$cat1[0] = $currentCategoryId;
				$select = $adapter->select()
				->from('catalog_category_product', 'catalog_category_product.product_id')
				->where('catalog_category_product.category_id IN (?)', $cat1)
				->group('catalog_category_product.product_id');
			}
			else
			{
				$select = $adapter->select()
				->from('catalog_category_product', 'catalog_category_product.product_id')
				->where('catalog_category_product.category_id IN (?)', $categoryCollection)
				->group('catalog_category_product.product_id');
				
			}
			 $productIds = $adapter->fetchAll($select);
            if($useCategoryFilter)
            {
				//echo 'faisal';
                //$randCollection->addCategoryFilter(47,13,12,14);
				 $randCollectionnew->addAttributeToFilter('entity_id',array('in'=>$productIds)); 
				 $randCollectionnew->addFieldToFilter('type_id','configurable');
				 $randCollectionnew->addAttributeToFilter('status',array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));
				 $randCollectionnew->getSelect()->order(new Zend_Db_Expr('RAND()'));
				 //echo '<pre>';
				 //print_r(($randCollectionnew->getData()));exit;
				
            }
            
            foreach($randCollectionnew as $linkedProduct)
            {
                $unionLinkedItemCollection->addItem($linkedProduct);
            }
            
            if(!$useCategoryFilter) break; // We tried everything
            
            // Go up a category level for next iteration
            $currentCategory = $currentCategory->getParentCategory();
            if(is_null($currentCategory->getId())) $useCategoryFilter = false;
            
        }
		
        $this->_itemCollection = $unionLinkedItemCollection;
        
        
        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
			
        }
	
        return $this;
    }
}