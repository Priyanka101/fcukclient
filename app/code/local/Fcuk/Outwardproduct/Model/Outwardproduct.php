<?php

class Fcuk_Outwardproduct_Model_Outwardproduct extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('outwardproduct/outwardproduct');
    }
}