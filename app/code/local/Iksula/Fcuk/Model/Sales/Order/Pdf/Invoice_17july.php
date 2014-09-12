<?php
/**
 * Magento
 *
 *
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Sales Order Invoice PDF model
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */

require_once('Tcpdf/config/lang/eng.php');
require_once('Tcpdf/tcpdf.php');
include_once 'app/code/core/Mage/Sales/Model/Order/Pdf/Invoice.php';

class Iksula_Fcuk_Model_Sales_Order_Pdf_Invoice extends Mage_Sales_Model_Order_Pdf_Invoice
{
	
    public function getPdf($invoiceArray = array())
    {
		
		
		/*echo "<pre>";
		print_r($invoiceArray->getData());
		exit;*/
		$this->_beforeGetPdf();
        $this->_initRenderer('invoice');
	
        // create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false,false ,false);//last parameter for  footer  if true then footer show. if false then footer not show
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle("Invoice");
		
		$img_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/fcuk/default/images/french_connection_pdf_logo.png";
		$pdf->SetHeaderData($img_url, PDF_HEADER_LOGO_WIDTH);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$pdf->SetMargins(10,15,10,TRUE);
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 20);
 
		$this->_setPdf($pdf);
		
		
		foreach ($invoiceArray as $invoices)
		{
					$pdf->AddPage();
					$order = $invoices->getOrder();
					$taxAmount			= number_format($invoices->getData('tax_amount'));
					
					//print_r(get_class($invoices));exit;
					/*  Billing Address*/
					$billingAdd 	= $invoices->getBillingAddress()->getData();
					//echo '<pre>';print_r($billingAdd);exit;
					$b_name 		= $billingAdd['firstname'].' '.$billingAdd['lastname'];
					$b_street 		= $billingAdd['street'];
					$b_city 		= $billingAdd['city'];
					$b_postcode 	= $billingAdd['postcode'];
					$region 		= $billingAdd['region'];
					$telephone		= $billingAdd['telephone'];
					$fax_billing			= $billingAdd['fax'];
					$address = Mage::getModel('customer/address')->load($billingAdd['customer_address_id']);
					$landmark_billing		= $address->getData('landmark');
					$landline_billing		= $address->getData('telephonetwo');
					
					
					/*Invoice Detail*/
					$invoiceNo 		= $invoices->getIncrementId();
					$invoiceDate 	= date('d/m/Y', $invoices->getCreatedAtDate()->getTimestamp());
					
					/*Order Detal*/
					$orderId 		= $order->getData('increment_id');//order no
					$orderDate 		= date('d/m/Y', strtotime($order->getData('created_at')));
					
					/* Shipping Address & Shipping & Tracking Detail*/
					$shippingAdd 	= $invoices->getShippingAddress()->getData();
					$filename 		= $shippingAdd['firstname'].$shippingAdd['lastname'];
					$c_name 		= $shippingAdd['firstname'].' '.$shippingAdd['lastname'];//customer name
					$street 		= $shippingAdd['street'];//shipn add
					$city 			= $shippingAdd['city'];
					$postcode 		= $shippingAdd['postcode'];
					$region 		= $shippingAdd['region'];
					//echo $region;exit;
					if(strtolower ($region) == 'maharashtra')
					{
						$tax_type = 'VAT ';
					}
					else
					{
						$tax_type = 'CST ';
					}
					//echo $tax_type;exit;
					$telephone		= $shippingAdd['telephone'];
					$fax_shipping			= $shippingAdd['fax'];
					$address = Mage::getModel('customer/address')->load($shippingAdd['customer_address_id']);
					$landmark_shipping		= $address->getData('landmark');
					$landline_shipping		= $address->getData('telephonetwo');
					
					$shipping_no 	= '&nbsp;';
					$shipping_Date 	= '&nbsp;';
					$track_title 	= '&nbsp;';
					$track_number 	= '&nbsp;';
					if ($order->hasShipments()) {
	    				foreach ($order->getShipmentsCollection() as $_eachShipment) {
							$shipping_no = $_eachShipment->getData('increment_id');
							$shipping_Date =date('d/m/Y', strtotime($_eachShipment->getData('created_at')));
							
							
							$trackArr = $_eachShipment->getTracksCollection()->getData();
							//$carrier_code = $trackArr[0]['carrier_code'];
							$track_title = $trackArr[0]['title']; 
							$track_number = $trackArr[0]['track_number']; 
							
           				}
					}
					/*Payment Detal*/	
					$paymentMethod  = $order->getPayment()->getMethodInstance()->getTitle();
					
					$grandTotal 	= number_format($order->getData('base_grand_total'));//total value
					$grandTotal_inwords  = $order->getData('base_grand_total');
					
					/* Add head */
					//$this->insertOrder($page, $order, Mage::getStoreConfigFlag(self::XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID, $order->getStoreId()));
					$shipping	=$order->getData('shipping_description');//dispatch
					$shipmentCollection = Mage::getResourceModel('sales/order_shipment_collection')
            		->setOrderFilter($order)
        			->load();
					/*
       			 foreach ($shipmentCollection as $shipment){
            // This will give me the shipment IncrementId, but not the actual tracking information.
					foreach($shipment->getAllTracks() as $tracknum)
					{
						$tracknums[]=$tracknum->getNumber();
					}

       			 } */
				 	/*
					if($paymentMethod  == "Cash On Delivery")
					{
					 $paymentType = $paymentMethod ;
					}
					else
					{
						$paymentType = "PREPAID ORDER" ;
					}
					*/
					$pdf->SetFont('helvetica', '', 8);
					//$pdf->Write(0, PDF_HEADER_STRING, '', 0, 'L', true, 0, false, false, 0);
					// -----------------------------------------------------------------------------
					 $img_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/fcuk/default/images/french_connection_pdf_logo.png";
					//exit;
					//<tr><td colspan="2"><table><tr><img src="'.$img_url.'" width="250" height="35"></tr></table></td></tr>
				$HTML = '<table border="0">
						<tr style="font-size:100px;font-weight:bold"><td colspan="2" style="text-align:center"><strong>French Connection</strong></td></tr>
						<tr><td colspan="2" >&nbsp;</td></tr>
						<tr><td colspan="2" style="text-align:center"><strong>TAX INVOICE</strong></td></tr>
						<tr><td colspan="2" style="text-align:center">(Subject to Mumbai jurisdiction)</td></tr>
						<tr><td colspan="2" >&nbsp;</td></tr>
						<tr><td colspan="2" >&nbsp;</td></tr>
						<tr><td colspan="2" style="border:1px solid #999;" ><table border="0" cellpadding="3"><tr><td><strong>Brand Retail Pvt Ltd.</strong><br />C/o FedEx Express Transportation and Supply Chain Services (India) Private Limited<br />Next to NDR Warehousing,Survey No. 95 A , Hissa No. 5 , Mumbai Nasik Highway,<br/>
						 Near Sai Dhaba, Village-Vadape, Tal-Bhiwandi, Dist-Thane, Pin Code 421302, Maharashtra, India.	</td></tr></table>
						</td></tr>
						<tr>
							<td colspan="2">&nbsp;
							
							</td>
						</tr>
						<tr width="100%">
							<table cellpadding="5"><tr>
							<td colspan="2" style="border:1px solid #999;">
								<table>
									<tr>
										<td style=" ">Order Number</td>
										<td style=" text-align:right;">'.$orderId.'</td>
										<td  style="width:50px;">&nbsp;</td>
										<td style="  width:285px;"><strong>Sold To:</strong></td>
									</tr>
									<tr>
										<td style=" ">Order Date</td>
										<td style="text-align:right;">'.$orderDate.'</td>
										<td style="width:50px;">&nbsp;</td>
										<td style=" width:285px;">'.$b_name.'</td>
									</tr>
									<tr>
										<td style="">Invoice Number</td>
										<td style=" text-align:right;">'.$invoiceNo.'</td>
										<td style="width:50px;">&nbsp;</td>
										<td style=" width:285px;">'.$b_street.'</td>
									</tr>
									<tr>
										<td style="">Invoice Date</td>
										<td style=" text-align:right;">'.$invoiceDate.'</td>
										<td style="width:50px;">&nbsp;</td>
										<td style=" width:285px;">'.$b_city.'</td>
									</tr>
									<tr>
										<td style="">Shipping Number</td>
										<td style=" text-align:right;">'.$shipping_no.'</td>
										<td style="width:50px;">&nbsp;</td>
										<td style=" width:285px;">'.$region.'</td>
									</tr>
									<tr>
										<td style="">Service Provider</td>
										<td style="text-align:right;">'.$track_title.'</td>
										<td style="width:50px;">&nbsp;</td>
										<td style="  width:285px;">'.$b_postcode.'</td>
									</tr>
									<tr>
										<td style="">Payment Method</td>
										<td style="text-align:right;">'.$paymentMethod.'</td>
										<td style="width:50px;">&nbsp;</td>
										<td style=" width:285px;">T : '.$telephone.'</td>
									</tr>
								</table>
							</td></tr></table>
						</tr>
						<tr>
							<td colspan="2"></td>
						</tr>
						<tr>
							<table cellpadding="5"><tr>
							<td colspan="2" style="border:1px solid #999;">
								<table>
									<tr>
										<td style=" ">Vat No</td>
										<td style=" text-align:right;">27740861483V</td>
										<td style="width:50px;">&nbsp;</td>
										<td style="  width:285px;"><strong>Ship To:</strong></td>
									</tr>
									<tr>
										<td style=" ">CST No</td>
										<td style=" text-align:right;">27740861483C</td>
										<td style="width:50px;">&nbsp;</td>
										<td style=" width:285px;">'.$c_name.'</td>
														
									</tr>
									
									<tr>
										<td >&nbsp;</td>
										<td >&nbsp;</td>
										<td style="width:50px;">&nbsp;</td>
										<td style="  width:285px;">'.$street.'</td>
									</tr>
									<tr>
										<td >&nbsp;</td>
										<td >&nbsp;</td>
										<td style="width:50px;">&nbsp;</td>
										<td style="  width:285px;">'.$city.'</td>
									</tr>
									<tr>
										<td >&nbsp;</td>
										<td >&nbsp;</td>
										<td style="width:50px;">&nbsp;</td>
										<td style="  width:285px;">'.$region.'</td>
									</tr>
									<tr>
										<td >&nbsp;</td>
										<td >&nbsp;</td>
										<td style="width:50px;">&nbsp;</td>
										<td style="   width:285px;">'.$postcode.'</td>
									</tr>
									<tr>
										<td >&nbsp;</td>
										<td >&nbsp;</td>
										<td style="width:50px;">&nbsp;</td>
										<td style="   width:285px;">T : '.$telephone.'</td>
									</tr>									
								</table>
							</td></tr></table>
						</tr>
						
						 <tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr width="100%">
							<table  cellpadding="5"><tr>
							<td colspan="2">
								<table width="100%" style=" border:1px solid #999;  width:215px;">
									<tr><td colspan="11">&nbsp;</td></tr>
									<tr style="text-align:center;">
										<td width="4%"><strong>Sr No</strong></td>
										<td width="20%"><strong>Product</strong></td>
										<td width="12%"><strong>Stock No</strong></td>
										<td width="14%"><strong>Color</strong></td>
										<td width="5%"><strong>Size</strong></td>
										<td width="5%"><strong>Qty</strong></td>
										<td width="8%"><strong>MRP</strong></td>
										<td width="8%"><strong>Gross Val</strong></td>
										<td width="8%"><strong>Dis Val</strong></td>
										<td width="8%"><strong>Tax(incl)</strong></td>
										<td width="8%"><strong>Net Value</strong></td>
									</tr>';
										
										/* Add body */
										/* foreach($order->getAllItems() as $item){
											print_r(get_class_methods($item));
										}exit; */
										$count = 1;
										$total_val = 0;
											
										foreach ($invoices->getAllItems() as $item){
											if ($item->getOrderItem()->getParentItem()) {
												continue;
											}

											$itemArr = $item->getData();
											//echo '<pre>';print_r($itemArr);continue;
											$product = Mage::getModel('catalog/product')->load($itemArr['product_id']);
											$pro_price = $product->getData('price');
											$special_price = $product->getData('special_price');
											
											$itemName = $itemArr['name'];//name
											$qty = $itemArr['qty'];
											$price = $itemArr['price'];
											$subtotal =$itemArr['qty']*($itemArr['base_row_total'] - $itemArr['discount_amount']);
											$productcode=$itemArr['sku'];//code 
											$base_price = $itemArr['price'];
											$attr =  Mage::getModel('catalog/product')->loadByAttribute('sku',$productcode);
											$attrValueColor = $attr->getAttributeText('color');
											$attrValueSize = $attr->getAttributeText('size');
											
											/*code for special price*/
											if($product->getData('special_price')!='' && strtotime($order->getData('created_at'))>=strtotime('27-06-2013')){

												$grossValue = $pro_price * $qty;
												$mrpValue = $pro_price;
												$dis_val =  $itemArr['discount_amount'] + $mrpValue - $special_price;
												if($itemArr['price_incl_tax']==$product->getData('special_price')){
														$grossValuenew = $pro_price * $qty;
												}else{
													$grossValuenew = $itemArr['base_price_incl_tax']* $qty;
												}
										}
											else{
												$grossValuenew = $itemArr['base_price_incl_tax']* $qty;
												$grossValue = $itemArr['base_price_incl_tax'] * $qty;
												$mrpValue = $itemArr['price_incl_tax'];
												$dis_val =  $itemArr['discount_amount'];
											}
											$netValue = $itemArr['base_price_incl_tax'];
											$netValue = $grossValuenew  - $dis_val;
											$totl_newvalue = $grossValuenew  - $dis_val ;
											$total_val = $total_val + $totl_newvalue ;
											$vat_tax=$itemArr['tax_amount'];

											if(is_numeric($attr->getData('sku'))){
												$attrStockNo = $attr->getData('sku');
											}
											else{
												$attrStockNo = $attr->getData('stockno');
											}
											
											$HTML .='
											<tr style="text-align:center;">
												<td> '.$count.'</td>
												<td> '.$itemName.' </td>
												<td>'.$attrStockNo.'</td>
												<td>'.$attrValueColor.'</td>
												<td>'.$attrValueSize.'</td>
												<td>'.number_format($qty).'</td>
												<td>'.sprintf("%.2f", $mrpValue).'</td>
												<td>'.sprintf("%.2f", $grossValue).'</td>
												<td>'.sprintf("%.2f", $dis_val).'</td>
												<td>'.sprintf("%.2f", $vat_tax).'</td>
												<td>'.sprintf("%.2f", $netValue).'</td>
												
											</tr>';
											$count++;	  
										}
										/* Add totals */
									   
										$HTML .='<tr><td colspan="11">&nbsp;</td></tr><tr><td colspan="11">&nbsp;</td></tr></table>
							</td></tr></table>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td colspan="2">
								<table>
									<tr>
										<td>&nbsp;</td>
										<td style="text-align:right" >
											Total Amt &nbsp;&nbsp;'.number_format($total_val).'
										</td>
									</tr>
							
									<tr>
										<td>&nbsp;</td>
										<td style="text-align:right" > 
											Shipping Cost &nbsp;&nbsp;'.number_format($order->getData('shipping_amount')).'	
										</td>
									</tr>
						
									<tr>
										<td width="80%">
							 				<strong>In Words:</strong><br />&nbsp;
											'.$this->convertNumber(round($total_val) + $order->getData('shipping_amount')).' Rupees
										</td>
										<td style="text-align:right" width="20%" > 
											<strong>Grand Total </strong>&nbsp;&nbsp;'.number_format($total_val + $order->getData('shipping_amount')).'		
										</td>
									</tr>
								</table>
								   
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:right">E.&.O.E</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:right">For Brand Retail Pvt. Ltd.</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">I /we hereby certify that my /our registration certificate under the Maharashtra Value Added Tax Act ,2002 is in force on the date on which the sale goods specified in this Tax Invoice is made by me/us and that the transaction of sale covered by the this tax invoice has been effected by me/us and it shall while filling the returns and due tax,if any payable on the sale has been paid or shall be paid.</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">
								<strong>Instruction for Courier:</strong>
							</td>
						</tr>
						
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2"><strong>Notes :</strong></td>
						</tr>
						<tr>
							<td colspan="2"><strong>1. This is computer generated document and does not require signature.</strong></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2"><strong>2. Customer Declaration : </strong> Goods shipped with invoice are not for re-sale. </td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">
							3. Please feel free to call us on our customer care number 1800 22 8288 also write us for any feeback or suggestions at customercare@frenchconnection.in</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">4. Please visit our website www.frenchconnection.in for more details about our Terms and Conditions, Shiping Policy & Return & Cancellation.</td>
						</tr>
						
						<tr>
							<td colspan="2"><strong>Registered Office :</strong> Brand Retail Private Limited, Metro Theatre, 4th Floor, Metro Dome, M.G.Road, Mumbai - 400 020.</td>
						</tr>
					</table>'; 
					if ($invoices->getStoreId()) {
						Mage::app()->getLocale()->revert();
					}
					
					$pdf->writeHTML($HTML, true, false, false, false, '');
				//}
			}

		
		// $pdf->writeHTML($HTML, true, false, false, false, '');

