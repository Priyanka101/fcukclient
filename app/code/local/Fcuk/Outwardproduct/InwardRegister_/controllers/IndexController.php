<?php
class Fcuk_InwardRegister_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/inwardregister?id=15 
    	 *  or
    	 * http://site.com/inwardregister/id/15 	
    	 */
    	/* 
		$inwardregister_id = $this->getRequest()->getParam('id');

  		if($inwardregister_id != null && $inwardregister_id != '')	{
			$inwardregister = Mage::getModel('inwardregister/inwardregister')->load($inwardregister_id)->getData();
		} else {
			$inwardregister = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($inwardregister == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$inwardregisterTable = $resource->getTableName('inwardregister');
			
			$select = $read->select()
			   ->from($inwardregisterTable,array('inwardregister_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$inwardregister = $read->fetchRow($select);
		}
		Mage::register('inwardregister', $inwardregister);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}