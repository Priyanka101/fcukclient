<?php
class CommerceStack_Recommender_Block_Product_List_Related extends Mage_Catalog_Block_Product_List_Related
{
    protected $_linkSource = array('useLinkSourceManual', 'useLinkSourceCommerceStack');
    protected function _prepareData()
    {
        $limit   = Mage::getStoreConfig('recommender/relatedproducts/numberofrelatedproducts');
        $product = Mage::registry('product');
        if ($limit < 1) {
            $this->_itemCollection = $product->getRelatedProductCollection();
            $this->_itemCollection->load();
            $this->_itemCollection->clear();
            return $this;
        }
        $unionLinkedItemCollection = null;
        foreach ($this->_linkSource as $linkSource) {
            $numRecsToGet = $limit;
            if (!is_null($unionLinkedItemCollection)) {
                $numRecsToGet = $limit - count($unionLinkedItemCollection);
            }
            if ($numRecsToGet > 0) {
                $linkModel = $product->getLinkInstance();
                $linkModel->{$linkSource}();
                $linkedItemCollection = $product->getRelatedProductCollection()->addCategoryIds(38)->addAttributeToSelect('required_options')->setGroupBy()->setPositionOrder()->addStoreFilter();
                $linkedItemCollection->getSelect()->limit($numRecsToGet);
                if (!is_null($unionLinkedItemCollection)) {
                }
                Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($linkedItemCollection, Mage::getSingleton('checkout/session')->getQuoteId());
                $this->_addProductAttributesAndPrices($linkedItemCollection);
                Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($linkedItemCollection);
                $linkedItemCollection->load();
                if (is_null($unionLinkedItemCollection)) {
                    $unionLinkedItemCollection = $linkedItemCollection;
                } else {
                    foreach ($linkedItemCollection as $linkedProduct) {
                    }
                }
            }
        }
        $currentCategory = null;
        if (count($unionLinkedItemCollection) < $limit) {
            $currentCategory = Mage::registry('current_category');
            if (is_null($currentCategory)) {
                $currentProduct  = Mage::registry('current_product');
                $currentCategory = $currentProduct->getCategoryCollection();
                $currentCategory = $currentCategory->getFirstItem();
            }
        }
        $useCategoryFilter = !is_null($currentCategory);
        $randCollectionnew = array();
        while (count($unionLinkedItemCollection) < $limit) {
            $numRecsToGet      = $limit - count($unionLinkedItemCollection);
            $randCollectionnew = Mage::getModel('catalog/product')->getCollection()->addAttributeToFilter('status', '1')->addAttributeToSelect('*');
            $randCollectionnew->addStoreFilter();
            $randCollectionnew->setPage(1, $numRecsToGet);
            if ($currentCategory->getParentId() == 2) {
                $parentId = $currentCategory['entity_id'];
            } else {
                $parentId = $currentCategory->getParentId();
            }
            if ($parentId == 57) {
                $parentId = 4;
            }
            $currentCategoryId  = $currentCategory->getId();
            $categoryCollection = array();
            $children           = Mage::getModel('catalog/category')->getCategories($parentId);
            $i                  = 0;
            if ($currentCategoryId == 57) {
                foreach ($children as $category) {
                    if ($category->getId() != 58) {
                        $categoryCollection[$i] = $category->getId();
                        $i++;
                    }
                }
            } else {
                foreach ($children as $category) {
                    if ($currentCategoryId != $category->getId()) {
                        $categoryCollection[$i] = $category->getId();
                        $i++;
                    }
                }
            }
            $cat1       = array();
            $productIds = array();
            $adapter    = Mage::getSingleton('core/resource')->getConnection('core_read');
            if ($parentId == 52) {
                $cat1[0] = $currentCategoryId;
                $select  = $adapter->select()->from('catalog_category_product', 'catalog_category_product.product_id')->where('catalog_category_product.category_id IN (?)', $cat1)->group('catalog_category_product.product_id');
            } else {
                $i = 0;
                foreach ($categoryCollection as $cat_id) {
                    $select         = $adapter->select()->from('catalog_category_product', 'catalog_category_product.product_id')->where('catalog_category_product.category_id IN (?)', $cat_id)->group('catalog_category_product.product_id');
                    $productIds[$i] = $adapter->fetchAll($select);
                    $i++;
                }
            }
            if(count($productIds)<=4){
				$j=0;
				$rem=4-$i;
				for($j=0;$j<$rem;$j++){
					$select = $adapter->select()->from('catalog_category_product', 'catalog_category_product.product_id')->where('catalog_category_product.category_id IN (?)', $currentCategoryId)->group('catalog_category_product.product_id');
					$productIds[$i] = $adapter->fetchAll($select);
					$j++;$i++;
				}
			}
			$final_productIds = array();
            $pro              = Mage::getModel('catalog/product');
            foreach ($productIds as $p_id) {
                $total_p_id = count($p_id);
                if (count($p_id) == 0) {
                    continue;
                }
                $configurable_product_ids = array();
                foreach ($p_id as $p) {
                    $conf_id = $pro->load($p['product_id'])->getData();
                    if ($conf_id['type_id'] == 'configurable') {
                        $configurable_product_id = $conf_id['entity_id'];
                        array_push($configurable_product_ids, $configurable_product_id);
                    }
                }
                $configurable_id         = array_rand($configurable_product_ids, 1);
                $configurable_product_id = $configurable_product_ids[$configurable_id];
                array_push($final_productIds, $configurable_product_id);
            }
			
            $catArray    = array();
            $i           = 0;
            $_collection = Mage::getModel('catalog/product');
			$final_productIds=array_unique($final_productIds);
            foreach ($final_productIds as $ids) {
                $_productload = $_collection->load($ids);
                $catArray1    = $_productload->getCategoryIds();
                $catArray[$i] = implode(',', $catArray1);
                $i++;
                $_collection->unsetData();
            }
			
            if (count($catArray) > 1) {
                $uniqueCat = $this->array_not_unique($catArray);
                $keys      = array_keys($uniqueCat);
                $last      = end($keys);
                unset($final_productIds[$last]);
            }
			
			if ($useCategoryFilter) {
                $randCollectionnew->addAttributeToFilter('status', array(
                    'eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED
                ));
                $randCollectionnew->addAttributeToFilter('type_id', 'configurable');
                $randCollectionnew->addAttributeToFilter('entity_id', array(
                    'in' => $final_productIds
                ));
                $randCollectionnew->getSelect()->order(new Zend_Db_Expr('RAND()'));
            } else {
                $randCollectionnew->addAttributeToFilter('status', array(
                    'eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED
                ));
                $randCollectionnew->addAttributeToFilter('type_id', 'configurable');
                $randCollectionnew->addAttributeToFilter('entity_id', array(
                    'in' => $final_productIds
                ));
                $randCollectionnew->getSelect()->order(new Zend_Db_Expr('RAND()'));
            }
            foreach ($randCollectionnew as $linkedProduct) {
                $unionLinkedItemCollection->addItem($linkedProduct);
            }
            if (!$useCategoryFilter)
                break;
            $currentCategory = $currentCategory->getParentCategory();
            if (is_null($currentCategory->getId()))
                $useCategoryFilter = false;
        }
        $this->_itemCollection = $unionLinkedItemCollection;
        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }
        return $this;
    }
    function array_not_unique($raw_array)
    {
        $dupes = array();
        natcasesort($raw_array);
        reset($raw_array);
        $old_key   = NULL;
        $old_value = NULL;
        foreach ($raw_array as $key => $value) {
            if ($value === NULL) {
                continue;
            }
            if (strcasecmp($old_value, $value) === 0) {
                $dupes[$old_key] = $old_value;
                $dupes[$key]     = $value;
            }
            $old_value = $value;
            $old_key   = $key;
        }
        return $dupes;
    }
}