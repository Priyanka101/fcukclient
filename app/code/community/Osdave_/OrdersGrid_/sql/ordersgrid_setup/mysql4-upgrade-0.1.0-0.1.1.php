<?php
/**
 * Setup scripts, add new column and fulfills
 * its values to existing rows
 *
 */
/* @var $this Mage_Sales_Model_Mysql4_Setup */
$this->startSetup();
// Add payment_method column to grid table
$this->getConnection()->addColumn(
    $this->getTable('sales/order_grid'),//table name
    'shipping_method',//column name
    "varchar(255) not null default ''"//definition
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),//table name
    'IDX_SHIPPING_METHOD',//index name
    'shipping_method'//fields
);
// Now you need to fullfill existing rows with data from address table
$select = $this->getConnection()->select();
$select->join(
    array('order_shipping'=>$this->getTable('sales/order')),//alias=>table_name
    $this->getConnection()->quoteInto(
        'order_shipping.entity_id = order_grid.entity_id',
    	Mage_Sales_Model_Quote_Address::TYPE_SHIPPING
    ),//join clause
    array('shipping_method' => 'shipping_method')//fields to retrieve
);
$this->getConnection()->query(
    $select->crossUpdateFromSelect(
        array('order_grid' => $this->getTable('sales/order_grid'))
    )
);
$this->endSetup();