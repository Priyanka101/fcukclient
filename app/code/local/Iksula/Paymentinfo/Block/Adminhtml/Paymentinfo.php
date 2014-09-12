<?php


class Iksula_Paymentinfo_Block_Adminhtml_Paymentinfo extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_paymentinfo";
	$this->_blockGroup = "paymentinfo";
	$this->_headerText = Mage::helper("paymentinfo")->__("Paymentinfo Manager");
	$this->_addButtonLabel = Mage::helper("paymentinfo")->__("Add New Item");
	parent::__construct();
	
	}

}