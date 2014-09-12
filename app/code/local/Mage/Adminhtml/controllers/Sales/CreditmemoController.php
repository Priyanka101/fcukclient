<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders controller
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
echo "hi";
exit;
class Mage_Adminhtml_Sales_CreditmemoController extends Mage_Adminhtml_Controller_Sales_Creditmemo
{
    /**
     * Export credit memo grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName   = 'creditmemos.csv';
        $grid       = $this->getLayout()->createBlock('adminhtml/sales_creditmemo_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
	
	public function exportCsvnewAction()
	{
		$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		$collection = Mage::getResourceModel('sales/order_creditmemo_grid_collection');
		//$collection->getSelect()->joinLeft('sales_flat_creditmemo_comment','main_table.entity_id = sales_flat_creditmemo_comment.parent_id ', array('comment'));
		
		//print_r($collection->getData());
		//exit;
		$creditmemo =  array();
		$j=0;
		foreach($collection as $coll){
			$creditmemo[$j]['increment_id'] =$coll->getData('increment_id'); 
			$creditmemo[$j]['created_at'] =$coll->getData('created_at');
			$creditmemo[$j]['order_increment_id'] =$coll->getData('order_increment_id');
			$creditmemo[$j]['order_created_at'] =$coll->getData('order_created_at');
			$creditmemo[$j]['billing_name'] =$coll->getData('billing_name');
			
			$status ='';
			if($coll->getData('state')=="1"){
				$status = "Pending";
			}else if($coll->getData('state')=="2"){
				$status = "Refunded";
			}else if($coll->getData('state')=="3"){
				$status = "Canceled";
			}
			$creditmemo[$j]['creditmemo_status'] =$status;
			$creditmemo[$j]['grand_total'] =$coll->getData('grand_total');
			$comment = '';
			$sql        = "SELECT * FROM sales_flat_creditmemo_comment WHERE parent_id = ".$coll->getData('entity_id');
			$olddata = $connection->fetchAll($sql);
				if(empty($olddata)){
						
				}else{
					$s=1;
						for($i=0;$i<count($olddata);$i++){
							if($olddata[$i]['comment']!=''){
									$comment = $comment ." (".$s.") ". $olddata[$i]['comment'] ."      " ;
									$s++;
							}
						}
				}
		$creditmemo[$j]['comment'] =  $comment;
		$j++;
		}
		for($p=0;$p<count($creditmemo);$p++){
			$data = $data . $creditmemo[$p]['increment_id'].",";
			$data = $data . $creditmemo[$p]['created_at'].",";
			$data = $data . $creditmemo[$p]['order_increment_id'].",";
			$data = $data . $creditmemo[$p]['order_created_at'].",";
			$data = $data . $creditmemo[$p]['billing_name'].",";
			$data = $data . $creditmemo[$p]['creditmemo_status'].",";
			$data = $data . $creditmemo[$p]['grand_total'].",";
			$data = $data . $creditmemo[$p]['comment'].",";
			$data = $data . "\n";
			 
		}
		
		$header = "Credit Memo,Created At,Order,Order Date,Bill to Name,Status,Refunded,Comments";
		 header("Content-Disposition: attachment; filename=creditmemo.csv");
 		header("Pragma: no-cache");
 		header("Expires: 0");
 		print "$header\n$data";
 exit;
		
		
	}
	

    /**
     *  Export credit memo grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName   = 'creditmemos.xml';
        $grid       = $this->getLayout()->createBlock('adminhtml/sales_creditmemo_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    /**
     *  Index page
     */
    public function indexAction() {
        $this->_title($this->__('Sales'))->_title($this->__('Credit Memos'));

        parent::indexAction();
    }
}
