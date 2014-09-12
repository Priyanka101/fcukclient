<?php
/**
 * @copyright  Copyright (c) 2009-2011 Amasty (http://www.amasty.com)
 */ 
class Amasty_Shopby_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
    public function match(Zend_Controller_Request_Http $request) 
    {
        
        if (Mage::app()->getStore()->isAdmin()) {
            return false;
        }
      
      }
}