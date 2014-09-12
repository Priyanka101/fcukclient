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

class SLandsbek_SimpleOrderExport_Model_Export_Financereport extends SLandsbek_SimpleOrderExport_Model_Export_Abstract
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
        $fileName = 'finance_export_'.date("Ymd_His").'.csv';
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
		//echo '<pre>';print_r($common);exit;
		//echo strtolower($common[8]);exit;
		
		
		$invoices = Mage::getResourceModel('sales/order_invoice_collection')
                ->setOrderFilter($order->getId())
                ->load();
		//echo $invoices->getSelect();exit;
		$realShipments = Mage::getModel('sales/order_shipment_track')->getCollection()
                      ->addFieldToFilter('order_id',$order->getId())
					  ->addAttributeToSelect('*');

        $orderItems = $order->getItemsCollection();
		//echo $orderItems->getSelect();exit;
        $itemInc = 0;
		$invoiceInc=0;
		$invoices_data = $invoices->getData();
		$invoiceprice = 0;
		$invoiceDiscount = 0;
		
		if(!empty($invoices_data)){
		
		 foreach($invoices as $invoice){
		 //$invoiceArray = $this->getInvoiceValues($invoice);
		 //var_dump($invoiceArray);exit;
		 //var_dump($this->getInvoiceValues($invoice));exit;
		 $invoiceArray[] = $invoices_data[0]['increment_id'];
		 $createdDate = $invoice->getCreatedAt();
		 $invoiceprice =  $invoice->getGrandTotal();
		 $invoice_mrp = $invoice->getData('base_subtotal_incl_tax');  //kishan
		 //var_dump($invoice_mrp);
		 $invoiceDiscount = $invoice->getData('base_discount_amount');  //kishan
		 //$taxvalueTotal = $invoice->getData('base_tax_amount');	//kishan
		 }
		 }else{
		 $invoiceArray[] = '';
		 $invoiceArray[] ='';
		 $invoiceprice = 0;
		 
		 }
		
		  //echo '<pre>';print_r($invoices->getData());exit;
		 
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
		 //$productprice = 0;
		
        foreach ($orderItems as $item)
        {
        	if($item->getData('product_type')=='configurable'){

        		$sqty+=$item->getData('qty_shipped');
        	//	$totaltax+=$item->getData('tax_amount');
            }
			
			$_newProduct = Mage::getModel('catalog/product')->load($item->getData('product_id'));
				if($item->getData('product_type')=='simple'){
					$titlenew = $this->getOrderItemTitle($item);
					if($titlenew !="") {
						$itemtitle = $itemtitle.$titlenew." , ";/*--kishan--*/
					 } 
				
				}
	 		
		   		
				$mrp = $mrp+floatval($item['base_row_total_incl_tax']);/*--kishan--*/
				//var_dump(intval($item['base_discount_amount']));exit;
				$discount = $discount+floatval($item['base_discount_amount']);/*--kishan--*/
				$tax = $tax+floatval($item['base_tax_amount']);
				
		//	if(){}
				/*kishan*/
				/*echo '<pre>';
				print_r($item->getData('qty_shipped'));
				exit;*/
			if($item->getData('product_type')=='configurable'){

				 $titlenew = $this->getOrderItemTitle($item);
				 $itemtitle = $itemtitle.$titlenew." , ";
				
				//get category name
				$cats = $_newProduct->getCategoryIds();


				if(!empty($cats)){
				//	print_r($cats);
					$categoryCount=count($cats);
					$category = Mage::getModel('catalog/category')->load($cats[$categoryCount-1]);
					$parentId=Mage::getModel('catalog/category')->load($cats[$categoryCount-1])->getParentId();
					$pcategory = Mage::getModel('catalog/category')->load($parentId);
					$parentCategoryName=$pcategory->getData('name');
					//var_dump($parentCategoryName);
					if(trim($parentCategoryName)=='Category'){
						$categoryParentId=Mage::getModel('catalog/category')->load($pcategory->getId())->getParentId();
						$parentCategory = Mage::getModel('catalog/category')->load($categoryParentId);
						$parentCategoryName=$parentCategory->getData('name');
						//$parentCategoryName=$pcategory->getData('name');
						//$pcategory = Mage::getModel('catalog/category')->load($parentId);
					}
					if($category->getData('name')!='Category'){
						$categorytitle =  $categorytitle.$parentCategoryName.' '.$category->getData('name')." , ";
					}
				}


				

				$productprice = ($productprice + $item->getData('price')*$qty);
				
			}
			else if($item->getData('product_type')=='simple'){
				$qt = $item->getQtyOrdered();/*written by shaily*/
				$itemqty = $itemqty + $qt ;
				
				$weght = $this->getOrderItemWeight($item);
				$itemweight = $itemweight + $weght ;
				$productcode=$item['sku'];//code 
				//var_dump(is_numeric($item['sku']));

				if(is_numeric($productcode)){
				 $stockno = $stockno.$_newProduct->getData('sku')." , ";}
				else{

					$attr =  Mage::getModel('catalog/product')->loadByAttribute('sku',$productcode);
					$stockno = $stockno.$_newProduct->getData('sku')." , ";

				}
				/*$attr =  Mage::getModel('catalog/product')->loadByAttribute('sku',$productcode);
				$stockno = $stockno.$_newProduct->getData('sku')." , "; */
				
				$productprice = ($productprice + $item->getData('price')*$qty);

				}
				
				
		}
		$shippedqtynew[]=$sqty;
		//
		$order2 = Mage::getModel('sales/order')->load($order->getId());
		$items = $order2->getAllItems();
		//$_totalData = $order->getData();
		/*echo '<pre>';	
			print_r($order->getData('base_total_invoiced'));
		exit;*/
			
			$totaltaxnew[]=$order->getData('tax_amount');
			$order_id = $order->getId(); //use your own order id
			$order = Mage::getModel("sales/order")->load($order_id); //load order by order id
			$ordered_items = $order->getAllItems();
			$specialprice=0;
			//echo "<pre>";
			//print_r($order->getAllItems());
			//print_r($qty_orderedArray);
			//exit;
			$skucounter=0;
			foreach($ordered_items as $item){
			//item detail
				//print_r($item->getData('product_type'));
					if($item->getData('product_type')=='configurable'){
						$sku=$item->getData('sku');
						$qty_ordered=$item->getData('qty_ordered');
						$itemsArray[$skucounter]=$sku;
						$qty_orderedArray[$skucounter]=$qty_ordered;
						$skucounter++;
					}
				$qty_ordered=$item->getData('qty_ordered');
				$attr =  Mage::getModel('catalog/product')->loadByAttribute('sku',$sku);
				$product_id = Mage::getModel('catalog/product')->getIdBySku($sku);
				$parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($product_id);
				if (isset($parentIds[0])) {
				    $product = Mage::getModel('catalog/product')->load($parentIds[0]);
				    $specialprice+=$product->getData('special_price');
				  /*  if($product->getData('product_type')=='simple'){

				     $originalprice=$product->getData();
				    }*/

				}
				elseif($item->getData('product_type')=='simple'){
						$sku=$item->getData('sku');
						$qty_ordered=$item->getData('qty_ordered');
						$itemsArray[$skucounter]=$sku;
						$qty_orderedArray[$skucounter]=$qty_ordered;
						$skucounter++;
				}

				
				/*$qty_orderedArray[]=$qty_ordered;*/
			//	$qty_orderedArray[]=array_unique($qty_orderedArray);
			// etc.
			}
			/*print_r($specialprice);*/
		
		
		/*exit;*/
	//	$itemsArray=array_merge((array)$itemsArray,(array)$qty_orderedArray);

		$indexcounter=0;
		foreach(array_unique($itemsArray) as $productid){

		 $_Pdetails = Mage::getModel('catalog/product')->loadByAttribute('sku',$productid);
		
		// $_Pdetails->getPrice();
		 $productprice = $_Pdetails->getData('price');
		// print_r($_Pdetails->getData());
		 $totalprice=($productprice*($qty_orderedArray[$indexcounter]));
		//echo '<pre>';
		//echo  $totalprice;
		//exit;
		 $originalprice+=$totalprice;
		 $indexcounter++;

		}

	// 	/*echo $totalpricenew;
	// 	echo "<pre>";print_r($itemsArray);
	// 		exit;*/
	// 	$itemtitleArray[] = $itemtitle;
	// 	$itemqtyArray[] = $itemqty;
	// /*	echo '<pre>';
	// 	print_r($originalprice);*/
	// 	//print_r($shippedqtynew);
	// 	$itemweightArray[] = $itemweight."grms";
	// 	$categorytitleArray[] = $categorytitle;
	// 	$brands[] = 'FCUK';
	// 	$stocknoArray[] = $stockno;
	// 	$createdDateArray[] = $createdDate;
	// 	$specialpriceArray[]=$specialprice;
	// 	$mrpArry[] =  $mrp;  //kishan
	// 	$taxPercentage=(($order->getData('base_subtotal_incl_tax')-$discount)/$tax);

	// 	if($taxPercentage==''){
	// 			$taxPer='0 %';
	// 	}
	// 	else
	// 	{

	// 			$taxPer=$taxPercentage.' %';
	// 	}

	// 	if($originalprice==$mrp){
	// 		$discountArray[] = $discount;
	// 	}else{
	// 		$discountArray[] = ($originalprice-$mrp)+$discount;
	// 	}
	// 	//$discountArray[] = $discount; //kishan
	// 	$bspArry[] = $mrp-$discount;
	// 	$originalPriceArray[] =$originalprice;

	// 	// $basicsale[]= $order->getData('price_inc_tax');		
	// 	$basicsale[]= $mrp;		
	// 	$coupon_codeArray[]=$order->getData('coupon_code');
	// 	$coupon_amtArray[]=$order->getData('base_discount_amount');
	// 	$formulaArray[] = $order->getData('coupon_rule_name');
	// 	$assign_dateArray[] = '';
	// 	$w_hArray[]='Bhivandi';
	// 	$taxarray[]=$tax;
	// 	$taxperarray[]=$taxPer;
	// 	$state = strtolower($common[6]);
	// 	//$tax_type[0] = 'CST';
	// 	//echo $state.''.$tax_type[0];
	// 	//exit;
	// 	if(strtolower($state) == 'maharashtra') {$tax_type[0] = 'VAT';}
	// 	else{$tax_type[0] = 'CST';}

	// 	/*----kishan---*/
	// 	$shipCount = count($shipmentArray)-1;
	// 	if($shipCount == 3)
	// 	{
	// 		array_pop($shipmentArray);
	// 	}
	// //	exit;
	// 	if(count($invoiceArray)==2)
	// 	{array_pop($invoiceArray);}

	//exit;
		//$record = array_merge($common,$categorytitleArray,$brands,$stocknoArray,$mrpArry,$itemtitleArray ,$itemweightArray ,$itemqtyArray ,$bspArry,$invoiceArray,$paymentmethod,$discountArray,$coupon_codeArray,$formulaArray,$assign_dateArray,$w_hArray,$shipmentArray,$airwaybillnoArray,$tax_type,$taxarray);
		$record = array_merge($common,$categorytitleArray,$brands,$stocknoArray,$itemtitleArray,$itemweightArray,$itemqtyArray,$shippedqtynew,$invoiceArray,$createdDateArray,$originalPriceArray,$mrpArry,$discountArray,$basicsale,$totaltaxnew,$bspArry,$coupon_codeArray,$coupon_amtArray,$formulaArray,$taxperarray,$tax_type,$shipmentArray,$airwaybillnoArray);
          /*  print_r($record);
            exit;*/
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
		    'Order Number',
		    'Order Date',
		   	/*'Month',*/
            'Bill to name',
			'Ship to Name',
			'Order Location',
			'Zone',
			'Region',
			'Pincode #',
			'Payment Type',
			'Status',
          	'Category',
			'Brand',
			'Stock Number',
            'Sku_name',
            /*'MRP',*/
			'Weight',
			'Order Quantity',
			'Shipping Quantity',
			/*'BSP',*/
			'Invoice Id',
			'Invoice Date',
			/*'Method',*/
			'Original MRP',
			'MRP',
			'Discount_Amount',
			'Basic Sale',
			'TAX Amt',
			'Bill Value',
			'Coupon_Code',
			'Coupon Amt',
			'Formula',
			'Tax %',
			'Tax Type',
			'Courier',
			'AWB No',
			/*'Tax Amount',*/
						
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
		// echo '<pre>';
		// print_r($order->getPayment()->getMethodInstance()->getCode());
		// exit;
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
			$zone='';
		
		
        return array(
			$order->getRealOrderId(),
			Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', false),
			//date("M.y", strtotime(Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', 'false'))),
		/*	$transactionNo,*/
         /*   Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', true),
            $billingAddress->getName(), */
			//$CustomerEmail,
			$billingAddress ? $billingAddress->getName() : '',
			$shippingAddress ? $shippingAddress->getName() : '',
			$billingAddress->getData("city"),
			$zone,
			$billingAddress->getRegion(),
			$shippingAddress->getData("postcode"),
			$this->getPaymentMethod($order),
		//	$order->getPayment()->getMethodInstance()->getCode(),
			$order->getStatus(),
           /* $billAddress,
            $billingAddress->getData("city"),
            $billingAddress->getRegion(),
            $billingAddress->getRegion(),
			$billingAddress->getData("postcode"),
			$billing_landmark,
			$billing_landline, */
			//$shipAddress,
			//$shippingAddress->getData("city"),
			//$shippingAddress->getRegion(),
			//$country_name,			
		//	$shippingAddress->getData("telephone"),
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
	
	
	/*
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
			// $shipmentData[0]['increment_id'],
			// date('M d,Y', strtotime($shipmentTracking->getCreatedAt())),
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
			$results[0]['shipping_date'] = '';
			$results[0]['shipping_id'] = '';
        return array(
			// $results[0]['shipping_id'],
			// $results[0]['shipping_date'],
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