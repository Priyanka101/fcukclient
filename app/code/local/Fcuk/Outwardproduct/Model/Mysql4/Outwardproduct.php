<?php

class Fcuk_Outwardproduct_Model_Mysql4_Outwardproduct extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the outwardproduct_id refers to the key field in your database table.
        $this->_init('outwardproduct/outwardproduct', 'outwardproduct_id');
    }
}