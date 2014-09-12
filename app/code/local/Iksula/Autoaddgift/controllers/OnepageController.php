<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';

class Iksula_Autoaddgift_OnepageController extends Mage_Checkout_OnepageController{

	public function savePaymentAction(){
		echo 654321;exit;
		parent::savePaymentAction();
	}
}