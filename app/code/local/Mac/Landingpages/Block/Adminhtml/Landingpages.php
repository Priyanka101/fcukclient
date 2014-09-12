<?php


class Mac_Landingpages_Block_Adminhtml_Landingpages extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_landingpages";
	$this->_blockGroup = "landingpages";
	$this->_headerText = Mage::helper("landingpages")->__("Landingpages Manager");
	$this->_addButtonLabel = Mage::helper("landingpages")->__("Add New Item");
	parent::__construct();
	
	}

}