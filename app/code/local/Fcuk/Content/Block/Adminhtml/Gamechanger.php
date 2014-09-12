<?php


class Fcuk_Content_Block_Adminhtml_Gamechanger extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_gamechanger";
	$this->_blockGroup = "content";
	$this->_headerText = Mage::helper("content")->__("Gamechanger Manager");
	$this->_addButtonLabel = Mage::helper("content")->__("Add New Item");
	parent::__construct();
	
	}

}