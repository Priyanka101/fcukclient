<?php

class Fcuk_Inwardproduct_Model_Inwardproduct extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('inwardproduct/inwardproduct');
    }
}