<?php
/**
 * Magento
 *
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Sales Order Shipment PDF model
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */
  
require_once('Tcpdf/config/lang/eng.php');
require_once('Tcpdf/tcpdf.php');

include_once 'app/code/core/Mage/Sales/Model/Order/Pdf/Shipment.php';

class Iksula_Fcuk_Model_Sales_Order_Pdf_Shipment extends Mage_Sales_Model_Order_Pdf_Shipment
{
    public function getPdf($shipmentsArray = array())
    {
		
		
		
		// create new PDF document
		
		
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
		$pdf->SetMargins(20,20,20,TRUE);
		
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
		
		//$pdf->Write(0, PDF_HEADER_STRING, '', 0, 'L', true, 0, false, false, 0);
		
		// -----------------------------------------------------------------------------
		//print_r($shipmentsArray);exit;
		foreach ($shipmentsArray as $shipments)
		{
			
			//echo '<pre>';print_r($shipments->getCollection()->getData());exit;
			//echo '<pre>';print_r($shipments->getItemsCollection()->getData());exit;
			$totalWeight = 0;
			foreach($shipments->getItemsCollection()->getData() as $itemweight)
			{
				
				  $_newProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$itemweight['sku'])->getData('weight');
				$totalWeight = $totalWeight + $_newProduct;
				//echo '<pre>';print_r($itemweight);
			}
			
			//echo $totalWeight;exit;
			$pdf->AddPage();
				
			//foreach ($shipments as $shipment) 
			//{
				
			//if ($shipment->getStoreId()) {
					//Mage::app()->getLocale()->emulate($shipment->getStoreId());
					//Mage::app()->setCurrentStore($shipment->getStoreId());
				//}
				
				$order = $shipments->getOrder();
				$invoice_no = '&nbsp;';
				$invoice_Date = '&nbsp;';
				//echo '<pre>';print_r($order->getInvoiceCollection()->getData());exit;
				if ($order->hasInvoices()) {
					
    // "$_eachInvoice" is each of the Invoice object of the order "$order"
    foreach ($order->getInvoiceCollection() as $_eachInvoice) {
	//echo '<pre>';print_r($_eachInvoice->getData());
		$invoice_no = $_eachInvoice->getData('increment_id');
		$invoice_Date =date('d/m/Y', time($_eachInvoice->getData('created_at')));
       
    }
}
				
				
				$order_date = date('d/m/Y', time($order->getData('created_at')));
				
				
				//echo '<pre>';
				//print_r($shipment->getTracksCollection()->getData());	
				//print_r(get_class_methods($shipment));exit;
				
				$trackArr = $shipments->getTracksCollection()->getData();
				//$carrier_code = $trackArr[0]['carrier_code'];
				$track_title = $trackArr[0]['title']; 
				$track_number = $trackArr[0]['track_number']; 
				
				$shippingAdd 		= $shipments->getShippingAddress()->getData();
				$c_name 				= $shippingAdd['firstname'].' '.$shippingAdd['lastname'];
				$filename = $shippingAdd['firstname'].$shippingAdd['lastname'];
				$street 					= $shippingAdd['street'];
				$city 						= $shippingAdd['city'];
				$postcode 			= $shippingAdd['postcode'];
				$region 					= $shippingAdd['region'];
				$telephone			= $shippingAdd['telephone'];
				$fax				= $shippingAdd['fax'];
				$address = Mage::getModel('customer/address')->load($shippingAdd['customer_address_id']);
				$landmark_shipping		= $address->getData('landmark');
				$landline_shipping		= $address->getData('telephonetwo');
				$shippingNo 			= $shipments->getIncrementId();	
				
				$orderId 				= $order->getData('increment_id');
				 $threechar = '';
				//$params = $pdf->serializeTCPDFtagParameters(array($orderId, 'EAN13', '', '', 0, 0, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>0, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>false, 'font'=>'helvetica', 'fontsize'=>5, 'stretchtext'=>1), 'N'));
				
				$parts = str_split($track_number);

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
				$barcode = trim(substr($track_number,$num_loc));
				if( strtolower($track_title) == "bluedart"){
				$barcode_below = substr($track_number,$num_loc);
				}else{
					$barcode_below = $track_number;
				}
				
			//	echo $barcode;
				//exit;

// use the font
//$pdf->SetFont('B39MHRNEW', '', 14, '', false);
$path =  Mage::getBaseDir('lib') . DS ."Tcpdf". DS ."fonts".DS."B39MHR.TTF" ;
$fontname = $pdf->addTTFfont($path, "TrueTypeUnicode", "", 96); 
$pdf->SetFont($fontname, '', 14, '', false);
 
				$params = $pdf->serializeTCPDFtagParameters(array($barcode, 'C128', '', '', 40, 10, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>0, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>false, 'font'=>$fontname, 'fontsize'=>2, 'stretchtext'=>4), 'N'));
				$shippingDate 		= date('d/m/Y', $shipments->getCreatedAtDate()->getTimestamp());
				
