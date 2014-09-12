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
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false ,false ,true);//last parameter for  footer  if true then footer show. if false then footer not show
		
		
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
		foreach ($shipmentsArray as $shipments)
		{
			
			
			$pdf->AddPage();
				
			//foreach ($shipments as $shipment) 
			//{
				
			//if ($shipment->getStoreId()) {
					//Mage::app()->getLocale()->emulate($shipment->getStoreId());
					//Mage::app()->setCurrentStore($shipment->getStoreId());
				//}
				$order = $shipments->getOrder();
				$invoice_no = '&nbsp';
				$invoice_Date = '&nbsp;';
				
				if ($order->hasInvoices()) {
					
    // "$_eachInvoice" is each of the Invoice object of the order "$order"
    foreach ($order->getInvoiceCollection() as $_eachInvoice) {
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
					}
					else
					{
						$paymentType = "PREPAID ORDER" ;
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
				<tr style="font-size:40px;"><td colspan="2" style="text-align:center"><strong>Brand Retail Private Limited</strong></td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr style="font-size:30px;">';
				if($paymentMethod=="Cash On Delivery"){
				$HTML .='<td width="30%">COD</td><td style="text-align: right;" width="70%">COLLECT CASH ONLY RS '.$grandTotal .'/-</td>';
				}
				else{
				$HTML .='<td colspan="2">'.$paymentMethod.'</td>';
					
				}
				$HTML .='</tr>
	
	 <tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
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
			'.$city.'<br />
			'.$region.'<br />
			'.$postcode.'<br />
			Phone Number:'.$telephone.'<br />
			Fax: '.$fax.'<br />
			Landmark: '.$landmark_shipping.'<br />
			Landline: '.$landline_shipping.'<br />
        </td>
        
    </tr>
    
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	
    <tr width="100%">
    	<td colspan="2">
        	<table width="100%">
            	<tr style="text-align:center; font-size:30px;">
                	<td style="text-align:left;" width="10%" valign="bottom"> <strong>Sr No</strong></td>
                    <td width="40%" valign="bottom"><strong>Product</strong></td>
                    <td width="10%"><strong>Qty</strong></td>
					 <td width="20%"><strong>Shipping Amt</strong></td>
                    <td ><strong>Net Value</strong></td>
                </tr>
				<tr style="text-align:center;">
                	<td  colspan="5"></td>
                    
                </tr>
				';

				/* Add body */
				$count = 1;
				foreach ($shipments->getAllItems() as $item){
					if ($item->getOrderItem()->getParentItem()) {
						continue;
					}
					
					
					$itemArr = $item->getData();
					
				    $itemName = $itemArr['name'];
					
				    $qty = number_format($itemArr['qty']);
				    $base_price = number_format($itemArr['price']);
				    $discountAmount = number_format($itemArr['discount_amount']);
				    $price = number_format($itemArr['price'] - $itemArr['discount_amount']);
				    $subtotal = number_format($itemArr['qty']*($itemArr['price'] - $itemArr['discount_amount']));
					
					
				    $sku = $itemArr['sku'];
					
					 $productcode=$itemArr['sku'];//code
					// echo
					    $attr =  Mage::getModel('catalog/product')->loadByAttribute('sku',$productcode);
						
					   $attrValueColor = $attr->getAttributeText('color');
					   
					   $attrValueSize = $attr->getAttributeText('size');
					     
					  // echo $attrValueColor;
					   // echo $attrValueSize;
						//echo $productcode;
					   //exit; 
					   
					 $shipping_amount = number_format($shipping_amount);
				   
				    $HTML .='<tr style="text-align:center;font-size:30px;" ><td style="text-align:left;"> '.$count.'</td><td> '.$itemName.' </td><td>'.$qty.'</td><td>'.$shipping_amount.'</td><td>'.$subtotal.'</td></tr>';
					
					$count++;		
				}
			$HTML .='</table>
        </td>
    </tr></table>';	
				
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
				
				$pdf->writeHTML($HTML, true, false, false, false, '');
			//}
		}

		//$fileName = 'packagingslip-'.date('d_m_y').'.pdf';
		$filename = $filename.".pdf";
		$fileName = $filename;
		$pdf->Output($fileName, 'D');

		//============================================================+
		// END OF FILE                                                
		//============================================================+
    }

}
