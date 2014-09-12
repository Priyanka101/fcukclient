<?php

class Fcuk_Inwardproduct_Model_Mysql4_Inwardproduct_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('inwardproduct/inwardproduct');
    }
}