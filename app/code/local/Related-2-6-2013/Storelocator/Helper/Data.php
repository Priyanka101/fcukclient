<?php
class Addons_Storelocator_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getUrl()
    {
        $url='storelocator/';
		return Mage::getUrl().$url;
    }
	public function getSession(){
	
	return Mage::getSingleton('core/session');
	}
}