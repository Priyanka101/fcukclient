<?php


class Fcuk_Pressreleases_Block_Adminhtml_Pressreleases extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_pressreleases";
	$this->_blockGroup = "pressreleases";
	$this->_headerText = Mage::helper("pressreleases")->__("Pressreleases Manager");
	$this->_addButtonLabel = Mage::helper("pressreleases")->__("Add New Item");
	parent::__construct();
	
	}

}