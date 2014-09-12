<?php


class Mac_Gamechanger_Block_Adminhtml_Gamechanger extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_gamechanger";
	$this->_blockGroup = "gamechanger";
	$this->_headerText = Mage::helper("gamechanger")->__("Gamechanger Manager");
	$this->_addButtonLabel = Mage::helper("gamechanger")->__("Add New Item");
	parent::__construct();
	
	}

}