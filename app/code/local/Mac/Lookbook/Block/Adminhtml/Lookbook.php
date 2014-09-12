<?php


class Mac_Lookbook_Block_Adminhtml_Lookbook extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_lookbook";
	$this->_blockGroup = "lookbook";
	$this->_headerText = Mage::helper("lookbook")->__("Lookbook Manager");
	$this->_addButtonLabel = Mage::helper("lookbook")->__("Add New Item");
	parent::__construct();
	
	}

}