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
class SLandsbek_SimpleOrderExport_Model_Export_Csv extends SLandsbek_SimpleOrderExport_Model_Export_Abstract

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
		$fileName = 'order_export_' . date("Ymd_His") . '.csv';
		$fp = fopen(Mage::getBaseDir('export') . '/' . $fileName, 'w');
		$this->writeHeadRow($fp);
		foreach($orders as $order) {
			$order = Mage::getModel('sales/order')->load($order);
			$this->writeOrder($order, $fp);
			// $this->testcheck($order);
		}
		fclose($fp);
		return $fileName;
	}
	public function testcheck($order)

	{
		$orderItems = $order->getItemsCollection();
		foreach($orderItems as $item) {
			echo '<pre>';
			print_r($item->getData('qty_ordered'));
		}
		exit;
		$shippingData = $order->getShippingAddress();
		$datanew = $shippingData->getData();
		echo '<pre>';
		print_r($datanew);
		if (empty($datanew['customer_address_id']) && $datanew['customer_address_id'] !== "NULL") {
			$shippingData = $order->getBillingAddress();
			$address = Mage::getModel('customer/address')->load($shippingData->getData('customer_address_id'));
			$shipping_landmark = $address->getData('landmark');
			$shipping_landline = $address->getData('telephonetwo');
		}
		else {
			$shippingId = $order->getShippingAddress()->getId();
			$address = Mage::getModel('sales/order_address')->load($shippingId);
			$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
			$shipping_landmark = $data['landmark'];
			$shipping_landline = $data['telephonetwo'];
		}
		exit;
		// echo $order->getId();
		$shippingId = $order->getShippingAddress();
		echo $shipid = $order->getShippingAddress()->getId();
		echo $billing = $order->getBillingAddress()->getId();
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
		$customerAddress = $customer->getPrimaryBillingAddress();
		print_r($customerAddress->getData());
		exit;
		echo $shippingId = $order->getShipingAddress()->getId();
		// Get shipping address data using the id
		$address = Mage::getModel('sales/order_address')->load($shippingId);
		$data = Mage::getModel('customer/address')->load($address->getData('customer_id'));
		echo '<pre>';
		print_r($address->getData());
		exit;
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$tableName = $resource->getTableName('order_ship_track');
		// $query = 'SELECT * FROM ' . $resource->getTableName('order_ship_track');
		$query = 'SELECT * FROM ' . $tableName . ' WHERE order_id = ' . (int)$order->getId() . ' LIMIT 1';
		$results = $readConnection->fetchAll($query);
		echo '<pre>';
		print_r($results);
		exit;
		$realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()->addFieldToFilter('order_id', $order->getId())->addAttributeToSelect('*');
		$shipment_data = $realShipments->getData();
		if (!empty($shipment_data)) {
			foreach($realShipments as $shipment) {
				echo '<pre>';
				print_r($shipment);
				exit;
				$shipmentArray = $this->getShipmentValues($shipment);
				echo "<pre>";
				print_r($shipmentArray);
				exit;
			}
		}
		else {
			$shipmentArray[] = '';
			$shipmentArray[] = '';
			$shipmentArray[] = '';
		}
		$orderItems = $order->getItemsCollection();
		echo '<pre>';
		// print_r($orderItems->getData());
		// $product = Mage::getModel('catalog/product')->load(10280);
		// print_r($product->getData());
		foreach($orderItems as $item) {
			// print_r($item);
			$itemnew = Mage::getModel('catalog/product')->load($item->getData('product_id'))->getData('stockno');
			print_r($itemnew);
			exit;
			if (!$item->isDummy()) {
				$record = array_merge($common, $invoiceArray, $this->getOrderItemValues($item, $order, ++$itemInc) , $shipmentArray);
				fputcsv($fp, $record, self::DELIMITER, self::ENCLOSURE);
			}
		}
		exit;
		$realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()->addFieldToFilter('order_id', $order->getId())->addAttributeToSelect('*');
		$shipment_data = $realShipments->getData();
		echo '<pre>';
		$shippingId = $order->getShippingAddress()->getId();
		// Get shipping address data using the id
		$address = Mage::getModel('sales/order_address')->load($shippingId);
		$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
		if (!empty($shipment_data)) {
			foreach($realShipments as $shipment) {
				$shipmentArray = $this->getShipmentValues($shipment);
			}
		}
		else {
			$shipmentArray[] = '';
			$shipmentArray[] = '';
			$shipmentArray[] = '';
		}
		/*exit;*/
	}
	/**
	 * Writes the head row with the column names in the csv file.
	 *
	 * @param $fp The file handle of the csv file
	 */
	protected function writeHeadRow($fp)
	{
		fputcsv($fp, $this->getHeadRowValues() , self::DELIMITER, self::ENCLOSURE);
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
		$common = $this->getCommonOrderValues($order);
		$invoices = Mage::getResourceModel('sales/order_invoice_collection')->setOrderFilter($order->getId())->load();
		$realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()->addFieldToFilter('order_id', $order->getId())->addAttributeToSelect('*');
		$orderItems = $order->getItemsCollection();
		//$orderdddd = Mage::getModel("sales/order")->load($order->getId()); //load order by order id
		//$ordered_items = $order->getAllItems();
		$ordered_items = $order->getItemsCollection()->addAttributeToFilter('product_type', array('eq' => 'configurable'));
		// echo '<pre>';
		// print_r($ordered_items->getData());
		// exit;
		
		

		$itemInc = 0;
		$invoiceInc = 0;
		$invoices_data = $invoices->getData();
		if (!empty($invoices_data)) {
			foreach($invoices as $invoice) {
				$invoiceArray = $this->getInvoiceValues($invoice);
			}
		}
		else {
			$invoiceArray[] = '';
			$invoiceArray[] = '';
			$invoiceArray[] = '';
		}
		$shipment_data = $realShipments->getData();
		if (!empty($shipment_data)) {
			foreach($realShipments as $shipment) {
				$shipmentArray = $this->getShipmentValues($shipment);
			}
		}
		else {
			$shipment_data = $this->getShipmentValuesfromdirect($order);
			if (!empty($shipment_data)) {
				$shipmentArray = $shipment_data;
				$shipmentArray[] = '';
			}
			else {
				$shipmentArray[] = '';
				$shipmentArray[] = '';
				$shipmentArray[] = '';
			}
		}
		/*echo '<pre>';*/
		/*print_r($orderItems->getData());exit;*/
		//it will provide us the invoice price,discount and tax of the order 
		$invoiceDetailsCounter=0;
		$invoiceDetailsArray=array();
		foreach($ordered_items as $ordered_item) {
		/*	if($ordered_item->getData('product_type') == 'configurable') {	*/
			$invoice_details = $this->getInvoiceValuesFromOrder($ordered_item);
			$invoiceDetailsArray[$invoiceDetailsCounter] = $invoice_details;
			//	$invoiceDetailsArray = '';
			// $invoiceDetailsArray[$iii] = $invoice_details;
			$invoiceDetailsCounter=$invoiceDetailsCounter+1;
		/*}*/
		}

		$incre=0;
		foreach($orderItems as $item) {
				$sku = $item->getData('sku');

		//	$price = $item->getData('row_total_incl_tax'); //this will give the price of individual product
			$productInformation=Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
			$child_id = Mage::getModel('catalog/product')->getIdBySku($sku);
			$parent_ids = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($child_id);
			//print_r($parent_ids);	
			$obj = Mage::getModel('catalog/product');
			$_product = $obj->load($parent_ids[0]);
			
			$price = $_product->getData('price');
			$specialprice = $_product->getData('special_price');
			//echo '<pre>';print_r($invoiceDetailsArray);
			if (!$item->isDummy()) {
				//$record = array_merge($common, $invoiceArray,$invoiceDetailsArray[$incre],$this->getOrderItemValues($item, $order, ++$itemInc, $stockno,$price,$specialprice),$shipmentArray);
				$record = array_merge($common, $invoiceArray, $invoiceDetailsArray[$incre],$this->getOrderItemValues($item, $order, ++$itemInc, $stockno,$price,$specialprice),$shipmentArray,$this->getCreditMemoItemValues($item, $order, ++$itemInc));
				fputcsv($fp, $record, self::DELIMITER, self::ENCLOSURE);

			}
			$incre=$incre+1;
		}
		 //exit;
	}
	/**
	 * Returns the head column names.
	 *
	 * @return Array The array containing all column names
	 */
	protected function getHeadRowValues()
	{
		return array(
			'Order Number',
			'Purchased On',
			'Bill to Name',
			'Ship to Name',
			'Billing address',
			'Order location',
			'Zone',
			'Region',
			'Pin code #',
			'Billing Landmark',
			'Billing Landline',
			'Delivery Address',
			'Phone no',
			'Shipping Landmark',
			'Shipping Landline',
			'Payment mode',
			'Payment type',
			'Status',
			'Invoice Id',
			'Invoice Date',
			'Invoice Total',
			'Invoice Amt',
			//'Price',
			//'Special PRICE',
			'Discount Amt',
			'Coupon Code',
			'Coupon Amt',
			'Total Discount(Coupon discount + Discount Amt)',
			'Tax',
			'BSP',
			'MRP',
			'Item Code',
			'Item Description',
			'shipment qty',
			'Stock No',
			'Order Qty',
			'couier name',
			'Awb Number',
			'Dispatch Date',
			'Credit Memo No',
			'Credit Memo Date',
			'Credit Memo Qty',
			'Credit Memo Orig.Amount',
			'Credit Memo Discount',
			'Credit Memo Tax',
			'Credit Memo Net Amt',
			'Credit Memo Special Price',
			'Credit Memo Original Price',
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
		// $shippingAddress=$order->getShippingAddress();
		$billingId = $order->getBillingAddress()->getId();
		$address = Mage::getModel('sales/order_address')->load($billingId);
		$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
		$billing_landmark = $data['landmark'];
		$billing_landline = $data['telephonetwo'];
		$shippingData = $order->getShippingAddress();
		$datanew = $shippingData->getData();
		if (empty($datanew['customer_address_id']) && $datanew['customer_address_id'] !== "NULL") {
			$shippingData = $order->getBillingAddress();
			$address = Mage::getModel('customer/address')->load($shippingData->getData('customer_address_id'));
			$shipping_landmark = $address->getData('landmark');
			$shipping_landline = $address->getData('telephonetwo');
		}
		else {
			$shippingId = $order->getShippingAddress()->getId();
			$address = Mage::getModel('sales/order_address')->load($shippingId);
			$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
			$shipping_landmark = $data['landmark'];
			$shipping_landline = $data['telephonetwo'];
		}
		/*
		$shippingId = $order->getShippingAddress()->getId();
		$address = Mage::getModel('sales/order_address')->load($shippingId);
		$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
		$shipping_landmark = $data['landmark'];
		$shipping_landline = $data['telephonetwo'];*/
		$billingAddress = $order->getBillingAddress();
		$billAddress = $billingAddress->getName() . " " . $billingAddress->getData("company") . " " . $billingAddress->getData("street") . " " . $billingAddress->getData("postcode") . " " . $billingAddress->getData("city") . " " . $billingAddress->getRegionCode() . " " . $billingAddress->getRegion() . " " . $billingAddress->getCountry() . " " . $billingAddress->getCountryModel()->getName() . " " . $billingAddress->getData("telephone");
		$shipAddress = $shippingAddress->getName() . " " . $shippingAddress->getData("company") . " " . $shippingAddress->getData("street") . " " . $shippingAddress->getData("postcode") . " " . $shippingAddress->getData("city") . " " . $shippingAddress->getRegionCode() . " " . $shippingAddress->getRegion() . " " . $shippingAddress->getCountry() . " " . $shippingAddress->getCountryModel()->getName() . " " . $shippingAddress->getData("telephone");
		return array(
			$order->getRealOrderId() ,
			Mage::helper('core')->formatDate($order->getCreatedAt() , 'medium', true) ,
			$billingAddress->getName() ,
			$shippingAddress ? $shippingAddress->getName() : '',
			$billAddress,
			$billingAddress->getData("city") ,
			$billingAddress->getRegion() ,
			$billingAddress->getRegion() ,
			$billingAddress->getData("postcode") ,
			$billing_landmark,
			$billing_landline,
			$shipAddress,
			$shippingAddress->getData("telephone") ,
			$shipping_landmark,
			$shipping_landline,
			$this->getPaymentMethod($order) ,
			$this->getPaymentMethod($order) ,
			/*$this->getTotalQtyItemsOrdered($order),*/
			$order->getStatus() ,
		);
	}
	/**
	 * Returns the item specific values.
	 *
	 * @param Mage_Sales_Model_Order_Item $item The item to get values from
	 * @param Mage_Sales_Model_Order $order The order the item belongs to
	 * @return Array The array containing the item specific values
	 */
	protected function getOrderItemValues($item, $order, $itemInc = 1, $stockno,$price,$specialprice)
	{
		$price = $item->getData('custom_original_price');
		$custom_price = $item->getData('custom_price');
		//$price=$price*$item->getData('qty_ordered');

		//$specialprice=$specialprice;
		//$specialprice = $item->getData('custom_special_price');
		// if($custom_price!=$specialprice){
		// }
			$specialprice = $price-($item->getData('discount_amount')/($item->getData('qty_ordered')));
			$bsp = $item->getData('price_incl_tax');
		// echo '<pre>';
		// print_r($item->getData());
		// exit;
		if(!is_numeric($this->getItemSku($item))){
			
			$sku = $stockno;
			$stockno = $this->getItemSku($item);
		}
		else{
			$sku = $this->getItemSku($item);
		}
		//$specialprice = $_product->getData('special_price');
		//	if($specialprice=='0'){$specialprice='N/A';}
		return array(
			$bsp,
			$price,
			$sku,
			$this->getItemOptions($item) ,
			(int)$item->getQtyShipped() ,
			$stockno,
			(int)$item->getData('qty_ordered') ,
		);
	}

	/*
	 * Returns the item specific values.
	 * @param Mage_Sales_Model_Order_Invoice
	 * @return Array The array containing the invoice values
	 *
	 */

	protected function getInvoiceValuesFromOrder($order)
	{
		$orderId = $order->getData('order_id');
		$orderObject = Mage::getModel('sales/order')->load($orderId);
		// echo '<pre>';
		// print_r($order->getData());
		// exit;
		$coupon_code = $orderObject->getData('coupon_code');
		$originalprice = $order->getData('custom_original_price');
		$orderprice = $order->getData('custom_price');
		// $orderprice = $order->getData('custom_special_price');
		$qty=$order->getData('qty_ordered');
		$coupondiscount = $order->getData('discount_amount');
		$tax_percent = $order->getData('tax_percent');
		$pricediscount = ($originalprice - $orderprice)*$qty;
		$rowtotal=(($order->getData('base_row_total_incl_tax'))-($order->getData('discount_amount')));

		$coupon_check = substr($coupon_code, 0, 2);
		
		//exit;
		$totaldiscount = ($pricediscount + $coupondiscount);
		$ordersku=$this->getItemSku($order);
		$parent_ids = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($child_id);

		$obj = Mage::getModel('catalog/product');
		$_product = $obj->load($parent_ids);
		
		$price = $_product->getData('price');
		$specialprice = $_product->getData('special_price');
		if($specialprice==''){$specialprice='N/A';}
			
		if($specialprice=='N/A'){$discountinformation=$order->getData('discount_amount')*$qty;}
		else{
		/*	$taxinformation=$order->getData('tax_amount');
			$taxinformation=$taxinformation+($price-$specialprice);*/
			if($order->getData('discount_amount')==0){$discountinformation=0;}
			else{$discountinformation=$order->getData('discount_amount');}
			$discountinformation=$discountinformation+($price*$qty-$specialprice*$qty);
			//$discountinformation='special_price product';
		}
		$tax = $order->getData('tax_amount');
		if($coupon_check=='SR'){

			$sales_return_tax = ($rowtotal+$coupondiscount)*$tax_percent/(100+$tax_percent);
			$tax = sprintf("%.2f",$sales_return_tax);
			// echo $sales_return_tax;
			// echo $tax_percent;
			// echo $rowtotal+$coupondiscount;
			// exit;
			//$tax = $order->getData('tax_amount');			
		}
		if($tax=='0'){
			//$tax='tax class required';
			$product =  Mage::getModel('catalog/product')->loadByAttribute('sku',$ordersku);
			$resource = Mage::getSingleton('core/resource');
			$readConnection = $resource->getConnection('core_read');
			
			$query = 'SELECT tax_calculation_rate_id FROM ' .$resource->getTableName('tax_calculation') . ' WHERE product_tax_class_id = '
			. (int)$product->getData('tax_class_id') . ' LIMIT 1';

			$data = $readConnection->fetchOne($query);
			$query = 'SELECT rate FROM ' .$resource->getTableName('tax_calculation_rate') . ' WHERE tax_calculation_rate_id = '
			. (int)$data . ' LIMIT 1';
			$vat = $readConnection->fetchOne($query);
			
			$tax= sprintf("%.2f", ($rowtotal * $vat)/(100+$vat));
	}
		//$rowtotal=$rowtotal*$order->getData('qty_ordered');
		return array(
			//$price,
			//$specialprice,
			$rowtotal,
			$pricediscount,
			$coupon_code,
			$coupondiscount,
			$totaldiscount,
			//$discountinformation,
			$tax,
			
		);

	}
	/*
	 author-samir rath
	 * Returns the item specific values.
	 *
	 * @param Mage_Sales_Model_Order_Invoice
	 * @return Array The array containing the invoice values
	 */
	protected function getInvoiceValues($invoice)
	{
		return array(
			$invoice->getIncrementId() ,
			date('M d,Y', strtotime($invoice->getCreatedAt())) ,
			round($invoice->getGrandTotal()) ,
		);
	}
	/*
	 author-samir rath
	 * Returns the item specific values.
	 *
	 * @param Mage_Sales_Model_Order_Shipment_Track
	 * @return Array The array containing the shipment values
	 */
	protected function getShipmentValues($shipmentTracking)
	{
		return array(
			$shipmentTracking->getTitle() ,
			$shipmentTracking->getTrackNumber() ,
			date('M d,Y', strtotime($shipmentTracking->getCreatedAt())) ,
		);
	}
	protected function getShipmentValuesfromdirect($order)
	{
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$tableName = $resource->getTableName('order_ship_track');
		// $query = 'SELECT * FROM ' . $resource->getTableName('order_ship_track');
		$query = 'SELECT * FROM ' . $tableName . ' WHERE order_id = ' . (int)$order->getId() . ' LIMIT 1';
		$results = $readConnection->fetchAll($query);
		if (!empty($results)) {
			return array(
				$results[0]['carrier'],
				$results[0]['track_no'],
			);
		}
		else {
			return false;
		}
	}

   /**
	 * Returns the credit memo related item specific values.
	 * 
	 */
    protected function getCreditMemoItemValues($item, $order, $itemInc=1) 
    {	
    	$orderId = $order->getData('order_id');
   	  	$creditmemo = Mage::getResourceModel('sales/order_creditmemo_collection')
                ->setOrderFilter($order->getId())
                ->load();
        $qty = $item->getQtyRefunded();
        if($qty==0){$qty ='';}
        $orderqty = $item->getQtyOrdered();
        $shippedqty = $item->getQtyShipped();
        $ordersku = $item->getSku();
      //  $rowtotal =
        $orgprice = $item->getData('price_incl_tax');

        $increment_id = $creditmemo->getData('increment_id');
        if ($item->getQtyRefunded()!=0) {
        	$creditmemono = $increment_id[0]['increment_id'];
        	$created_at =  Mage::helper('core')->formatDate($increment_id[0]['created_at'], 'medium', true);
           	$originalprice = $item->getData('custom_original_price');
        	//$specialprice = $item->getData('custom_special_price');
        	$specialprice = $item->getData('price_incl_tax');
        	$peritemdiscount = $item->getData('discount_amount')/$orderqty;
        	$discount_amount = $item->getData('discount_amount');
        	$peritemtax = $item->getTaxAmount() / $shippedqty;
        //	$cmoriginalprice = $item->getData('custom_original_price')*$orderqty;
        	$cmspecialprice = $item->getData('price_incl_tax')*$orderqty;
        	//credit memo original price
        	$cmoriginalprice = ($item->getData('custom_original_price'))*($item->getQtyRefunded());
           	$netvalueperitem=(($item->getData('row_total_incl_tax'))-($item->getData('discount_amount'))) / $orderqty;
        	$netvalue = $netvalueperitem * $qty;

        	if($peritemtax=='0'){
			//$tax='tax class required';
				$product =  Mage::getModel('catalog/product')->loadByAttribute('sku',$ordersku);
				$resource = Mage::getSingleton('core/resource');
				$readConnection = $resource->getConnection('core_read');
				
				$query = 'SELECT tax_calculation_rate_id FROM ' .$resource->getTableName('tax_calculation') . ' WHERE product_tax_class_id = '
				. (int)$product->getData('tax_class_id') . ' LIMIT 1';

				$data = $readConnection->fetchOne($query);
				$query = 'SELECT rate FROM ' .$resource->getTableName('tax_calculation_rate') . ' WHERE tax_calculation_rate_id = '
				. (int)$data . ' LIMIT 1';

				$vat = $readConnection->fetchOne($query);
				
				$peritemtax = sprintf("%.2f", ($specialprice * $vat)/(100+$vat));
	        	//$peritemtax = $specialprice;
			}

        	$tax = $peritemtax * $qty;
        	$totaldiscount = (($originalprice - $specialprice)*$orderqty)+ $discount_amount;
        	$cmdiscount = ($totaldiscount/$shippedqty)* ($item->getQtyRefunded());
        	$creditmemospecialprice = $originalprice - $totaldiscount;
        	$netvalue = $cmoriginalprice - $cmdiscount;
        }  
        return array(
            $creditmemono,
            $created_at,
            $qty,
            $cmoriginalprice,
            $cmdiscount,
            $tax,
            $netvalue,
            $specialprice,
            $originalprice,
        );
    }
}
?>