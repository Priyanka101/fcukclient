<?php
class Fcuk_Subscription_Model_Mysql4_Subscription extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("subscription/subscription", "s_id");
    }
}