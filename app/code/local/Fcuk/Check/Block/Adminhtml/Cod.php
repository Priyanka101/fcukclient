<?php


class Fcuk_Check_Block_Adminhtml_Cod extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_cod";
	$this->_blockGroup = "check";
	$this->_headerText = Mage::helper("check")->__("Cod Manager");
	$this->_addButtonLabel = Mage::helper("check")->__("Add New Item");
	parent::__construct();
	
	}

}