<?php

class Fcuk_InwardRegister_Model_InwardRegister extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('inwardregister/inwardregister');
    }
}