				$paymentMethod = $order->getPayment()->getMethodInstance()->getTitle();
				$grandTotal 			= number_format($order->getData('base_grand_total'));
				$shipping			=$order->getData('shipping_description');//dispatch
				$shipping_amount			=$order->getData('shipping_amount');
				$grandTotal 			= number_format($order->getData('base_grand_total'));//total value
				 $img_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/fcuk/default/images/logo_email.gif";
				 $ShippingMethod = $order->getShippingDescription();
				$shipmentCollection = Mage::getResourceModel('sales/order_shipment_collection')
            		->setOrderFilter($order)
        			->load();
					$pdf->SetFont('helvetica', '', 8);
					
       			 foreach ($shipmentCollection as $shipment){
            // This will give me the shipment IncrementId, but not the actual tracking information.
					foreach($shipment->getAllTracks() as $tracknum)
					{
						$tracknums[]=$tracknum->getNumber();
					}

       			 }
				 	
				 	//echo "<pre>";
					//print_r($tracknums);
					//exit();
				 if($paymentMethod  == "Cash On Delivery")
					{
					 $paymentType = $paymentMethod ;
					 
					
						if( strtolower($track_title) == "bluedart"){
					// $cod_model_data = Mage::getModel('check/cod')->load($postcode, 'pincode')->getData();
					 $cod_model_data = Mage::getModel('check/cod')->getCollection()
											->addFieldToFilter('pincode', $postcode)
											->addFieldToFilter('carrier', strtolower($track_title))
											->getData();
					 $carea = $cod_model_data[0]['carea'];
					 $cscrcd = $cod_model_data[0]['cscrcd'];
					 
					
					 $threechar = '&nbsp; - &nbsp; <strong>'.$carea.' / '.$cscrcd.'</strong>';
						}
					 
					}
					else
					{
						$paymentType = "PREPAID ORDER" ;
						//$noncod_model_data = Mage::getModel('check/noncod')->load($postcode, 'pincode')->getData();
						
						if( strtolower($track_title) == "bluedart"){
						
						$noncod_model_data = Mage::getModel('check/noncod')->getCollection()
											->addFieldToFilter('pincode', $postcode)
											->addFieldToFilter('carrier', strtolower($track_title))
											->getData();
					 	$carea = $noncod_model_data[0]['carea'];
					 	$cscrcd = $noncod_model_data[0]['cscrcd'];
						$threechar = '&nbsp; - &nbsp; <strong>'.$carea.' / '.$cscrcd.'</strong>';
						}
						
					 
					}
					
				// -----------------------------------------------------------------------------
    //echo "<pre>";print_r($shipping_amount);exit;
	
	//'<tr><td colspan="2"><table><tr><img src="'.$img_url.'" width="250" height="35"></tr></table></td></tr><tr>    	<td>        &nbsp;        </td></tr>';
	
	/*
	
	<tr>
    	<td >
			DELIVER TO:<br />
			'.$c_name.'<br />
			'.$street.'<br />
			'.$city.'<br />
			'.$region.'<br />
			'.$postcode.'<br />
			Phone Number:'.$telephone.'
		</td>
		<td>
			'.Mage::getModel('core/variable')->loadByCode('warehouse_address')->getValue('html').'
		</td>
    </tr>
	
	*/ 
	
	
				$HTML = '<table >
				<tr style="font-size:100px;font-weight:bold"><td colspan="2" style="text-align:center"><strong>French Connection</strong></td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr style="font-size:40px;"><td colspan="2" style="text-align:center"><strong>Brand Retail Private Limited</strong></td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr style="font-size:30px;">';
				if($paymentMethod=="Cash On Delivery"){
				$HTML .='<td width="30%">COD</td><td style="text-align: right;" width="70%">COLLECT CASH ONLY RS '.$grandTotal .'/-</td>';
				}
				else{
				//$HTML .='<td colspan="2">'.$paymentMethod.'</td>';
					$HTML .='<td colspan="2">PAID</td>';
				}
				$HTML .='</tr>
				
		 <tr><td width="64%">&nbsp;</td><td width="36%">AWB NO <br /><tcpdf method="write1DBarcode" params="'.$params.'" />'.$barcode_below.'</td></tr>
	
	<tr>
		<td colspan="2">
			<table style="font-size:30px;"><tr>
						<td style="width:25%;">Order Number</td>
						<td style="width:40%;">'.$orderId.'</td>
						<td>Service Provider: '.$track_title.'</td>
					</tr>
					
