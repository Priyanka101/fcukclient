<?php
/**
 * NOTICE OF LICENSE
 *
 * The MIT License
 *
 * Copyright (c) 2009 S. Landsbek (slandsbek@gmail.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    SLandsbek_SimpleOrderExport
 * @copyright  Copyright (c) 2009 S. Landsbek (slandsbek@gmail.com)
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

/**
 * Controller handling order export requests.
 */

class SLandsbek_SimpleOrderExport_Export_OrderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Exports orders defined by id in post param "order_ids" to csv and offers file directly for download
     * when finished.
     */
    public function csvExportAction()
    {   
        $orders = $this->getRequest()->getPost('order_ids', array());
        if(empty($orders) || (isset($orders[0]) && empty($orders[0]))) {
            Mage::getSingleton('adminhtml/session')->addError("Please select some order");
            $this->_redirectReferer();
            return;
        }
        $file = Mage::getModel('slandsbek_simpleorderexport/export_csv')->exportOrders($orders);
        $this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export').'/'.$file));

    }
	
	public function softcopycsvexportAction()
	{
		$orders = $this->getRequest()->getPost('order_ids', array());
        if(empty($orders) || (isset($orders[0]) && empty($orders[0]))) {
            Mage::getSingleton('adminhtml/session')->addError("Please select some order");
            $this->_redirectReferer();
            return;
        }
        $file = Mage::getModel('slandsbek_simpleorderexport/export_softcopy')->exportOrders($orders);
        $this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export').'/'.$file));
	}
	
	public function assingTrackingAction()
	{	
		 $orders = $this->getRequest()->getPost();
		 $orders = $this->getRequest()->getPost('order_ids', array());
		 //$trackingnumber = $this->getRequest()->getPost('trackingnumber', array());
		  $trackingnumber = $this->getRequest()->getPost('tracking', array());
		// $trackingcarrier = $this->getRequest()->getPost('trackingcarrier', array());
		 $trackingcarrier = $this->getRequest()->getPost('carrier', array());
		 $tracknumberarray = explode(",",$trackingnumber);
		 $trackcarrierrarray = explode(",",$trackingcarrier);
		 foreach($orders as $order){
			 
		$tracknumber =  $this->valuecheck($order,$tracknumberarray);
		$trackcrair = $this->valuecheck($order,$trackcarrierrarray);
			$write = Mage::getSingleton('core/resource')->getConnection('core_write');
				if($tracknumber != "0" && $trackcrair != "0"){
					date_default_timezone_set('Asia/Kolkata');
					$date = date('Y/m/d H:i:s');
					$current_time = gmdate("H:i:s",time());
					//echo gmdate("H:i:s",time());exit;
					$write->query("insert into order_ship_track values (".$order.",'".$trackcrair."','".$tracknumber."','".$date."','".$current_time."')");
					$write->query("update shiptrack set status ='1' , temp_status = 0 where awbnumber = '".$tracknumber."' and carrier = '".$trackcrair."'");
				}

			
			 }
		 
		// print_r($tracknumberarray);
		 //print_r($trackcarrierrarray); 
		
		 $this->_redirectReferer();
            return;
		
	}
	
	protected function valuecheck($order,$array){
		
		$mainvalue = 0;
		for($i = 0 ; $i<count($array);$i++)
		{
			$value = explode("|",$array[$i]);	
			if($value[0]==$order){
				$mainvalue =  $value[1];
			}
		}
		
		return $mainvalue;
		
	}
	
	 /**
    * Orders grid
     */
    public function indexAction()
    {

		/* echo "Girish Patel";
		exit; */
		$this->_title($this->__('Sales'))->_title($this->__('Orders'));

        $this->_initAction()
            ->renderLayout();
    }
	 public function deleteorderAction()
    { 
/* 	echo "hello";
	exit;
		 */
		$orderIds = $this->getRequest()->getPost('order_ids');
        $flag = false;
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');	
		$query="show tables";
		$rsc_table=$write->fetchCol($query);	
		
		$table_sales_flat_order = Mage::getSingleton('core/resource')->getTableName('sales_flat_order');						
		$table_sales_flat_creditmemo_comment= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_comment');
		$table_sales_flat_creditmemo_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_item');
		$table_sales_flat_creditmemo= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo');
		$table_sales_flat_creditmemo_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_creditmemo_grid');
		$table_sales_flat_invoice_comment= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_comment');
		$table_sales_flat_invoice_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_item');
		$table_sales_flat_invoice= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice');
		$table_sales_flat_invoice_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_invoice_grid');
		$table_sales_flat_quote_address_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_address_item');
		$table_sales_flat_quote_item_option= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_item_option');
		$table_sales_flat_quote= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote');
		$table_sales_flat_quote_address= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_address');
		$table_sales_flat_quote_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_item');
		$table_sales_flat_quote_payment= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_payment');
		$table_sales_flat_shipment_comment= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_comment');
		$table_sales_flat_shipment_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_item');
		$table_sales_flat_shipment_track= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_track');
		$table_sales_flat_shipment= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment');
		$table_sales_flat_shipment_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_shipment_grid');		
		$table_sales_flat_order_address= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_address');
		$table_sales_flat_order_item= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_item');
		$table_sales_flat_order_payment= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_payment');
		$table_sales_flat_order_status_history= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_status_history');					
		$table_sales_flat_order_grid= Mage::getSingleton('core/resource')->getTableName('sales_flat_order_grid');						
		$table_log_quote= Mage::getSingleton('core/resource')->getTableName('log_quote');				
        $quoteId='';		
		if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {
					$query=null;
					$order = Mage::getModel('sales/order')->load($orderId);					
					if($order->increment_id){
						/*$query="show tables like 'sales_flat_order'";
						$rs=$write->fetchAll($query);*/						
						$incId=$order->increment_id;
						if(in_array($table_sales_flat_order,$rsc_table)){
							$query='SELECT entity_id   FROM  '.$table_sales_flat_order.'    WHERE increment_id="'.mysql_escape_string($incId).'"';
							
							$rs=$write->fetchAll($query);												
						
							$query='SELECT quote_id    FROM   '.$table_sales_flat_order.'        WHERE entity_id="'.mysql_escape_string($orderId).'"';
							$rs1=$write->fetchAll($query);
							$quoteId=$rs1[0]['quote_id'];							
						}		
						
						$query='SET FOREIGN_KEY_CHECKS=1';
						$rs3=$write->query($query);
						//print_r($rsc_table);
						//echo $table_sales_flat_creditmemo_comment;
						if(in_array($table_sales_flat_creditmemo_comment,$rsc_table)){
						//echo "DELETE FROM ".$table_sales_flat_creditmemo_comment."    WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_creditmemo." WHERE order_id=".$orderId.")";
						//die;
						$write->query("DELETE FROM ".$table_sales_flat_creditmemo_comment."    WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_escape_string($orderId)."')");
						}
						//die;
						
						
						if(in_array('sales_flat_creditmemo_item',$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_creditmemo_item."       WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_creditmemo." WHERE order_id='".mysql_escape_string($orderId)."')");
						}
						
						
						if(in_array($table_sales_flat_creditmemo,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_creditmemo."            WHERE order_id='".mysql_escape_string($orderId)."'");
						}
						
						
						
						if(in_array($table_sales_flat_creditmemo_grid,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_creditmemo_grid."        WHERE order_id='".mysql_escape_string($orderId)."'");
						}
						
						
						if(in_array($table_sales_flat_invoice_comment,$rsc_table)){
						
						$write->query("DELETE FROM ".$table_sales_flat_invoice_comment." WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_escape_string($orderId)."')");
						}
						
						if(in_array($table_sales_flat_invoice_item,$rsc_table)){
						
						$write->query("DELETE FROM ".$table_sales_flat_invoice_item."     WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_invoice." WHERE order_id='".mysql_escape_string($orderId)."')");
						}
						
						
						if(in_array($table_sales_flat_invoice,$rsc_table)){
						
						$write->query("DELETE FROM ".$table_sales_flat_invoice."         WHERE order_id='".mysql_escape_string($orderId)."'");
						}
						
						if(in_array($table_sales_flat_invoice_grid,$rsc_table)){
						
						$write->query("DELETE FROM ".$table_sales_flat_invoice_grid."     WHERE order_id='".mysql_escape_string($orderId)."'");
						}	
						
						if($quoteId){						
							if(in_array($table_sales_flat_quote_address_item,$rsc_table)){							
							$write->query("DELETE FROM ".$table_sales_flat_quote_address_item."     WHERE parent_item_id  IN (SELECT address_id FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId.")");
							}
							
							$table_sales_flat_quote_shipping_rate= Mage::getSingleton('core/resource')->getTableName('sales_flat_quote_shipping_rate');
							if(in_array($table_sales_flat_quote_shipping_rate,$rsc_table)){
							$write->query("DELETE FROM ".$table_sales_flat_quote_shipping_rate."    WHERE address_id IN (SELECT address_id FROM ".$table_sales_flat_quote_address." WHERE quote_id=".$quoteId.")");
							}
							
							if(in_array($table_sales_flat_quote_item_option,$rsc_table)){
							$write->query("DELETE FROM ".$table_sales_flat_quote_item_option."     WHERE item_id IN (SELECT item_id FROM ".$table_sales_flat_quote_item." WHERE quote_id=".$quoteId.")");
							}
						
							
							if(in_array($table_sales_flat_quote,$rsc_table)){
							$write->query("DELETE FROM ".$table_sales_flat_quote."                 WHERE entity_id=".$quoteId);
							}
							
							if(in_array($table_sales_flat_quote_address,$rsc_table)){
							$write->query("DELETE FROM ".$table_sales_flat_quote_address."         WHERE quote_id=".$quoteId);
							}
							
							if(in_array($table_sales_flat_quote_item,$rsc_table)){
							$write->query("DELETE FROM ".$table_sales_flat_quote_item."             WHERE quote_id=".$quoteId);
							}
							
							if(in_array('sales_flat_quote_payment',$rsc_table)){
							$write->query("DELETE FROM ".$table_sales_flat_quote_payment."         WHERE quote_id=".$quoteId);
							}
							
						}
						
						
						if(in_array($table_sales_flat_shipment_comment,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_shipment_comment."    WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_escape_string($orderId)."')");
						}
						
						if(in_array($table_sales_flat_shipment_item,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_shipment_item."         WHERE parent_id IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_escape_string($orderId)."')");
						}
						
						
						if(in_array($table_sales_flat_shipment_track,$rsc_table)){						
						$write->query("DELETE FROM ".$table_sales_flat_shipment_track."         WHERE order_id  IN (SELECT entity_id FROM ".$table_sales_flat_shipment." WHERE order_id='".mysql_escape_string($orderId)."')");
						}
						
						
						if(in_array($table_sales_flat_shipment,$rsc_table)){
						
						$write->query("DELETE FROM ".$table_sales_flat_shipment."             WHERE order_id='".mysql_escape_string($orderId)."'");
						}
						
						
						if(in_array($table_sales_flat_shipment_grid,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_shipment_grid."         WHERE order_id='".mysql_escape_string($orderId)."'");
						}
						
						if(in_array($table_sales_flat_order,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_order."                     WHERE entity_id='".mysql_escape_string($orderId)."'");
						}
						
						if(in_array($table_sales_flat_order_address,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_order_address."            WHERE parent_id='".mysql_escape_string($orderId)."'");
						}
						
						if(in_array($table_sales_flat_order_item,$rsc_table)){						
						$write->query("DELETE FROM ".$table_sales_flat_order_item."                 WHERE order_id='".mysql_escape_string($orderId)."'");
						}
						if(in_array($table_sales_flat_order_payment,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_order_payment."             WHERE parent_id='".mysql_escape_string($orderId)."'");
						}
						if(in_array($table_sales_flat_order_status_history,$rsc_table)){
						$write->query("DELETE FROM ".$table_sales_flat_order_status_history."     WHERE parent_id='".mysql_escape_string($orderId)."'");
						}
						if($incId&&in_array($table_sales_flat_order_grid,$rsc_table)){						
							$write->query("DELETE FROM ".$table_sales_flat_order_grid."                 WHERE increment_id='".mysql_escape_string($incId)."'");
	
						}
						
						$query="show tables like '%".$table_log_quote."'";
						$rsc_table_l=$write->fetchCol($query);	
						if($quoteId&&$rsc_table_l){						
								$write->query("DELETE FROM ".$table_log_quote." WHERE quote_id=".$quoteId);							
						}
						$write->query("SET FOREIGN_KEY_CHECKS=1");						
					}					
			}	
		$this->_getSession()->addSuccess($this->__('Order(s) deleted.'));
		}else{
		$this->_getSession()->addError($this->__('Order(s) error.'));
		}		
		//$this->_redirect('*/*/');	
		$this->_redirect('adminhtml/sales_order/index');	
    }
	
	public function manifestPdfAction(){
		require_once('Tcpdf/config/lang/eng.php');
require_once('Tcpdf/tcpdf.php');

include_once 'app/code/core/Mage/Sales/Model/Order/Pdf/Shipment.php';
		$orderIds = $this->getRequest()->getPost('order_ids');
		$service_provider = '';
		foreach ($orderIds as $orderId) {
					$ordernew = Mage::getModel('sales/order')->load($orderId);
					$track_info = $ordernew->getTracksCollection()->getData();
					$service_provider = $track_info[0]['title'];
					break;
		}
		$date = date('d-m-Y', time());
		
		$HTML='<table>
				<tr style="font-size:40px;font-weight:bold"><td style="text-align:center"><strong>Manifest Report</strong></td></tr><tr><td>&nbsp;</td></tr>';
				$HTML.='<tr><td> Date : &nbsp;&nbsp;'.$date.'</td></tr><tr><td> Service Provider : &nbsp;&nbsp;'.$service_provider.'</td></tr><tr><td>&nbsp;</td></tr></table>';
		$HTML.='<table border="1" >
		<tr align="center" valign="middle">
		 						<td width="35px">Sr No</td>
								<td width="70px">Airway Bill Number</td>
								<td width="70px">Order Number</td>
								<td width="80px">Ship to name</td>
								<td width="80px">City / State </td>
								<td width="80px">Product details</td>
								<td width="45px">Weight</td>
								<td width="45px">Price </td> 
								<td width="60px">COD / PREPAID</td> 
								<td align="left" width="170px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Barcode awb number</td>
		 					</tr>';/*<td width="40px">Courier Name </td>
								<td width="60px">Date</td><td width="80px">Address</td>*/
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false ,false ,false);//last parameter for  footer  if true then footer show. if false then footer not show
		
		
		//$pdf->CheckFooter(1);

		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		
		//$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('Shipment');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		// $img_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/fcuk/default/images/logo_email.gif";
		$img_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/fcuk/default/images/french_connection_pdf_logo.png";
		//echo $img_url;exit;
		$pdf->SetHeaderData($img_url, PDF_HEADER_LOGO_WIDTH);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
		//set margins
		$pdf->SetMargins(2,20,2,TRUE);
		
		//set auto page breaks
		
		$pdf->SetAutoPageBreak(TRUE, 15);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);
			
		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 20);

		// add a page



		//$pdf->writeHTML(PDF_HEADER_STRING, true, false, true, false, '');
		$pdf->SetFont('helvetica', '', 8);
		$pdf->AddPage();
		$i=0;
		foreach ($orderIds as $orderId) {
			$i++;
					$order = Mage::getModel('sales/order')->load($orderId);
					$track_info = $order->getTracksCollection()->getData();
					
					$tracknumbar = $track_info[0]['track_number'];
					$tracktitle = $track_info[0]['title'];
					
					 $payment = $order->getPayment();
    				 $payment_method = $payment->getData('method');
					 $cod_noncod = "PREPAID";
					 if($payment_method=="cashondelivery")
					 	$cod_noncod = "COD";
					//$date =$order->getData('created_at');
					//$date = strptime($date, '%Y-%m-%d');
					//$date = date("Y-m-d", strtotime($date));
					
					$order_no = $order->getData('increment_id');
					 $shippingId = $order->getShippingAddress()->getId();
					 $address = Mage::getModel('sales/order_address')->load($shippingId);
					 $ship_to_name = $address->getData('firstname')." ".$address->getData('lastname');
					
					$street = $address->getData('street');
					$city_state = $address->getData('city')." / ".$address->getData('region');
					
					 $items = $order->getAllItems();
					 

					 $itemname = '';
					
					  foreach ($items as $itemId => $item)
                        {
							if($item->getName()!=''){
								$itemname .= $item->getName()." , ";
							}
                         /*  $name[] = $item->getName();
                           $unitPrice[]=$item->getPrice();
                           $sku[]=$item->getSku();
                           $ids[]=$item->getProductId();
                           $qty[]=$item->getQtyToInvoice();*/
                        }
				//echo $itemname;
				//exit;
				$itemname = substr($itemname, 0, -2);	
				$weight = 	$order->getData('weight');
				$price = $order->getData('base_grand_total');
				
				
				$parts = str_split($tracknumbar);

				$first_num = -1;
				$num_loc = 0;
				foreach ($parts AS $a_char) {
					if (is_numeric($a_char)) {
						$first_num = $num_loc;
						break;
					}
					$num_loc++;
				}
				//$barcode = "*".trim(substr($track_number,$num_loc))."*";
				$barcode = trim(substr($tracknumbar,$num_loc));
				
				/*
				if( strtolower($tracktitle) == "bluedart"){
				$barcode_below = substr($track_number,$num_loc);
				}else{
					$barcode_below = $tracknumbar;
				}*/
				
				$pdf->SetFont('helvetica', '', 8);
				
				$HTML.= '<tr align="center" valign="middle" rowspan="1">
		 						<td width="35px">'.$i.'</td>
								<td width="70px">'.$tracknumbar.'</td>
								<td width="70px">'.$order_no.'</td>
								<td width="80px">'.strtolower($ship_to_name).'</td>
								<td width="80px">'.strtolower($city_state).'</td>
								<td width="80px">'.strtolower($itemname).'</td>
								<td width="45px">'.number_format($weight).'</td>
								<td width="45px">'.number_format($price).'</td>
								<td width="60px">'.$cod_noncod.'</td>';
								/*<td width="40px">'.$tracktitle.'</td>
								<td width="60px">'.$date.'</td><td width="80px">'.strtolower($street).'</td>*/ 
								$path =  Mage::getBaseDir('lib') . DS ."Tcpdf". DS ."fonts".DS."B39MHR.TTF" ;
$fontname = $pdf->addTTFfont($path, "TrueTypeUnicode", "", 96); 
//$pdf->SetFont($fontname, '', 14, '', false);
				$params = $pdf->serializeTCPDFtagParameters(array($barcode, 'C128', '', '', 40, 10, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>0, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>false, 'font'=>$fontname, 'fontsize'=>2, 'stretchtext'=>4), 'N'));
		 						$HTML.='<td width="170px" valign="middle" style="border-spacing:1em;">&nbsp;&nbsp;&nbsp;&nbsp;<tcpdf method="write1DBarcode" params="'.$params.'" /> </td>
		 					</tr>';
		
		}
		$HTML.='</table>';
		$pdf->writeHTML($HTML, true, false, false, false, '');
		$filename = "manifest.pdf";
		$fileName = $filename;
		$pdf->Output($fileName, 'D');
		
		exit;
	}
	
	
	public function dispatchdataexportAction()
	{
		$orders = $this->getRequest()->getPost('order_ids', array());
        if(empty($orders) || (isset($orders[0]) && empty($orders[0]))) {
            Mage::getSingleton('adminhtml/session')->addError("Please select some order");
            $this->_redirectReferer();
            return;
        }
        $file = Mage::getModel('slandsbek_simpleorderexport/export_dispatchdata')->exportOrders($orders);
        $this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export').'/'.$file));
	}
	
	public function discountreportexportAction()
	{
		$orders = $this->getRequest()->getPost('order_ids', array());
        if(empty($orders) || (isset($orders[0]) && empty($orders[0]))) {
            Mage::getSingleton('adminhtml/session')->addError("Please select some order");
            $this->_redirectReferer();
            return;
        }
        $file = Mage::getModel('slandsbek_simpleorderexport/export_discountreport')->exportOrders($orders);
        $this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export').'/'.$file));
	}
	
	public function pendingreportexportAction()
	{
		$orders = $this->getRequest()->getPost('order_ids', array());
        if(empty($orders) || (isset($orders[0]) && empty($orders[0]))) {
            Mage::getSingleton('adminhtml/session')->addError("Please select some order");
            $this->_redirectReferer();
            return;
        }
        $file = Mage::getModel('slandsbek_simpleorderexport/export_pendingreport')->exportOrders($orders);
        $this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export').'/'.$file));
	}
	
	public function salesreportexportAction()
	{
		$orders = $this->getRequest()->getPost('order_ids', array());
        if(empty($orders) || (isset($orders[0]) && empty($orders[0]))) {
            Mage::getSingleton('adminhtml/session')->addError("Please select some order");
            $this->_redirectReferer();
            return;
        }
        $file = Mage::getModel('slandsbek_simpleorderexport/export_salesreport')->exportOrders($orders);
        $this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export').'/'.$file));
	}
	
}
?>