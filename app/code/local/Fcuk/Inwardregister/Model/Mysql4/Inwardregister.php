<?php

class Fcuk_Inwardregister_Model_Mysql4_Inwardregister extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the inwardregister_id refers to the key field in your database table.
        $this->_init('inwardregister/inwardregister', 'inwardregister_id');
    }
}