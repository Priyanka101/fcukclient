<?php
/**
 * @copyright   Copyright (c) 2010 Amasty (http://www.amasty.com)
 */ 
class Amasty_Shopby_Model_Catalog_Layer_Filter_Category extends Mage_Catalog_Model_Layer_Filter_Category
{

    /**
     * Get data array for building category filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        if ('catalogsearch' == Mage::app()->getRequest()->getModuleName())
            return parent::_getItemsData();
            
        $isStatic2LevelTree = (3 == Mage::getStoreConfig('amshopby/general/categories_type'));      
        $isShowSubCats      = (2 == Mage::getStoreConfig('amshopby/general/categories_type'));      
        
        // alwaus use root category
        $currentCategory = $this->getCategory();
        $root = Mage::getModel('catalog/category')
                ->load($this->getLayer()->getCurrentStore()->getRootCategoryId()) ;  
            
        $categories = $isStatic2LevelTree ? $root->getChildrenCategories() : $currentCategory->getChildrenCategories();
        
        if ($isStatic2LevelTree)
            $this->getLayer()->setCurrentCategory($root);
        
        $this->getLayer()->getProductCollection()
            ->addCountToCategories($categories);        

        $data = array();
        foreach ($categories as $category) {
            $id = $category->getId();
            $data[] = $this->_prepareItemData($category, $id, $id == $currentCategory->getId());
            if ($isShowSubCats || $isStatic2LevelTree) { 
               $children      = $category->getChildrenCategories();
               if ($children && count($children)){
                   
                   //remember that category has children
                   $last = count($data)-1;
                   if ($data[$last])
                        $data[$last]['has_children'] = true;
                   
                   $this->getLayer()->getProductCollection()->addCountToCategories($children); 
                   foreach ($children as $child){ // we shoul have all categories in the top navigation cache, so no additional queries
                       $isFolded   = ($currentCategory->getParentId() != $child->getParentId());
                       $isSelected = ($currentCategory->getId() == $child->getId());
                       if ($isSelected && $data[$last]){
                            $data[$last]['is_child_selected'] = true;    
                       }
                       $data[] = $this->_prepareItemData($child, $id, $isSelected, 2, $isFolded);                              
                   }
               }
            } //if add sub-categories
        }
        //restore category 
        if ($isStatic2LevelTree)
            $this->getLayer()->setCurrentCategory($currentCategory);
        $_category=Mage::getModel('catalog/layer')->getCurrentCategory(); 
            $_category->getId();
            $parentCategoryId = $_category->getParentId();
            $categoryinfo = Mage::getModel('catalog/category')->load($parentCategoryId);
            $namenew = $categoryinfo->getData('name');

           if(count($data)==0 && $namenew!='Category'){
            //Mage::getModel('catalog/layer')->getCurrentCategory()->getId(); 
       
            $children = Mage::getModel('catalog/category')->getCategories($parentCategoryId);
            $cat = Mage::getModel('catalog/category')->load($parentCategoryId);
            $subcatcollection = $cat->getChildren();
            $categoryArray=explode(',', $subcatcollection);
          //  $data[]=array();
            $ii=0;
          foreach ($categoryArray as $category) {
        
               // $category;
                $products = Mage::getModel('catalog/category')->load($category)
                            ->getProductCollection()
                            ->addAttributeToSelect('*')
                            ->addAttributeToFilter('status', array('eq' => 1));
                //echo '<pre>';
               // print_r($products->getData());
               // exit;
                if(count($products->getData())>0){

                    $data[$ii]=$category;
                    $categoryinfo = Mage::getModel('catalog/category')->load($category);
                    $urlpathnew = $categoryinfo->getData('url_path');
                    $levelbew = $categoryinfo->getData('level');
                    $namenew = $categoryinfo->getData('name');
                    $productcount = $categoryinfo->getProductCount();
                    if($categoryinfo->getIsActive() && $categoryinfo->getProductCount()):
                  //  $data[] = $this->_prepareItemData($category, $category, 1,'true',1);                              
                     $row = array(
                    'label'       => $namenew,
                    'value'       => Mage::helper('amshopby/url')->getCategoryUrl($categoryinfo),
                    'count'       => $productcount,
                    'level'       => $levelbew,
                    'id'          => $category,
                    'is_folded'   => 1,
                    'is_selected' => 0,
                ); 
                    $data[$ii]=$row;
                    $ii++;
                    endif;
                }

            }
        }
            
        return $data;
    }
    
    
    protected function _initItems()
    {
        if ('catalogsearch' == Mage::app()->getRequest()->getModuleName())
            return parent::_initItems();
            
        $data  = $this->_getItemsData();
        $items = array();
        foreach ($data as $itemData) {
            if (!$itemData)
                continue;
                
            $obj = new Varien_Object();
            $obj->setData($itemData);
            $obj->setUrl($itemData['value']);
            
            $items[] = $obj;
        }
        $this->_items = $items;
        return $this;
    }
    
    
    protected function _prepareItemData($category, $id, $isSelected, $level=1, $isFolded=false)
    {
        $row = null;
        if ($category->getIsActive() && $category->getProductCount()) {
            $row = array(
                'label'       => Mage::helper('core')->htmlEscape($category->getName()),
                'value'       => Mage::helper('amshopby/url')->getCategoryUrl($category),
                'count'       => $category->getProductCount(),
                'level'       => $level,
                'id'          => $id,
                'is_folded'   => $isFolded,
                'is_selected' => $isSelected,
            ); 
        }
        return $row;      
    }
    
}