<?php
class Fcuk_Shippingvalidation_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/shippingvalidation?id=15 
    	 *  or
    	 * http://site.com/shippingvalidation/id/15 	
    	 */
    	/* 
		$shippingvalidation_id = $this->getRequest()->getParam('id');

  		if($shippingvalidation_id != null && $shippingvalidation_id != '')	{
			$shippingvalidation = Mage::getModel('shippingvalidation/shippingvalidation')->load($shippingvalidation_id)->getData();
		} else {
			$shippingvalidation = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($shippingvalidation == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$shippingvalidationTable = $resource->getTableName('shippingvalidation');
			
			$select = $read->select()
			   ->from($shippingvalidationTable,array('shippingvalidation_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$shippingvalidation = $read->fetchRow($select);
		}
		Mage::register('shippingvalidation', $shippingvalidation);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}