		//Close and output PDF document
		//$fileName = 'invoice-'.date('d_m_Y').'.pdf';
		ob_end_clean();
		$fileName = $filename.'_invoice.pdf';
		$pdf->Output($fileName, 'D');		
  
		return $pdf;
    }
	
public	function convertNumber($num)
{
	
	
   list($num, $dec) = explode(".", $num);

   $output = "";

   if($num{0} == "-")
   {
      $output = "negative ";
      $num = ltrim($num, "-");
   }
   else if($num{0} == "+")
   {
      $output = "positive ";
      $num = ltrim($num, "+");
   }
   
  
   if($num{0} == "0")
   {
      $output .= "Zero";
   }
   else
   {
      $num = str_pad($num, 36, "0", STR_PAD_LEFT);
      $group = rtrim(chunk_split($num, 3, " "), " ");
      $groups = explode(" ", $group);

      $groups2 = array();
      foreach($groups as $g) {
	  $groups2[] = $this->convertThreeDigit($g{0}, $g{1}, $g{2});
	  }

      for($z = 0; $z < count($groups2); $z++)
      {
         if($groups2[$z] != "")
         {
            $output .= $groups2[$z].$this->convertGroup(11 - $z).($z < 11 && !array_search('', array_slice($groups2, $z + 1, -1))
             && $groups2[11] != '' && $groups[11]{0} == '0' ? " and " : ", ");
         }
      }

      $output = rtrim($output, ", ");
   }

   if($dec > 0)
   {
      $output .= " point";
      for($i = 0; $i < strlen($dec); $i++) $output .= " ".$this->convertDigit($dec{$i});
   }

   return $output;
}

