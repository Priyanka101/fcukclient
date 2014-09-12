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
 * Exports orders to csv file. If an order contains multiple ordered items, each item gets
 * added on a separate row.
 */

class SLandsbek_SimpleOrderExport_Model_Export_Discountreport extends SLandsbek_SimpleOrderExport_Model_Export_Abstract
{
    const ENCLOSURE = '"';
    const DELIMITER = ',';

    /**
     * Concrete implementation of abstract method to export given orders to csv file in var/export.
     *
     * @param $orders List of orders of type Mage_Sales_Model_Order or order ids to export.
     * @return String The name of the written csv file in var/export
     */
    public function exportOrders($orders) 
    {
        $fileName = 'order_export_'.date("Ymd_His").'.csv';
        $fp = fopen(Mage::getBaseDir('export').'/'.$fileName, 'w');

        $this->writeHeadRow($fp);
        foreach ($orders as $order) {
            $order = Mage::getModel('sales/order')->load($order);
            $this->writeOrder($order, $fp);
			//$this->testcheck($order);
			
        }
		
        fclose($fp);

        return $fileName;
    }
	
	public function testcheck($order)
	{
		
		
		 $orderItems = $order->getItemsCollection();
		 $salevalueTotal = 0;
		 $taxvalueTotal = 0;
		 $mrpTotal = 0;
		 $invoicevalueTotal = 0;
		 $discountTotal = 0;
		foreach ($orderItems as $item){
			if($item->getData('product_type')=='configurable'){
		 	$itemArr = $item->getData();
			
			$product = Mage::getModel('catalog/product')->load($itemArr['product_id']);
										  $resource = Mage::getSingleton('core/resource');
     									  $readConnection = $resource->getConnection('core_read');
											
											$query = 'SELECT tax_calculation_rate_id FROM ' .$resource->getTableName('tax_calculation') . ' WHERE product_tax_class_id = '
             . (int)$product->getData('tax_class_id') . ' LIMIT 1';
     
    		$data = $readConnection->fetchOne($query);
			$query = 'SELECT rate FROM ' .$resource->getTableName('tax_calculation_rate') . ' WHERE tax_calculation_rate_id = '
             . (int)$data . ' LIMIT 1';
    		$vat = $readConnection->fetchOne($query);
			$qty = number_format($itemArr['qty_invoiced']);
			$productcode=$itemArr['sku'];//code 
			$attr =  Mage::getModel('catalog/product')->loadByAttribute('sku',$productcode);
			
										   $grossValuenew = $attr->getData('price') * $qty;
										   $mrpValue = $attr->getData('price');
										   $dis_val = $attr->getData('price') - $itemArr['base_price'];
										   $vat_tax = (($attr->getData('price') - $dis_val)*$vat)/(100 + $vat); 
										   $netValue = $grossValuenew  - $dis_val ;
										 	$count++;
											$salevalueTotal = $salevalueTotal + round($grossValuenew);
											$taxvalueTotal = $taxvalueTotal + round($vat_tax);
											$mrpTotal = $mrpTotal + round($mrpValue);
											$invoicevalueTotal = $invoicevalueTotal + round($netValue);
											$discountTotal = $discountTotal + round($dis_val);
											
											
											
											
			
			
			
		}
		}
		
		
		
		echo number_format($salevalueTotal)." ".number_format($taxvalueTotal) ." " .number_format($mrpTotal)." " .number_format($invoicevalueTotal)." " .number_format($discountTotal) ;
		exit;
		
		
		
		
		
		
		
		
		
		
		
		
		
		 $orderItems = $order->getItemsCollection();
		 $itemweight = 0;
		 $itemtitle = '';
		 $itemqty = 0;
		 
		  $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');
	$tableName = $resource->getTableName('order_ship_track');
		 
		  $query = 'SELECT * FROM ' . $tableName . ' WHERE order_id = '
             . (int)$order->getId() . ' LIMIT 1';
		$results = $readConnection->fetchAll($query);
		echo '<pre>';
		print_r($results);
		exit;
		 
		 $realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()
                      ->addFieldToFilter('order_id',$order->getId())
					  ->addAttributeToSelect('*');
	 $shipment_data = $realShipments->getData();
	 
	 echo '<pre>';
		 print_r( $shipment_data);
		 exit;
		
		 
		  foreach ($orderItems as $item)
        {
			//echo "hi";
		 //	$itemtitle = $itemtitle.$this->getOrderItemTitle($item)." , ";
		//	$itemweight = $itemweight + $this->getOrderItemWeight($item);
		//	$itemqty = $itemqty + $this->getOrderItemQuentity($item);
		
		
		if($item->getData('product_type')=='configurable'){
	 		 $titlenew = $this->getOrderItemTitle($item);
		   	$itemtitle = $itemtitle.$titlenew." , ";
			$weght = $this->getOrderItemWeight($item);
			$itemweight = $itemweight + $weght ;
			$qt = $this->getOrderItemQuentity($item);
			$itemqty = $itemqty + $qt ;
		}
		   
		
           
        }
		
		echo $itemtitle .'<br />';
		echo $itemweight .'<br />';
		echo $itemqty .'<br />';

		 exit;
		
		
		
		
		$shippingData = $order->getShippingAddress();
		$datanew = $shippingData->getData();
		
		echo '<pre>';
		print_r($datanew);
		
		if(empty($datanew['customer_address_id']) && $datanew['customer_address_id'] !== "NULL" ){
			$shippingData = $order->getBillingAddress();
			$address = Mage::getModel('customer/address')->load($shippingData->getData('customer_address_id'));
			$shipping_landmark =$address->getData('landmark') ;
			$shipping_landline =$address->getData('telephonetwo');
		
		}else{
			
			
			$shippingId = $order->getShippingAddress()->getId();
			$address = Mage::getModel('sales/order_address')->load($shippingId);
			$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
			$shipping_landmark = $data['landmark'];
			$shipping_landline = $data['telephonetwo'];
		}
		
		exit;
		
		
		
		
		//echo $order->getId();
		$shippingId = $order->getShippingAddress();
	echo	$shipid = $order->getShippingAddress()->getId();
	echo	$billing = $order->getBillingAddress()->getId();
		echo '<pre>';
		print_r($shippingId->getData());
		
		$address = Mage::getModel('sales/order_address')->load(455);
		$address = Mage::getModel('customer/address')->load(29);
		print_r($address->getData());
		exit;
		
		 $customer = Mage::getModel('customer/customer')->load($shippingId->getData('customer_id'));
echo '<pre>';		 
print_r($customer->getData());
exit;
$customerAddress  = $customer->getPrimaryBillingAddress();
print_r($customerAddress->getData()); 
		exit;
		
		echo $shippingId = $order->getShipingAddress()->getId();
		
		// Get shipping address data using the id
		$address = Mage::getModel('sales/order_address')->load($shippingId);
		$data = Mage::getModel('customer/address')->load($address->getData('customer_id'));
			echo '<pre>';
			print_r($address->getData());exit;
		$resource = Mage::getSingleton('core/resource');
   
    $readConnection = $resource->getConnection('core_read');
	$tableName = $resource->getTableName('order_ship_track');
	// $query = 'SELECT * FROM ' . $resource->getTableName('order_ship_track');
	  
	  $query = 'SELECT * FROM ' . $tableName . ' WHERE order_id = '
             . (int)$order->getId() . ' LIMIT 1';
		$results = $readConnection->fetchAll($query);
		echo '<pre>';
		print_r($results);
		
		
		exit;
		
		
		$realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()
                      ->addFieldToFilter('order_id',$order->getId())
					  ->addAttributeToSelect('*');
	 $shipment_data = $realShipments->getData();
	 if(!empty($shipment_data)){
		
		 foreach($realShipments as $shipment){
			 
			 echo '<pre>';
			 print_r($shipment);
			 exit;
		
		 $shipmentArray = $this->getShipmentValues($shipment);
		 
		 echo"<pre>";
	 print_r($shipmentArray);
	 exit;
		 }
		 }else{
		 $shipmentArray[] = '';
		 $shipmentArray[] = '';
		 $shipmentArray[] = '';
		 }
		
		
		
		$orderItems = $order->getItemsCollection();
		echo '<pre>';
		//print_r($orderItems->getData());
		//$product = Mage::getModel('catalog/product')->load(10280);
		//print_r($product->getData());
		 
		 foreach ($orderItems as $item)
        {
		//print_r($item);	
			$itemnew = Mage::getModel('catalog/product')->load($item->getData('product_id'))->getData('stockno');
			
		 print_r($itemnew);
		 exit;
            if (!$item->isDummy()) {
                $record = array_merge($common, $invoiceArray,$this->getOrderItemValues($item, $order, ++$itemInc),$shipmentArray);
                fputcsv($fp, $record, self::DELIMITER, self::ENCLOSURE);
            }
        }
		
		
		exit; 
		
		
	$realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()
                      ->addFieldToFilter('order_id',$order->getId())
					  ->addAttributeToSelect('*');
	 $shipment_data = $realShipments->getData();
	 
	 echo '<pre>';
	 $shippingId = $order->getShippingAddress()->getId();

    // Get shipping address data using the id
    $address = Mage::getModel('sales/order_address')->load($shippingId);
	$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
		echo $data['landmark'];
	
	
	
		if(!empty($shipment_data)){
		
		 foreach($realShipments as $shipment){
		
		 $shipmentArray = $this->getShipmentValues($shipment);
		 
		 echo"<pre>";
	 print_r($shipmentArray);
	 exit;
		 }
		 }else{
		 $shipmentArray[] = '';
		 $shipmentArray[] = '';
		 $shipmentArray[] = '';
		 }
		  exit;
	} 

