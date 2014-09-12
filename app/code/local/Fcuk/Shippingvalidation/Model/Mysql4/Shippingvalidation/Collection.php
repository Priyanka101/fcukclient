<?php

class Fcuk_Shippingvalidation_Model_Mysql4_Shippingvalidation_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('shippingvalidation/shippingvalidation');
    }
}