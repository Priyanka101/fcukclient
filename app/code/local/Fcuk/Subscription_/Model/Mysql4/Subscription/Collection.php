<?php
    class Fcuk_Subscription_Model_Mysql4_Subscription_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
    {

		public function _construct(){
			$this->_init("subscription/subscription");
		}
    }
	 