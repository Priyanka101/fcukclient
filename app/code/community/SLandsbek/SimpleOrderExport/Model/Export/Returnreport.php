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

class SLandsbek_SimpleOrderExport_Model_Export_Returnreport extends SLandsbek_SimpleOrderExport_Model_Export_Abstract
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
        $fileName = 'Return_report_'.date("Ymd_His").'.csv';
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
		
		
		echo '<pre>';
		$creditmemodatas = $order->getCreditmemosCollection()->getData();
		
		foreach($creditmemodatas as $creditmemodata){
		
		$creditmemoarray[]='';
		$creditmemoarray[]='';
		$creditmemoarray[]=$creditmemodata['increment_id'];
		$creditmemoarray[]=$creditmemodata['updated_at'];
		$creditmemoarray[]='';
		$creditmemoarray[]=$creditmemodata['grand_total'];
		$creditmemoarray[]='';
		$creditmemoarray[]='';
		
		}
		
		
		exit;
		$billingAddress = $order->getBillingAddress();
		print_r($billingAddress->getData());
		
		
    $customerData = Mage::getModel('customer/customer')->load($billingAddress->getData('customer_id'))->getData();
    print_r($customerData);
		
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
		$invoiceprice = 0;
		
		
		if(!empty($invoices_data)){
		
		 foreach($invoices as $invoice){
		 $invoiceArray = $this->getInvoiceValues($invoice);
		 $invoiceArray[] = $invoices_data[0]['increment_id'];
		 $invoiceprice =  $invoice->getGrandTotal();
		 
		 }
		 }else{
		 $invoiceArray[] = '';
		 $invoiceArray[] ='';
		 $invoiceprice = 0;
		 
		 }
		 
		 
		 
		$paymentmethod[] = $this->getPaymentMethod($order);
		$order_date[] = Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', true);
		 
		 
		 $shipment_data = $realShipments->getData();
		if(!empty($shipment_data)){
		
		 foreach($realShipments as $shipment){ 
		 $shipmentArray = $this->getShipmentValues($shipment , $order);
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
		 $categorytitle ='';
		 $stockno = '';
		 $productprice = 0;
        foreach ($orderItems as $item)
        {
			$_newProduct = Mage::getModel('catalog/product')->load($item->getData('product_id'));
			if($item->getData('product_type')=='configurable'){
	 		 	$titlenew = $this->getOrderItemTitle($item);
		   		$itemtitle = $itemtitle.$titlenew." , ";
				$weght = $this->getOrderItemWeight($item);
				$itemweight = $itemweight + $weght ;
				$qt = $this->getOrderItemQuentity($item);
				$itemqty = $itemqty + $qt ;
				
				//get category name
				
			 	 $cats = $_newProduct->getCategoryIds();
			
				if(!empty($cats)){
					$category = Mage::getModel('catalog/category')->load($cats[0]);
				 	$categorytitle =  $categorytitle.$category->getData('name')." , ";
				}
				
			}
			else if($item->getData('product_type') == 'simple'){
					$stockno = $stockno.$_newProduct->getData('stockno')." , ";
					$productprice = $productprice + $_newProduct->getData('price');
				
				}
		}
		
		$itemtitleArray[] = $itemtitle;
		$itemqtyArray[] = $itemqty;
		$itemweightArray[] = $itemweight."grms";
		$categorytitleArray[] = $categorytitle;
		$brands[] = 'Fcuk';
		$stocknoArray[] = $stockno;
		$mrpArry[] =  $productprice;
		
		if($invoiceprice!=''){
			$discountArray[] = $productprice - $invoiceprice;
		}else{
			$discountArray[] = '';
		}
		
		$coupon_codeArray[]=$order->getData('coupon_code');
		$formulaArray[] = $order->getData('coupon_rule_name');
		$assign_dateArray[] = '';
		$w_hArray[]='Bhivandi';
		
		$creditmemodatas = $order->getCreditmemosCollection()->getData();
		
		foreach($creditmemodatas as $creditmemodata){
			$creditmemoarray[]='';
			$creditmemoarray[]='';
			$creditmemoarray[]=$creditmemodata['increment_id'];
			$creditmemoarray[]=$creditmemodata['updated_at'];
			$creditmemoarray[]=$itemqtyArray[0];
			$creditmemoarray[]=$creditmemodata['grand_total'];
			$creditmemoarray[]='';
			$creditmemoarray[]='';
		}
		
		
		$record = array_merge($common,/*$categorytitleArray,$brands,$mrpArry,$stocknoArray,$itemtitleArray ,$itemweightArray ,*/$itemqtyArray ,$invoiceArray, /*$paymentmethod,$discountArray,$coupon_codeArray,$formulaArray,$assign_dateArray,$w_hArray,*/$shipmentArray, $airwaybillnoArray,$creditmemoarray);
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
			'Qty',
			'INVOICE VALUE',
			'Invoice No',
			'TRANSPORTER',
			'GCN NO.',
			'RECD DATE',
			'RETURN TYPE',
			'RETURN DOC.NO.',
			'DOC.DATE',
			'QTY',
			'INVOICE VALUE',
			'TRANSPORTER ',
			'GCN NO.',
			
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
		
		
		/*
		$shippingId = $order->getShippingAddress()->getId();
		$address = Mage::getModel('sales/order_address')->load($shippingId);
		$data = Mage::getModel('customer/address')->load($address->getData('customer_address_id'));
		$shipping_landmark = $data['landmark'];
		$shipping_landline = $data['telephonetwo'];*/
		
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
		
		$CustomerEmail = $shippingAddress->getEmail();
		if($CustomerEmail == '')
		{
			$CustomerEmail = $billingAddress->getEmail();
			if($CustomerEmail==''){
				
				$customerData = Mage::getModel('customer/customer')->load($billingAddress->getData('customer_id'))->getData();
				$CustomerEmail = $customerData['email'];
			}
		}
			
		
		
        return array(
			Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', false),
			$order->getRealOrderId(),
			/*$order->getStatus(), */
			
			/*date("M.y", strtotime(Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', 'false'))),*/
		/*	$transactionNo,*/
         /*   Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', true),
            $billingAddress->getName(), */
		/*	$CustomerEmail,
			$shippingAddress ? $shippingAddress->getName() : '',*/
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
	 protected function getShipmentValues($shipmentTracking,$order) 
    {
		$shipmentData = $order->getShipmentsCollection()->getData();
	         return array(
			/* $shipmentData[0]['increment_id'],
			 date('M d,Y', strtotime($shipmentTracking->getCreatedAt())),*/
			 $shipmentTracking->getTitle(),
			 
        );
    }
	
	protected function getAirwaybillno($shipmentTracking){
		
		 return array(
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
			/*$results[0]['shipping_date'] = '';
			$results[0]['shipping_id'] = '';*/
        return array(
			 /*$results[0]['shipping_id'],
			 $results[0]['shipping_date'],*/
			 $results[0]['carrier'],
			 
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
			 $results[0]['track_no'],
		);
		}else{
			return false;
		}
    }
	
	
}

?>