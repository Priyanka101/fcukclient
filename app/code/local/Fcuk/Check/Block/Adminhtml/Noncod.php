<?php


class Fcuk_Check_Block_Adminhtml_Noncod extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_noncod";
	$this->_blockGroup = "check";
	$this->_headerText = Mage::helper("check")->__("Noncod Manager");
	$this->_addButtonLabel = Mage::helper("check")->__("Add New Item");
	parent::__construct();
	
	}

}