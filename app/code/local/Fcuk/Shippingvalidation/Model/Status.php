<?php

class Fcuk_Shippingvalidation_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('shippingvalidation')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('shippingvalidation')->__('Disabled')
        );
    }
}