<?php

class CommerceStack_Recommender_Block_Product_List_Upsell extends Mage_Catalog_Block_Product_List_Upsell
{
    protected $_columnCount = 4;

    protected $_items;

    protected $_itemCollection;

    protected $_itemLimits = array();

    protected $_linkSource = array('useLinkSourceManual', 'useLinkSourceCommerceStack'); // from most to least authoritative
    
    protected function _prepareData()
    {
        $limit = Mage::getStoreConfig('recommender/relatedproducts/numberofupsellproducts');
        
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
            
                // If fetching CommerceStack recs, use the source defined by user in config
                if($linkSource == 'useLinkSourceCommerceStack')
                {
                     $upsellSource = Mage::getStoreConfig('recommender/relatedproductsadvanced/upsellsource');
                    
                    if($upsellSource == 'related')
                    {
                        $linkedItemCollection = $product->getRelatedProductCollection()
                            ->addAttributeToSelect('required_options')
                            ->setGroupBy()
                            ->setPositionOrder()
                            ->addStoreFilter();
                    }
                    elseif($upsellSource == 'crosssell')
                    {
                        $linkedItemCollection = $product->getCrossSellProductCollection()
                            ->setGroupBy()
                            ->setPositionOrder()
                            ->addStoreFilter();
                    }
                    else
                    {
                        continue; // random products
                    }
                }
                else
                {
                        $linkedItemCollection = $product->getUpSellProductCollection()
                         //   ->addAttributeToSort('position', 'asc')
                            ->setGroupBy()
                            ->setPositionOrder()
                            ->addStoreFilter();
                }
                
                $linkedItemCollection->getSelect()->limit($numRecsToGet);
                
                if(!is_null($unionLinkedItemCollection))
                {
                    $linkedItemCollection->addExcludeProductFilter($unionLinkedItemCollection->getAllIds());
                }
            
        
                Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($linkedItemCollection,
                    Mage::getSingleton('checkout/session')->getQuoteId()
                );
                $this->_addProductAttributesAndPrices($linkedItemCollection);
        
        //        Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection);
                Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($linkedItemCollection);
        
//                if ($this->getItemLimit('upsell') > 0) {
//                    $this->_itemCollection->setPageSize($this->getItemLimit('upsell'));
//                }
        
                $linkedItemCollection->load();
                
                if(is_null($unionLinkedItemCollection))
                {
                    $unionLinkedItemCollection = $linkedItemCollection;
                }
                else
                {
                    // Add new source linked items to existing union of linked items
                    foreach($linkedItemCollection as $linkedProduct)
                    {
                        $unionLinkedItemCollection->addItem($linkedProduct);
                    }
                }
            }
        }
        
        // Get category of current product
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
            
            $useCategoryFilter = !is_null($currentCategory);
        }
        
        while(count($unionLinkedItemCollection) < $limit)
        {
            // We still don't have enough recommendations. Fill out the remaining with randoms.
            $numRecsToGet = $limit - count($unionLinkedItemCollection); 
             
            /* @var $randCollection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
            $randCollection = Mage::getResourceModel('catalog/product_collection');
            Mage::getModel('catalog/layer')->prepareProductCollection($randCollection);
            $randCollection->getSelect()->order('rand()');
            $randCollection->addStoreFilter();
            $randCollection->setPage(1, $numRecsToGet);
            $randCollection->addIdFilter(array_merge($unionLinkedItemCollection->getAllIds(), array($product->getId())), true);
            
            if($useCategoryFilter)
            {
                $randCollection->addCategoryFilter($currentCategory);
            }
            
            foreach($randCollection as $linkedProduct)
            {
                $unionLinkedItemCollection->addItem($linkedProduct);
            }
            
            if(!$useCategoryFilter) break; // We tried everything
            
            // Go up a category level for next iteration
            $currentCategory = $currentCategory->getParentCategory();
            if(is_null($currentCategory->getId())) $useCategoryFilter = false;
        }
        
        $this->_itemCollection = $unionLinkedItemCollection;

        /**
         * Updating collection with desired items
         */
        Mage::dispatchEvent('catalog_product_upsell', array(
            'product'       => $product,
            'collection'    => $this->_itemCollection,
            'limit'         => $this->getItemLimit()
        ));

        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return parent::_beforeToHtml();
    }

    public function getItemCollection()
    {
        return $this->_itemCollection;
    }

    public function getItems()
    {
        if (is_null($this->_items)) {
            $this->_items = $this->getItemCollection()->getItems();
        }
        return $this->_items;
    }

    public function getRowCount()
    {
        return ceil(count($this->getItemCollection()->getItems())/$this->getColumnCount());
    }

    public function setColumnCount($columns)
    {
        if (intval($columns) > 0) {
            $this->_columnCount = intval($columns);
        }
        return $this;
    }

    public function getColumnCount()
    {
        return $this->_columnCount;
    }

    public function resetItemsIterator()
    {
        $this->getItems();
        reset($this->_items);
    }

    public function getIterableItem()
    {
        $item = current($this->_items);
        next($this->_items);
        return $item;
    }

    /**
     * Set how many items we need to show in upsell block
     * Notice: this parametr will be also applied
     *
     * @param string $type
     * @param int $limit
     * @return Mage_Catalog_Block_Product_List_Upsell
     */
    public function setItemLimit($type, $limit)
    {
        if (intval($limit) > 0) {
            $this->_itemLimits[$type] = intval($limit);
        }
        return $this;
    }

    public function getItemLimit($type = '')
    {
        if ($type == '') {
            return $this->_itemLimits;
        }
        if (isset($this->_itemLimits[$type])) {
            return $this->_itemLimits[$type];
        }
        else {
            return 0;
        }
    }
}