    /**
	 * Writes the head row with the column names in the csv file.
	 * 
	 * @param $fp The file handle of the csv file
	 */
    protected function writeHeadRow($fp) 
    {
        fputcsv($fp, $this->getHeadRowValues(), self::DELIMITER, self::ENCLOSURE);
    }

    /**
	 * Writes the row(s) for the given order in the csv file.
	 * A row is added to the csv file for each ordered item. 
	 * 
	 * @param Mage_Sales_Model_Order $order The order to write csv of
	 * @param $fp The file handle of the csv file
	 */
    protected function writeOrder($order, $fp) 
    {
		//echo '<pre>';print_r($order->getData());exit; 
        $common = $this->getCommonOrderValues($order);
		$invoices = Mage::getResourceModel('sales/order_invoice_collection')
                ->setOrderFilter($order->getId())
                ->load();
		$realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()
                      ->addFieldToFilter('order_id',$order->getId())
					  ->addAttributeToSelect('*');

        $orderItems = $order->getItemsCollection();
        $itemInc = 0;
		$invoiceInc=0;
		$invoices_data = $invoices->getData();
		if(!empty($invoices_data)){
		
		 foreach($invoices as $invoice){
		 $invoiceArray = $this->getInvoiceValues($invoice);
		 //$transactionArray = $this->getTransactionNo($invoice);
		 
		 }
		 }else{
		 $invoiceArray[] = '';
		/* $invoiceArray[] = '';
		 $invoiceArray[] = ''; */
		 //$transactionArray[] =''; 
		 }
		 
		 
		 
		 
		 if($this->getPaymentMethod($order)=="cashondelivery"){
		$paymentmethod[] = "Cod";	 
		 }else{
			 $paymentmethod[] = "Prepaid";	 
		 }
		 
		  $order_date[] = Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', true);
		 
		 
		 $shipment_data = $realShipments->getData();
		if(!empty($shipment_data)){
		
		 foreach($realShipments as $shipment){ 
		 $shipmentArray = $this->getShipmentValues($shipment);
		 $airwaybillnoArray = $this->getAirwaybillno($shipment);
		 }
		 }else{
			 
		$shipment_data =$this->getShipmentValuesfromdirect($order);
		$airwaybillnoArray = $this->getAirwaybillnofromdirect($order);
		
		if(!empty($shipment_data))
		{
		$shipmentArray = $shipment_data;
		$shipmentArray[] ='';	
		}else{
		 $shipmentArray[] = '';
		 $shipmentArray[] = '';
		 $shipmentArray[] = '';
		}
		
		if(empty($airwaybillnoArray)){
			$airwaybillnoArray[] = '';
		}
		
		 
		 }
		 
		 
		 $itemtitle='';
		 $itemqty = 0;
		 $itemweight =0;
		  $salevalueTotal = 0;
		 $taxvalueTotal = 0;
		 $mrpTotal = 0;
		 $invoicevalueTotal = 0;
		 $discountTotal = 0;
		//echo '<pre>';print_r($orderItems->getData());exit;
        foreach ($orderItems as $item)
        {
			/*---kishan---*/
			$dis_val = floatval($item['base_discount_amount']); 
			//var_dump($dis_val);exit;
			$discountTotal = $discountTotal + $dis_val;
			$vat_tax = floatval($item['base_tax_amount']);
			$taxvalueTotal = $taxvalueTotal + $vat_tax;
			$mrpValue = floatval($item['base_row_total_incl_tax']);
			$mrpTotal = $mrpTotal + $mrpValue;
			$netValue = $mrpValue  - $dis_val;
			$invoicevalueTotal = $invoicevalueTotal + $netValue;
			$salevalueTotal = $salevalueTotal + $mrpValue;
			$qtyTotal = 0;
			if($item->getData('product_type')=='simple')
			{
				$qty = $itemArr['qty_ordered'];
				$qtyTotal = $qtyTotal + $qty;
			}
		   
        }
		$invoicedetail[] = $qtyTotal;
		$invoicedetail[] = number_format($salevalueTotal);
		$invoicedetail[] = number_format($taxvalueTotal);
		$invoicedetail[] = number_format($mrpTotal);
		$invoicedetail[] = number_format($invoicevalueTotal);
		$invoicedetail[] = number_format($discountTotal);
		
		$record = array_merge($common ,$invoicedetail);
                fputcsv($fp, $record, self::DELIMITER, self::ENCLOSURE);
		
		
    }

