<?php

class Fcuk_Shippingvalidation_Model_Mysql4_Shippingvalidation extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the shippingvalidation_id refers to the key field in your database table.
        $this->_init('shippingvalidation/shippingvalidation', 'shippingvalidation_id');
    }
}