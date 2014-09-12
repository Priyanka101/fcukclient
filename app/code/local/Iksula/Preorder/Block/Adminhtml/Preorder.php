<?php


class Iksula_Preorder_Block_Adminhtml_Preorder extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_preorder";
	$this->_blockGroup = "preorder";
	$this->_headerText = Mage::helper("preorder")->__("Preorder Manager");
	$this->_addButtonLabel = Mage::helper("preorder")->__("Add New Item");
	parent::__construct();
	
	}

}