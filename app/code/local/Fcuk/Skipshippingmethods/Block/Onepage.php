<?php
class Fcuk_Skipshippingmethods_Block_Onepage extends Mage_Checkout_Block_Onepage
{
protected function _getStepCodes()
{
    
    return array('login', 'billing','shipping', 'payment', 'review');
}
}
?>