    /**
	 * Returns the head column names.
	 * 
	 * @return Array The array containing all column names
	 */
    protected function getHeadRowValues() 
    {
        return array(
			'Order Date',
			'Order N0',
			'Customer Name',
			'Transaction No',
         	'Quantity',
            'Sale Value',
			'Tax',
			'MRP',
			'Invoice Value',
			'Discount',
            
    	);
    }

    /**
	 * Returns the values which are identical for each row of the given order. These are
	 * all the values which are not item specific: order data, shipping address, billing
	 * address and order totals.
	 * 
	 * @param Mage_Sales_Model_Order $order The order to get values from
	 * @return Array The array containing the non item specific values
	 */
    protected function getCommonOrderValues($order) 
    {
        $shippingAddress = !$order->getIsVirtual() ? $order->getShippingAddress() : null;
		//$shippingAddress=$order->getShippingAddress();
		$invoices = Mage::getResourceModel('sales/order_invoice_collection')
                ->setOrderFilter($order->getId())
                ->load();
				
		$invoices_data = $invoices->getData();
		if(!empty($invoices_data)){
		
		 foreach($invoices as $invoice){
		 $transactionNo = $this->getTransactionNo($invoice);
		 
		 }
		 }else{
		 $transactionNo =''; 
		 }		
		
		
		$billingId = $order->getBillingAddress()->getId();
		$address = Mage::getModel('sales/order_address')->load($billingId);
		$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
		$billing_landmark = $data['landmark'];
		$billing_landline = $data['telephonetwo'];
		
		$shippingData = $order->getShippingAddress();
		$datanew = $shippingData->getData();
		
		if( empty($datanew['customer_address_id']) && $datanew['customer_address_id'] !== "NULL" ){
			$shippingData = $order->getBillingAddress();
			$address = Mage::getModel('customer/address')->load($shippingData->getData('customer_address_id'));
			$shipping_landmark =$address->getData('landmark') ;
			$shipping_landline =$address->getData('telephonetwo');
		
		}else{
			$shippingId = $order->getShippingAddress()->getId();
			$address = Mage::getModel('sales/order_address')->load($shippingId);
			$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
			$shipping_landmark = $data['landmark'];
			$shipping_landline = $data['telephonetwo'];
		}
		
	 $billingAddress = $order->getBillingAddress();
		$billAddress=  $billingAddress->getName()." ".
                       $billingAddress->getData("company")." ".
                       $billingAddress->getData("street")." ".
                       $billingAddress->getData("postcode")." ".
                       $billingAddress->getData("city")." ".
                       $billingAddress->getRegionCode()." ".
                       $billingAddress->getRegion()." ".
                       $billingAddress->getCountry()." ".
                       $billingAddress->getCountryModel()->getName()." ".
                       $billingAddress->getData("telephone");
       $shipAddress=   $shippingAddress->getName()." ".
                       $shippingAddress->getData("company")." ".
                       $shippingAddress->getData("street")." ".
                       $shippingAddress->getData("postcode")." ".
                       $shippingAddress->getData("city")." ".
                       $shippingAddress->getRegionCode()." ".
                       $shippingAddress->getRegion()." ".
                       $shippingAddress->getCountry()." ".
                       $shippingAddress->getCountryModel()->getName()." ".
                       $shippingAddress->getData("telephone");
		$country_name=Mage::app()->getLocale()->getCountryTranslation($shippingAddress->getCountry());			   
			
		
		
        return array(
			Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', true),
			$order->getRealOrderId(),
			$shippingAddress ? $shippingAddress->getName() : '',
			$transactionNo,
         /*   
            $billingAddress->getName(), */
			
           /* $billAddress,
            $billingAddress->getData("city"),
            $billingAddress->getRegion(),
            $billingAddress->getRegion(),
			$billingAddress->getData("postcode"),
			$billing_landmark,
			$billing_landline, */
		/*	$shipAddress,
			$shippingAddress->getData("city"),
			$shippingAddress->getRegion(),
			$country_name,
			$shippingAddress->getData("postcode"),
			$shippingAddress->getData("telephone"),*/
			/*$shipping_landmark,
			$shipping_landline, */
           /* $this->getPaymentMethod($order),
            $this->getPaymentMethod($order), */
            /*$this->getTotalQtyItemsOrdered($order),*/
          /* $order->getStatus(),*/
         
        );
    }

