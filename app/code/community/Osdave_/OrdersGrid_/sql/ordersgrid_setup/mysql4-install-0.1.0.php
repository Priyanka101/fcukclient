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
    'payment_method',//column name
    "varchar(255) not null default ''"//definition
);
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$this->getConnection()->addKey(
    $this->getTable('sales/order_grid'),//table name
    'IDX_PAYMENT_METHOD',//index name
    'payment_method'//fields
);
// Now you need to fullfill existing rows with data from address table
$select = $this->getConnection()->select();
$select->join(
    array('order_payment'=>$this->getTable('sales/order_payment')),//alias=>table_name
    $this->getConnection()->quoteInto(
        'order_payment.parent_id = order_grid.entity_id',
    	Mage_Sales_Model_Quote_Address::TYPE_BILLING
    ),//join clause
    array('payment_method' => 'method')//fields to retrieve
);
$this->getConnection()->query(
    $select->crossUpdateFromSelect(
        array('order_grid' => $this->getTable('sales/order_grid'))
    )
);
$this->endSetup();