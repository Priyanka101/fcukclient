<?php


class Fcuk_Requestproduct_Block_Adminhtml_Request extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_request";
	$this->_blockGroup = "requestproduct";
	$this->_headerText = Mage::helper("requestproduct")->__("Request Manager");
	$this->_addButtonLabel = Mage::helper("requestproduct")->__("Add New Item");
	parent::__construct();
	
	}

}