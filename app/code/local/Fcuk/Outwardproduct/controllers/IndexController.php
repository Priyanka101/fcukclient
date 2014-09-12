<?php
class Fcuk_Outwardproduct_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/outwardproduct?id=15 
    	 *  or
    	 * http://site.com/outwardproduct/id/15 	
    	 */
    	/* 
		$outwardproduct_id = $this->getRequest()->getParam('id');

  		if($outwardproduct_id != null && $outwardproduct_id != '')	{
			$outwardproduct = Mage::getModel('outwardproduct/outwardproduct')->load($outwardproduct_id)->getData();
		} else {
			$outwardproduct = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($outwardproduct == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$outwardproductTable = $resource->getTableName('outwardproduct');
			
			$select = $read->select()
			   ->from($outwardproductTable,array('outwardproduct_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$outwardproduct = $read->fetchRow($select);
		}
		Mage::register('outwardproduct', $outwardproduct);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}