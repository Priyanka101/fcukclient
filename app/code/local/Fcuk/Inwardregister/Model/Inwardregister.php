<?php

class Fcuk_Inwardregister_Model_Inwardregister extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('inwardregister/inwardregister');
    }
}