    /**
	 * Returns the item specific values.
	 * 
	 * @param Mage_Sales_Model_Order_Item $item The item to get values from
	 * @param Mage_Sales_Model_Order $order The order the item belongs to
	 * @return Array The array containing the item specific values
	 */
    protected function getOrderItemValues($item, $order, $itemInc=1 , $stockno) 
    {
        return array(
           
            $item->getData('name'),
           /* $this->getItemOptions($item),
            (int)$item->getQtyShipped(),
			$stockno, */
			(int)$item->getData('weight')."grms",
			(int)$item->getData('qty_ordered'),
			
           
        );
    }
	
	
	protected function getOrderItemTitle($item){
		return $item->getData('name');
	}
	
	protected function getOrderItemWeight($item){
		return (int)$item->getData('weight');
	}
	
	protected function getOrderItemQuentity($item){
		return (int)$item->getData('qty_ordered');
	}
	
	
	 /**
	 author-samir rath
	 * Returns the item specific values.
	 * 
	 * @param Mage_Sales_Model_Order_Invoice 
	
	 * @return Array The array containing the invoice values
	 */
	 protected function getInvoiceValues($invoice) 
    {
        return array(
			/* $invoice->getIncrementId(),
			 date('M d,Y', strtotime($invoice->getCreatedAt())), */
			 round($invoice->getGrandTotal()),
        );
    }
	
