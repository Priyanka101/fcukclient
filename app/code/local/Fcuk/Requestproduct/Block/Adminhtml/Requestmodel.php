<?php


class Fcuk_Requestproduct_Block_Adminhtml_Requestmodel extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_requestmodel";
	$this->_blockGroup = "requestproduct";
	$this->_headerText = Mage::helper("requestproduct")->__("Out Of Stock Product Manager");
	$this->_addButtonLabel = Mage::helper("requestproduct")->__("Add New Item");
	parent::__construct();
	
	}

}