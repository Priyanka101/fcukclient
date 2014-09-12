<?php


class SilkSoftware_Superman_Block_Adminhtml_Superman extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_superman";
	$this->_blockGroup = "superman";
	$this->_headerText = Mage::helper("superman")->__("Superman Manager");
	$this->_addButtonLabel = Mage::helper("superman")->__("Add New Item");
	parent::__construct();
	
	}

}