public function convertGroup($index)
{
   switch($index)
   {
      case 11: return " Decillion";
      case 10: return " Nonillion";
      case 9: return " Octillion";
      case 8: return " Septillion";
      case 7: return " Sextillion";
      case 6: return " Quintrillion";
      case 5: return " Quadrillion";
      case 4: return " Trillion";
      case 3: return " Billion";
      case 2: return " Million";
      case 1: return " Thousand";
      case 0: return "";
   }
}

public function convertThreeDigit($dig1, $dig2, $dig3)
{
	
   $output = "";

   if($dig1 == "0" && $dig2 == "0" && $dig3 == "0") return "";

   if($dig1 != "0")
   {
      $output .= $this->convertDigit($dig1)." Hundred";
      if($dig2 != "0" || $dig3 != "0") $output .= " and ";
   }

   if($dig2 != "0") $output .= $this->convertTwoDigit($dig2, $dig3);
   else if($dig3 != "0") $output .= $this->convertDigit($dig3);

   return $output;
}

public function convertTwoDigit($dig1, $dig2)
{
   if($dig2 == "0")
   {
      switch($dig1)
      {
         case "1": return "Ten";
         case "2": return "Twenty";
         case "3": return "Thirty";
         case "4": return "Forty";
         case "5": return "Fifty";
         case "6": return "Sixty";
         case "7": return "Seventy";
         case "8": return "Eighty";
         case "9": return "Ninety";
      }
   }
   else if($dig1 == "1")
   {
	   
	  
      switch($dig2)
      {
         case "1": return "Eleven";
         case "2": return "Twelve";
         case "3": return "Thirteen";
         case "4": return "Fourteen";
         case "5": return "Fifteen";
         case "6": return "Sixteen";
         case "7": return "Seventeen";
         case "8": return "Eighteen";
         case "9": return "Nineteen";
      }
   }
   else
   {
      $temp = $this->convertDigit($dig2);
      switch($dig1)
      {
         case "2": return "Twenty-$temp";
         case "3": return "Thirty-$temp";
         case "4": return "Forty-$temp";
         case "5": return "Fifty-$temp";
         case "6": return "Sixty-$temp";
         case "7": return "Seventy-$temp";
         case "8": return "Eighty-$temp";
         case "9": return "Ninety-$temp";
      }
   }
}
      
public function convertDigit($digit)
{
   switch($digit)
   {
      case "0": return "Zero";
      case "1": return "One";
      case "2": return "Two";
      case "3": return "Three";
      case "4": return "Four";
      case "5": return "Five";
      case "6": return "Six";
      case "7": return "Seven";
      case "8": return "Eight";
      case "9": return "Nine";
   }
}
	
	
}
