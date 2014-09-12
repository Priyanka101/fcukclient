<?php

class Fcuk_Inwardproduct_Model_Mysql4_Inwardproduct extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the inwardproduct_id refers to the key field in your database table.
        $this->_init('inwardproduct/inwardproduct', 'inwardproduct_id');
    }
}