	 protected function getTransactionNo($invoice) 
    {
		if($invoice->getIncrementId()!='')
        	return  $invoice->getIncrementId();
		else
			return '';	
		
    }
	
	
	/**
	 author-samir rath
	 * Returns the item specific values.
	 * 
	 * @param Mage_Sales_Model_Order_Shipment_Track  
	
	 * @return Array The array containing the shipment values
	 */
	 protected function getShipmentValues($shipmentTracking) 
    {
	         return array(
			 $shipmentTracking->getTitle(),
			 $shipmentTracking->getTrackNumber(),
			 date('M d,Y', strtotime($shipmentTracking->getCreatedAt())),
			 
        );
    }
	
	protected function getAirwaybillno($shipmentTracking){
		
		 return array(
						$shipmentTracking->getTitle(),
			 			$shipmentTracking->getTrackNumber(),
					);
		
	}
	
	 protected function getShipmentValuesfromdirect($order) 
    {
	  $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');
	$tableName = $resource->getTableName('order_ship_track');
	// $query = 'SELECT * FROM ' . $resource->getTableName('order_ship_track');
	  
	  $query = 'SELECT * FROM ' . $tableName . ' WHERE order_id = '
             . (int)$order->getId() . ' LIMIT 1';
		$results = $readConnection->fetchAll($query);
		if(!empty($results)){
        return array(
			 $results[0]['carrier'],
			 $results[0]['track_no'],
			 
        );
		}else{
			return false;
		}
    }
	 protected function getAirwaybillnofromdirect($order) 
    {
	  $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');
	$tableName = $resource->getTableName('order_ship_track');
	// $query = 'SELECT * FROM ' . $resource->getTableName('order_ship_track');
	  
	  $query = 'SELECT * FROM ' . $tableName . ' WHERE order_id = '
             . (int)$order->getId() . ' LIMIT 1';
		$results = $readConnection->fetchAll($query);
		if(!empty($results)){
        return array(
			 $results[0]['carrier'],
			 $results[0]['track_no'],
		);
		}else{
			return false;
		}
    }
	
	
}

?>