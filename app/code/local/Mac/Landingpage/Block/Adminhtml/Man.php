<?php


class Mac_Landingpage_Block_Adminhtml_Man extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_man";
	$this->_blockGroup = "landingpage";
	$this->_headerText = Mage::helper("landingpage")->__("Man Manager");
	$this->_addButtonLabel = Mage::helper("landingpage")->__("Add New Item");
	parent::__construct();
	
	}

}