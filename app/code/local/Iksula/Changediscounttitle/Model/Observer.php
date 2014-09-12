<?php
class Iksula_Changediscounttitle_Model_Observer{
	public function changeDiscountTitle(Varien_Event_Observer $observer){
		$rule = $observer->getEvent()->getRule();
		$ruleId = $rule->getRuleId();
		if($ruleId == '130'){
			Mage::getSingleton('checkout/session')->setChangetitle($ruleId);
		}else{
			Mage::getSingleton('checkout/session')->unsChangetitle();
		}				
	}		
}
