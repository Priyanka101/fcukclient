<?php


class Mac_Requestcatalog_Block_Adminhtml_Requestcatalog extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_requestcatalog";
	$this->_blockGroup = "requestcatalog";
	$this->_headerText = Mage::helper("requestcatalog")->__("Requestcatalog Manager");
	$this->_addButtonLabel = Mage::helper("requestcatalog")->__("Add New Item");
	parent::__construct();
	
	}

}