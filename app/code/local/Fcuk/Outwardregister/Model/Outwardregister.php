<?php

class Fcuk_Outwardregister_Model_Outwardregister extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('outwardregister/outwardregister');
    }
}