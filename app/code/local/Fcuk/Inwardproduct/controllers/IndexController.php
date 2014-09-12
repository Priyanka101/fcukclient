<?php
class Fcuk_Inwardproduct_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/inwardproduct?id=15 
    	 *  or
    	 * http://site.com/inwardproduct/id/15 	
    	 */
    	/* 
		$inwardproduct_id = $this->getRequest()->getParam('id');

  		if($inwardproduct_id != null && $inwardproduct_id != '')	{
			$inwardproduct = Mage::getModel('inwardproduct/inwardproduct')->load($inwardproduct_id)->getData();
		} else {
			$inwardproduct = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($inwardproduct == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$inwardproductTable = $resource->getTableName('inwardproduct');
			
			$select = $read->select()
			   ->from($inwardproductTable,array('inwardproduct_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$inwardproduct = $read->fetchRow($select);
		}
		Mage::register('inwardproduct', $inwardproduct);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}