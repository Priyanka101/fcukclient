<?php

class Fcuk_Outwardregister_Model_Mysql4_Outwardregister extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the outwardregister_id refers to the key field in your database table.
        $this->_init('outwardregister/outwardregister', 'outwardregister_id');
    }
}