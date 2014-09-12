<?php
class Iksula_Paymentinfo_Adminhtml_PaymentinfobackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Payment Information"));
	   $this->renderLayout();
    }
}