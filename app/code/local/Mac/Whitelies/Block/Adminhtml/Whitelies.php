<?php


class Mac_Whitelies_Block_Adminhtml_Whitelies extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_whitelies";
	$this->_blockGroup = "whitelies";
	$this->_headerText = Mage::helper("whitelies")->__("Whitelies Manager");
	$this->_addButtonLabel = Mage::helper("whitelies")->__("Add New Item");
	parent::__construct();
	
	}

}