<?php
class Fcuk_Outwardregister_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/outwardregister?id=15 
    	 *  or
    	 * http://site.com/outwardregister/id/15 	
    	 */
    	/* 
		$outwardregister_id = $this->getRequest()->getParam('id');

  		if($outwardregister_id != null && $outwardregister_id != '')	{
			$outwardregister = Mage::getModel('outwardregister/outwardregister')->load($outwardregister_id)->getData();
		} else {
			$outwardregister = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($outwardregister == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$outwardregisterTable = $resource->getTableName('outwardregister');
			
			$select = $read->select()
			   ->from($outwardregisterTable,array('outwardregister_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$outwardregister = $read->fetchRow($select);
		}
		Mage::register('outwardregister', $outwardregister);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	public function reportoutwardAction(){
		$from = $this->getRequest()->getPost('from');
		$to = $this->getRequest()->getPost('to');
		
		$collections = Mage::getModel('outwardregister/outwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('dc_date', array('from' => $from , 'to' => $to));
		
	
		$j=1;
			
		foreach($collections as $collection){
			
			echo '<div style="margin-top: 25px; width: 100%; float: left;">'.$j.'</div>';
			echo '<div style="float: left; border-right: 1px solid; margin-top: 0px; width: 99%;">';
			
			echo '<div style="font-weight: bold; font-size: 15px; float: left; border-top: 1px solid; border-bottom: 1px solid; width: 100%;">
			<span style="float: left; width: 136px; border-left: 1px solid; border-right: 1px solid; text-align: center;">Transaction Type</span>
			<span style="float: left; width: 102px; border-right: 1px solid; text-align: center;">Chain Store</span>
			<span style="float: left; width: 108px;border-right: 1px solid; text-align: center;">Reason Code</span>
			<span style="float: left; width: 99px;border-right: 1px solid; text-align: center;">Ref dc/no</span>
			<span style="float: left; width: 107px;border-right: 1px solid; text-align: center;">Doc Date</span>
			<span style="float: left; width: 302px;border-right: 1px solid; text-align: center;">Doc Remarks</span>
			<span style="float: left; width: 91px;border-right: 1px solid; text-align: center;">Doc Prefix</span>
			<span style="float: left; width: 102px; text-align: center; border-right: 1px solid;">Doc Number</span>
			<span style="float: left; width: 111px; text-align: center;">Inward Date</span></div>';
			echo '<div style="font-size: 14px; float: left; border-left: 1px solid; padding-top: 15px; border-bottom: 1px solid; width: 100%;">';
			echo '<div style="color:red;">
			<span style="float: left; width: 136px; text-align: center;">'.$collection->getData('transaction_type').'</span>
			<span style="float: left; width: 103px; text-align: center;">'.$collection->getData('chainstore').'</span>
			<span style="float: left; width: 108px; text-align: center;">'.$collection->getData('reasoncode').'</span>
			<span style="float: left; width: 102px; text-align: center;">'.$collection->getData('refdcno').'</span>
			<span style="float: left; width: 106px; text-align: center;">'.$collection->getData('dc_date').'</span>
			<span style="float: left; width: 313px; text-align: center;">'.$collection->getData('doc_remarks').'</span>
			<span style="float: left; width: 95px; text-align: center;">'.$collection->getData('doc_prefix').'</span>
			<span style="float: left; width: 99px;text-align: center;">'.$collection->getData('doc_number').'</span>
			<span style="float: left; width: 103px;text-align: center;">'.date('Y-m-d', strtotime($collection->getData('created_time'))).'</span></div>';
			
			
			
			$product_collections = Mage::getModel('outwardproduct/outwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('outwardregister_id', array('eq' =>$collection->getData('outwardregister_id')));
			$i=1;
			
			echo '<div style="border: 1px solid; margin-bottom: 20px; float: left; margin-top: 25px; width: 67%; margin-left: 91px;">';
			echo '<div style="font-weight: bold; font-size: 13px; width:100%; float:left;  border-bottom: 1px solid;  border-right: 1px solid;">
			<span style="float: left; width: 55px;  border-right: 1px solid; text-align: center;">No</span>
			<span style="float: left; width: 205px; border-right: 1px solid; text-align: center;">Stock No</span>
			<span style="float: left; width: 205px; border-right: 1px solid; text-align: center;">UPC Code</span>
			<span style="float: left; width: 105px;border-right: 1px solid; text-align: center;">Doc Qty</span>
			<span style="float: left; width: 130px;border-right: 1px solid; text-align: center;">Price</span>
			<span style="float: left; width: 138px; text-align: center; ">Net Value</span></div>';
			foreach($product_collections as $product_collection){
			
			echo '<div  style="float:left;width:100%;">
			<span style="float: left; width: 55px; text-align: center;">'.$i.'</span>
			<span style="float: left; width: 205px; text-align: center;">'.$product_collection->getData('itemsku').'</span>
			<span style="float: left; width: 205px; text-align: center;">'.$product_collection->getData('itemdescription').'</span>
			<span style="float: left; width: 105px; text-align: center;">'.$product_collection->getData('qty').'</span>
			<span style="float: left; width: 130px; text-align: center;">'.$product_collection->getData('price').'</span>
			<span style="float: left; width: 138px; text-align: center;">'.$product_collection->getData('total').'</span>
			</div>';
			
			$i++;	
			}
			echo '</div>';
			
			echo '</div>';
			echo '</div>';
			$j++;
			
		}
		
		//echo '<pre>';
		//print_r($collections->getData());
		//<span style="float: left; width: 381px;border-right: 1px solid; text-align: center;">Item Description</span>
		//<span style="float: left; width: 381px; text-align: center;">'.$product_collection->getData('itemdescription').'</span>
		exit;
		
	}
	
	public function reportoutwardnumberAction(){
		
		$from = $this->getRequest()->getPost('fromno');
		$to = $this->getRequest()->getPost('tono');
		
		$collections = Mage::getModel('outwardregister/outwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('doc_number', array('from' => $from , 'to' => $to));
		
		
		$j=1;
		foreach($collections as $collection){
			echo '<div style="margin-top: 25px; width: 100%; float: left;">'.$j.'</div>';
			echo '<div style="float: left; border-right: 1px solid; margin-top: 0px; width: 99%;">';
			
			echo '<div style="font-weight: bold; font-size: 15px; float: left; border-top: 1px solid; border-bottom: 1px solid; width: 100%;">
			<span style="float: left; width: 136px; border-left: 1px solid; border-right: 1px solid; text-align: center;">Transaction Type</span>
			<span style="float: left; width: 102px; border-right: 1px solid; text-align: center;">Chain Store</span>
			<span style="float: left; width: 108px;border-right: 1px solid; text-align: center;">Reason Code</span>
			<span style="float: left; width: 99px;border-right: 1px solid; text-align: center;">Ref dc/no</span>
			<span style="float: left; width: 107px;border-right: 1px solid; text-align: center;">Doc Date</span>
			<span style="float: left; width: 302px;border-right: 1px solid; text-align: center;">Doc Remarks</span>
			<span style="float: left; width: 91px;border-right: 1px solid; text-align: center;">Doc Prefix</span>
			<span style="float: left; width: 102px; text-align: center; border-right: 1px solid;">Doc Number</span>
			<span style="float: left; width: 111px; text-align: center;">Inward Date</span></div>';
			echo '<div style="font-size: 14px; float: left; border-left: 1px solid; padding-top: 15px; border-bottom: 1px solid; width: 100%;">';
			echo '<div style="color:red;">
			<span style="float: left; width: 136px; text-align: center;">'.$collection->getData('transaction_type').'</span>
			<span style="float: left; width: 103px; text-align: center;">'.$collection->getData('chainstore').'</span>
			<span style="float: left; width: 108px; text-align: center;">'.$collection->getData('reasoncode').'</span>
			<span style="float: left; width: 102px; text-align: center;">'.$collection->getData('refdcno').'</span>
			<span style="float: left; width: 106px; text-align: center;">'.$collection->getData('dc_date').'</span>
			<span style="float: left; width: 313px; text-align: center;">'.$collection->getData('doc_remarks').'</span>
			<span style="float: left; width: 95px; text-align: center;">'.$collection->getData('doc_prefix').'</span>
			<span style="float: left; width: 99px;text-align: center;">'.$collection->getData('doc_number').'</span>
			<span style="float: left; width: 103px;text-align: center;">'.date('Y-m-d', strtotime($collection->getData('created_time'))).'</span></div>';
			
			$product_collections = Mage::getModel('outwardproduct/outwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('outwardregister_id', array('eq' => $collection->getData('outwardregister_id')));
			$i=1;
			echo '<div style="border: 1px solid; margin-bottom: 20px; float: left; margin-top: 25px; width: 67%; margin-left: 91px;">';
			echo '<div style="font-weight: bold; font-size: 13px; width:100%; float:left;  border-bottom: 1px solid;  border-right: 1px solid;">
			<span style="float: left; width: 55px;  border-right: 1px solid; text-align: center;">No</span>
			<span style="float: left; width: 205px; border-right: 1px solid; text-align: center;">Stock No</span>
			<span style="float: left; width: 205px; border-right: 1px solid; text-align: center;">UPC Code</span>
			<span style="float: left; width: 105px;border-right: 1px solid; text-align: center;">Doc Qty</span>
			<span style="float: left; width: 130px;border-right: 1px solid; text-align: center;">Price</span>
			<span style="float: left; width: 138px; text-align: center; ">Net Value</span></div>';
			foreach($product_collections as $product_collection){
			
			echo '<div  style="float:left;width:100%;">
			<span style="float: left; width: 55px; text-align: center;">'.$i.'</span>
			<span style="float: left; width: 205px; text-align: center;">'.$product_collection->getData('itemsku').'</span>
			<span style="float: left; width: 205px; text-align: center;">'.$product_collection->getData('itemdescription').'</span>
			<span style="float: left; width: 105px; text-align: center;">'.$product_collection->getData('qty').'</span>
			<span style="float: left; width: 130px; text-align: center;">'.$product_collection->getData('price').'</span>
			<span style="float: left; width: 138px; text-align: center;">'.$product_collection->getData('total').'</span>
			</div>';
			
			$i++;	
			}
			echo '</div>';
			
			echo '</div>';
			echo '</div>';
			$j++;
		}
		
		//echo '<pre>';
		//print_r($collections->getData());
		exit;
		
	
		
	}
}