					<tr>
						<td style="width:25%;">Order Date</td>
						<td style="width:40%;">'.$order_date.'</td>
						<td>AWB No: '.$track_number.'</td>
					</tr>
					
					<tr>
						<td style="width:25%;">Invoice Number</td>
						<td style="width:40%;">'.$invoice_no.'</td>
						<td>CST No: 27740861481C</td>
					</tr>
					
					<tr>
						<td style="width:25%;">Invoice Date</td>
						<td style="width:40%;">'.$invoice_Date.'</td>
						<td>VAT No: 27740861481V</td>
						
					</tr>
					
					<tr>
						<td style="width:25%;">Shipment Number</td>
						<td style="width:40%;">'.$shippingNo.'</td>
						<td>CIN No: U54131MH2005PTC157347</td>
					</tr>
					
					
					<tr>
						<td style="width:25%;">Shipment Weight</td>
						<td style="width:40%;">'.$totalWeight.' gms</td>
						<td>&nbsp;</td>
					</tr>
					
					<tr><td colspan="2">&nbsp;</td></tr>
			</table>
		</td>
	</tr>
	
	
	<tr>
    	<td colspan="2">
        &nbsp;
        </td>
    </tr>
    <tr>
    	<td colspan="2" style="font-size:30px;">
		Ship To<br />
			'.$c_name.'<br />
			'.$street.'<br />
			'.$city.'-'.$postcode.$threechar.'<br />
			Mobile Number:'.$telephone.',
			Landmark: '.$landmark_shipping.'<br />
			
        </td>
        
    </tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td style="width:100%"><strong>Return Address </strong>:Brand Retail Pvt Ltd. C/o FedEx Express Transportation and Supply Chain Services (India) Private Limited,<br/>
	Next to NDR Warehousing,Survey No. 95 A , Hissa No. 5 , Mumbai Nasik Highway, Near Sai Dhaba, Village-Vadape,<br />
	Tal-Bhiwandi, Dist-Thane, Pin Code 421302, Maharashtra, India.<br /></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr align="center" style="text-align:center"><td><strong>Free Shipping | 30 Days Returns | Cash On Delivery</strong></td></tr>
	</table>';	
	/*
	
	 Brand Retail Pvt. Ltd. C/o FedEx Express Transportation and Supply Chain Services (India) Private Limited, Next to NDR Warehousing , Survey No. 95 A , Hissa No. 5 , Mumbai Nasik Highway, Near Sai Dhaba, Village-Vadape,Tal-Bhiwandi, Dist-Thane, Pin Code 421302, Maharashtra, India.
	<tr><td style="width:100%" >Please feel free to call customer care 1800 22 8288 or email customercare@frenchconnection.in</td></tr>
	<tr><td>Returned Address : Brand Retail PVT LTD , C/o FEDEX Express Transportation and Supply Chain Services (India) Private Limited,</td></tr>
	<tr><td>Next to NDR Warehousing, Survey No.95 a, Hissa No.5, Mumbai Nasik Highway, Near sai Dhaba, village- vadape,</td></tr>
	<tr><td>Tal-Bhiwandi, Dist - Thane , Pin code - 421302</td></tr>
	*/
				
		/*		$HTML .='</table>
        </td>
    </tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
    <tr>
    	<td>
        	   Price Including All taxes
        </td>
        <td>
        	<table height="100px" style="position:relative;left:320px">
            	<tr>
                    <td>
                    Subtotal:
                    </td>
                    <td>
                    Rs. '.number_format($order->getData('subtotal')).'
                    </td>	
                </tr>
               	<tr>
                    <td>
                     Shipping Charges:	
                    </td>
               		<td>
                    Rs. '.number_format($order->getData('shipping_amount')).'	
                    </td>

                </tr>
				<tr>
                    <td>
                     Grand Total:	
                    </td>
               		<td>
                    Rs. '.$grandTotal.'	
                    </td>

                </tr>
            </table>
        </td>
    </tr>
</table>'; */
				// -----------------------------------------------------------------------------

				//Close and output PDF document
				
				//$pdf->Cell(100,100, 'EAN 13', 0, 1);
//$pdf->write1DBarcode('1234567890128', 'EAN13', '', '', '', 18, 0.4, $style, 'N');
				
				$pdf->writeHTML($HTML, true, false, false, false, '');
				

			//}
		}

		//$fileName = 'packagingslip-'.date('d_m_y').'.pdf';
		ob_end_clean();
		$filename = $filename.".pdf";
		$fileName = $filename;
		$pdf->Output($fileName, 'D');

		//============================================================+
		// END OF FILE                                                
		//============================================================+
    }

}
