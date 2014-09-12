<?php


class Mac_Custom_Block_Adminhtml_Kittedout extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_kittedout";
	$this->_blockGroup = "custom";
	$this->_headerText = Mage::helper("custom")->__("Kittedout Manager");
	$this->_addButtonLabel = Mage::helper("custom")->__("Add New Item");
	parent::__construct();
	
	}

}