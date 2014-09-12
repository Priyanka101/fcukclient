<?php


class Fcuk_Shiptrack_Block_Adminhtml_Shipment extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_shipment";
	$this->_blockGroup = "shiptrack";
	$this->_headerText = Mage::helper("shiptrack")->__("Shipment Manager");
	$this->_addButtonLabel = Mage::helper("shiptrack")->__("Add New Item");
	parent::__construct();
	
	}

}