<?php
class Rayfox_Catalog_Model_Layer extends Mage_Catalog_Model_Layer
{
	public function prepareProductCollection($collection)
	{
		
		//call parent prepareProductCollection
		parent::prepareProductCollection($collection);
		
		//check enabled
		if(!Mage::helper('rayfox_catalog')->isSortOutOfStockProductsAtBottomEnabled()){
			return $this;
		}

		$collection = $collection->joinField('inventory_in_stock', 'cataloginventory_stock_item', 'is_in_stock', 'product_id=entity_id','is_in_stock>=0', 'left')->setOrder('inventory_in_stock','desc');
		//sort by stock status
		//if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
           // Mage::getModel('cataloginventory/stock_item')->addCatalogInventoryToProductCollection($collection);
        //}
        
        //$collection->getSelect()->order('is_in_stock','desc');
		//echo '<pre>';
       // print_r($collection->getData());exit;
		return $this;
	}
}