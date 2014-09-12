<?php

class Fcuk_Outwardregister_Adminhtml_OutwardregisterController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('outwardregister/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('outwardregister/outwardregister')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('outwardregister_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('outwardregister/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('outwardregister/adminhtml_outwardregister_edit'))
				->_addLeft($this->getLayout()->createBlock('outwardregister/adminhtml_outwardregister_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outwardregister')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
	
	public function saveAction(){
		$dataCollection = '';
		if ($data = $this->getRequest()->getPost()) {
			
			
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
				
				/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					// Only *.csv extention would work
	           		$uploader->setAllowedExtensions(array('csv'));
					$uploader->setAllowRenameFiles(false);
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ."outward" .DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					$csv = new Varien_File_Csv();
					$dataCollection = $csv->getData($path.$_FILES['filename']['name']); //path to csv
					array_shift($dataCollection);
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}
			
			if(empty($dataCollection)){
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outwardregister')->__('File is Empty'));
        		$this->_redirect('*/*/');
				return false;
			}
			
			if($this->getRequest()->getParam('id')){
				
				
			$helperdata = Mage::helper('outwardregister');
				if($helperdata->_checkUpdatestock($dataCollection,$this->getRequest()->getParam('id'))){
					}else{
						Mage::getSingleton('adminhtml/session')->addError("Outward Not Edit");
						$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						return false;
					}
				
				
				}
		if(!$this->getRequest()->getParam('id')){
				$helperdata = Mage::helper('outwardregister');
				if($helperdata->_checkUpdatestocknew($dataCollection)){
					
					}else{
						
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outwardregister')->__('Outward not save'));
						$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						$this->_redirect('*/*/');
						return false;
					}
				
				}
			$model = Mage::getModel('outwardregister/outwardregister');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				$outwardregister_id = $model->getId();
				
				if(!$this->getRequest()->getParam('id')){
				$modelnew = Mage::getModel('outwardregister/outwardregister');
				$modelnew->setDocNumber($outwardregister_id);
				$modelnew->setId($outwardregister_id);
				$modelnew->save();
				
				$message = '';
				$count   = 1;
				$helperdata = Mage::helper('outwardregister');
				
				
				foreach($dataCollection as $_data){
					
					if($helperdata->_checkIfSkuExists($_data[0])){
						try{
							
							$helperdata->_updateStocks($_data);
							$helperdata->_addDataProduct($_data , $outwardregister_id);
							
						}catch(Exception $e){
							$message .=  $count .'> Error:: while Upating  Qty (' . $_data[2] . ') of Sku (' . $_data[0] . ') => '.$e->getMessage().'<br />';
						}
					}
					
					$count++;
				}
				}else{
					
					$outwardregister_id = $this->getRequest()->getParam('id');
					$message = '';
				$count   = 1;
				$helperdata = Mage::helper('outwardregister');
				foreach($dataCollection as $_data){
					
					if($helperdata->_checkIfSkuExists($_data[0])){
						
						try{
							
							$helperdata->_updateStocksedit($_data , $outwardregister_id);
							$helperdata->_addDataProductedit($_data , $outwardregister_id);
							//$helperdata->_updatePrice($_data);
						}catch(Exception $e){
							$message .=  $count .'> Error:: while Upating  Qty (' . $_data[2] . ') of Sku (' . $_data[0] . ') => '.$e->getMessage().'<br />';
						}
					}
					
					$count++;
				}
					
					
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('inwardregister')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
			
			
		}
		
		 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outwardregister')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function saveoldAction() {
		if ($data = $this->getRequest()->getPost()) {
			$helperdata = Mage::helper('outwardregister');
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('csv'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					
					$path = Mage::getBaseDir('media') . DS ."outward" .DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
				$csv                = new Varien_File_Csv();
				$data               = $csv->getData($path.$data['filename']); //path to csv
				array_shift($data);
				$message = '';
				$count   = 1;
				
				foreach($data as $_data){
					if($helperdata->_checkIfSkuExists($_data[0])){
						try{
							$helperdata->_updateStocks($_data);
							//$helperdata->_addData($_data);
							$message .= $count . '> Success:: Qty (' . $_data[1] . ') of Sku (' . $_data[0] . ') has been updated. <br />';
				 
						}catch(Exception $e){
							$message .=  $count .'> Error:: while Upating  Qty (' . $_data[1] . ') of Sku (' . $_data[0] . ') => '.$e->getMessage().'<br />';
						}
					}else{
						$message .=  $count .'> Error:: Product with Sku (' . $_data[0] . ') does\'t exist.<br />';
					}
					
					$count++;
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('inwardregister')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/');
				return;
				
				
			}
	  			
	  		exit;	
			$model = Mage::getModel('outwardregister/outwardregister');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('outwardregister')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outwardregister')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			
			
		$helperdata = Mage::helper('outwardregister');
			if($helperdata->checkDelete($this->getRequest()->getParam('id'))){	
			
			try {
				$helperdata->deleteOutward($this->getRequest()->getParam('id'));
				$model = Mage::getModel('outwardregister/outwardregister');
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			
		}else{
			Mage::getSingleton('adminhtml/session')->addError("Outward Not Delete");
			$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			return false;
		}
				
			
			
			
			
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $outwardregisterIds = $this->getRequest()->getParam('outwardregister');
        if(!is_array($outwardregisterIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($outwardregisterIds as $outwardregisterId) {
                    $outwardregister = Mage::getModel('outwardregister/outwardregister')->load($outwardregisterId);
                    $outwardregister->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($outwardregisterIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $outwardregisterIds = $this->getRequest()->getParam('outwardregister');
        if(!is_array($outwardregisterIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($outwardregisterIds as $outwardregisterId) {
                    $outwardregister = Mage::getSingleton('outwardregister/outwardregister')
                        ->load($outwardregisterId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($outwardregisterIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'outwardregister.csv';
        $content    = $this->getLayout()->createBlock('outwardregister/adminhtml_outwardregister_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'outwardregister.xml';
        $content    = $this->getLayout()->createBlock('outwardregister/adminhtml_outwardregister_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
	
	public function outwardreportAction(){
		
		 $this->loadLayout()
            ->_setActiveMenu('outwardregister')
            ->_title($this->__('Outward Report'));
 
        // my stuff
 
        $this->renderLayout();
	}
	
	public function pdfoutward5_4_2013Action(){
		
		require_once('Tcpdf/config/lang/eng.php');
		require_once('Tcpdf/tcpdf.php');
		
		
		$from = $this->getRequest()->getPost('from');
		$to = $this->getRequest()->getPost('to');
		
		$collections = Mage::getModel('outwardregister/outwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('dc_date', array('from' => $from , 'to' => $to));
		
		
		$j=1;
		$totalQty = 0;
		$html = '<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:center; font-size:30px;font-weight: bold; text-decoration: underline;">Outward Report</td>
  </tr>
</table>';
		foreach($collections as $collection){
			$totalQty = 0;
			$html.='<p>&nbsp;</p><p>'.$j.'</p><table width="960"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="90" style="text-align:center;">Transaction Type</th>
    <th width="90" style="text-align:center;">Chain Store</th>
    <th width="60" style="text-align:center;">Reason Code</th>
    <th width="60" style="text-align:center;">Ref dc/no</th>
    <th width="70" style="text-align:center;">Doc Date</th>
    <th width="120" style="text-align:center;">Doc Remarks</th>
    <th width="60" style="text-align:center;">Doc Prefix</th>
    <th width="60" style="text-align:center;">Doc Number</th>
	<th width="60" style="text-align:center;">Outward Date</th>
  </tr>
  <tr>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('transaction_type').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('chainstore').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('reasoncode').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('refdcno').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('dc_date').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('doc_remarks').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('doc_prefix').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('doc_number').'</td>
	<td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.date('Y-m-d', strtotime($collection->getData('created_time'))).'</td>
  </tr>
  <tr>
    <td colspan="9" >
	
	<p >&nbsp;&nbsp;&nbsp;&nbsp;Stock Detail:</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<table width="700" border="1" style="margin:10px;">
      <tr>
        <th width="50" style="text-align:center; ">No</th>
        <th width="106" style="text-align:center; ">Stock No</th>
       
        <th width="70" style="text-align:center; ">Qty</th>
        <th width="70" style="text-align:center;">Price</th>
        <th width="60" style="text-align:center;">Net Value</th>
      </tr>';
	  $product_collections = Mage::getModel('outwardproduct/outwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('outwardregister_id', array('eq' => $collection->getData('outwardregister_id')));
			$i=1;
			foreach($product_collections as $product_collection){
      $html.='<tr>
        <td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$i.'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('itemsku').'</td>
       
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('qty').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('price').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('total').'</td>
      </tr>';
	  $i++;
	  $totalQty = $totalQty + $product_collection->getData('qty');	
			}
			
    $html.='<tr><td colspan="5" style="text-align:center; font-size:22px;font-weight: normal; " >Total Qty  '.$totalQty.'</td></tr></table></p></td>
  </tr>
</table>';
		$j++;	
			
		}
		
		//echo '<pre>';
		//print_r($collections->getData());
		// <th width="300" style="text-align:center;">Item Description</th>
		// <td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$product_collection->getData('itemdescription').'</td>
		
		
	
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false ,false ,false);
		
		$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('OutwardReport');
		
		$img_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/fcuk/default/images/french_connection_pdf_logo.png";
		$pdf->SetHeaderData($img_url, PDF_HEADER_LOGO_WIDTH);
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(5,5,5,TRUE);
		//set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		$pdf->addPage();

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 7);
	

//$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->writeHTML($html, true, false, false, false, '');
		
		$fileName = 'outwardreport.pdf';
		$pdf->Output($fileName, 'D');
		//return $pdf;
		exit;
		
	}
	
	public function pdfoutwardAction(){
		
		$from = $this->getRequest()->getPost('from');
		$to = $this->getRequest()->getPost('to');
		
		$collections = Mage::getModel('outwardregister/outwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('dc_date', array('from' => $from , 'to' => $to));
		
		require_once('phpexcelnew/Classes/PHPExcel.php');
		
		
		$objPHPExcel = new PHPExcel();

 // Set the active Excel worksheet to sheet 0 
			
		$incrementno = 'A';
		$tansactionType = 'B';
		$Chainstore = 'C';
		$reasonCode = 'D';
		$referenceD_C_no = 'E';
		$dcdate = 'F';
		$doc_remarks = 'G';
		$doc_prefix = 'H';
		$doc_number = 'I';
		$inwardDate = 'J';
		
		
		$stockDetail ='C';
		$no = 'D';
		$stock_no = 'E';
		$UPC_code = 'F';
		$doc_qty = 'G';
		$price = 'H';
		$netValue = 'I';
		
		
		$total_qty_label = 'F';
		$total_qty = 'G';
		
			
		
		$row=1;
		$i=1;
			foreach($collections as $collection){
				
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($incrementno.$row, $i);
			$row++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($tansactionType.$row, 'Transaction Type')
			->setCellValue($Chainstore.$row, 'Chain Store')
			->setCellValue($reasonCode.$row, 'Reason Code')
			->setCellValue($referenceD_C_no.$row, 'Ref dc/no')
			->setCellValue($dcdate.$row, 'Doc date')
			->setCellValue($doc_remarks.$row, 'Doc Remarks')
			->setCellValue($doc_prefix.$row, 'Doc Prefix')
			->setCellValue($doc_number.$row, 'Doc Number ')
			->setCellValue($inwardDate.$row, 'Inward Date');
			$objPHPExcel->getActiveSheet()->getStyle($tansactionType.$row.":".$inwardDate.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			
			
			$row++;
			
			
			
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($tansactionType.$row,$collection->getData('transaction_type'))
           ->setCellValue($Chainstore.$row, $collection->getData('chainstore'))
			->setCellValue($reasonCode.$row, $collection->getData('reasoncode'))
			->setCellValue($referenceD_C_no.$row, $collection->getData('refdcno'))
			->setCellValue($dcdate.$row,$collection->getData('dc_date'))
			->setCellValue($doc_remarks.$row,$collection->getData('doc_remarks'))
			->setCellValue($doc_prefix.$row, $collection->getData('doc_prefix'))
			->setCellValue($doc_number.$row, $collection->getData('doc_number'))
			->setCellValue($inwardDate.$row, date('Y-m-d', strtotime($collection->getData('created_time'))));
	
			
			
			
			$row++;
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue($stockDetail.$row, 'Stock Detail');
			$row++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($no.$row, 'No')
            ->setCellValue($stock_no.$row, 'Stock No')
			->setCellValue($UPC_code.$row, 'UPC code')
			->setCellValue($doc_qty.$row, 'Doc Qty')
			->setCellValue($price.$row, 'Price')
			->setCellValue($netValue.$row, 'Net Value');
			//$objPHPExcel->getActiveSheet()->getStyle($no.$row.":".$netValue.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			
			$row++;
			$totQty = 0;
			
			 $product_collections = Mage::getModel('outwardproduct/outwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('outwardregister_id', array('eq' => $collection->getData('outwardregister_id')));
		
			$j=1;
				foreach($product_collections as $product_collection){
			
					//$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($product_collection->getData('itemsku')))->getData();
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($no.$row, $j)
            ->setCellValue($stock_no.$row, $product_collection->getData('itemsku'))
			->setCellValue($UPC_code.$row, $product_collection->getData('itemdescription'))
			->setCellValue($doc_qty.$row, $product_collection->getData('qty'))
			->setCellValue($price.$row,$product_collection->getData('price'))
			->setCellValue($netValue.$row, $product_collection->getData('total'));
			$totQty = $totQty + $product_collection->getData('qty');
			$row++;
			$j++;
			
					
				}
				$row = $row++;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($total_qty_label.$row, 'Total Qty')
            ->setCellValue($total_qty.$row, $totQty);
			$objPHPExcel->getActiveSheet()->getStyle($total_qty_label.$row.":".$total_qty.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$row = $row+2;
			$i++;
				
			}
			
			
//$objPHPExcel->setActiveSheetIndex(0);  

// Initialise the Excel row number 


// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="outwardreport.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');
			
	exit;		
		
		
		
		
		}
	
	
	public function pdfoutwardnumber5_4_2013Action(){
		
		
		require_once('Tcpdf/config/lang/eng.php');
		require_once('Tcpdf/tcpdf.php');
		
		
		$from = $this->getRequest()->getPost('fromno');
		$to = $this->getRequest()->getPost('tono');
		
		$collections = Mage::getModel('outwardregister/outwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('doc_number', array('from' => $from , 'to' => $to));
	
		$j=1;
		$totalQty = 0;
		$html = '<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:center; font-size:30px;font-weight: bold; text-decoration: underline;">Outward Report</td>
  </tr>
</table>';
		foreach($collections as $collection){
			$totalQty = 0;
			$html.='<p>&nbsp;</p><p>'.$j.'</p><table width="960"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th width="90" style="text-align:center;">Transaction Type</th>
    <th width="90" style="text-align:center;">Chain Store</th>
    <th width="60" style="text-align:center;">Reason Code</th>
    <th width="60" style="text-align:center;">Ref dc/no</th>
    <th width="70" style="text-align:center;">Doc Date</th>
    <th width="120" style="text-align:center;">Doc Remarks</th>
    <th width="60" style="text-align:center;">Doc Prefix</th>
    <th width="60" style="text-align:center;">Doc Number</th>
	<th width="60" style="text-align:center;">Outward Date</th>
  </tr>
  <tr>
     <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('transaction_type').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('chainstore').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('reasoncode').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('refdcno').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('dc_date').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('doc_remarks').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('doc_prefix').'</td>
    <td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.$collection->getData('doc_number').'</td>
	<td style="text-align:center; font-size:22px;font-weight: normal;  color: red;">'.date('Y-m-d', strtotime($collection->getData('created_time'))).'</td>
  </tr>
  <tr>
    <td colspan="9" >
	
	<p >&nbsp;&nbsp;&nbsp;&nbsp;Stock Detail:</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<table width="700" border="1" style="margin:10px;">
      <tr>
        <th width="50" style="text-align:center; ">No</th>
        <th width="106" style="text-align:center; ">Stock No</th>
        
        <th width="70" style="text-align:center; ">Qty</th>
        <th width="70" style="text-align:center;">Price</th>
        <th width="60" style="text-align:center;">Net Value</th>
      </tr>';
	  $product_collections = Mage::getModel('outwardproduct/outwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('outwardregister_id', array('eq' => $collection->getData('outwardregister_id')));
			$i=1;
			foreach($product_collections as $product_collection){
      $html.='<tr>
        <td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$i.'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('itemsku').'</td>
        
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('qty').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('price').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('total').'</td>
      </tr>';
	  $i++;	
	   $totalQty = $totalQty + $product_collection->getData('qty');
			}
			
    $html.='<tr><td colspan="5" style="text-align:center; font-size:22px;font-weight: normal; " >Total Qty  '.$totalQty.'</td></tr></table></p></td>
  </tr>
</table>';
		$j++;	
			
		}
		
		//echo '<pre>';
		//print_r($collections->getData());
		//<th width="300" style="text-align:center;">Item Description</th>
		//<td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$product_collection->getData('itemdescription').'</td>
		
		
	
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false ,false ,false);
		
		$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('OutwardReport');
		
		$img_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN)."frontend/fcuk/default/images/french_connection_pdf_logo.png";
		$pdf->SetHeaderData($img_url, PDF_HEADER_LOGO_WIDTH);
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(5,5,5,TRUE);
		//set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		$pdf->addPage();

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', 'B', 7);
	

//$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->writeHTML($html, true, false, false, false, '');
		
		$fileName = 'outwardreport.pdf';
		$pdf->Output($fileName, 'D');
		//return $pdf;
		exit;
		
	
		}
	public function pdfoutwardnumberAction(){
		
		$from = $this->getRequest()->getPost('fromno');
		$to = $this->getRequest()->getPost('tono');
		
		$collections = Mage::getModel('outwardregister/outwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('doc_number', array('from' => $from , 'to' => $to));
		
		
		require_once('phpexcelnew/Classes/PHPExcel.php');
		
		
		$objPHPExcel = new PHPExcel();

 // Set the active Excel worksheet to sheet 0 
			
		$incrementno = 'A';
		$tansactionType = 'B';
		$Chainstore = 'C';
		$reasonCode = 'D';
		$referenceD_C_no = 'E';
		$dcdate = 'F';
		$doc_remarks = 'G';
		$doc_prefix = 'H';
		$doc_number = 'I';
		$inwardDate = 'J';
		
		
		$stockDetail ='C';
		$no = 'D';
		$stock_no = 'E';
		$UPC_code = 'F';
		$doc_qty = 'G';
		$price = 'H';
		$netValue = 'I';
		
		
		$total_qty_label = 'F';
		$total_qty = 'G';
		
			
		
		$row=1;
		$i=1;
			foreach($collections as $collection){
				
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($incrementno.$row, $i);
			$row++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($tansactionType.$row, 'Transaction Type')
			->setCellValue($Chainstore.$row, 'Chain Store')
			->setCellValue($reasonCode.$row, 'Reason Code')
			->setCellValue($referenceD_C_no.$row, 'Ref dc/no')
			->setCellValue($dcdate.$row, 'Doc date')
			->setCellValue($doc_remarks.$row, 'Doc Remarks')
			->setCellValue($doc_prefix.$row, 'Doc Prefix')
			->setCellValue($doc_number.$row, 'Doc Number ')
			->setCellValue($inwardDate.$row, 'Inward Date');
			$objPHPExcel->getActiveSheet()->getStyle($tansactionType.$row.":".$inwardDate.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			
			
			$row++;
			
			
			
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($tansactionType.$row,$collection->getData('transaction_type'))
           ->setCellValue($Chainstore.$row, $collection->getData('chainstore'))
			->setCellValue($reasonCode.$row, $collection->getData('reasoncode'))
			->setCellValue($referenceD_C_no.$row, $collection->getData('refdcno'))
			->setCellValue($dcdate.$row,$collection->getData('dc_date'))
			->setCellValue($doc_remarks.$row,$collection->getData('doc_remarks'))
			->setCellValue($doc_prefix.$row, $collection->getData('doc_prefix'))
			->setCellValue($doc_number.$row, $collection->getData('doc_number'))
			->setCellValue($inwardDate.$row, date('Y-m-d', strtotime($collection->getData('created_time'))));
	
			
			
			
			$row++;
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue($stockDetail.$row, 'Stock Detail');
			$row++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($no.$row, 'No')
            ->setCellValue($stock_no.$row, 'Stock No')
			->setCellValue($UPC_code.$row, 'UPC code')
			->setCellValue($doc_qty.$row, 'Doc Qty')
			->setCellValue($price.$row, 'Price')
			->setCellValue($netValue.$row, 'Net Value');
			//$objPHPExcel->getActiveSheet()->getStyle($no.$row.":".$netValue.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			
			$row++;
			$totQty = 0;
			
			$product_collections = Mage::getModel('outwardproduct/outwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('outwardregister_id', array('eq' => $collection->getData('outwardregister_id')));
		
			$j=1;
				foreach($product_collections as $product_collection){
			
					//$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($product_collection->getData('itemsku')))->getData();
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($no.$row, $j)
            ->setCellValue($stock_no.$row, $product_collection->getData('itemsku'))
			->setCellValue($UPC_code.$row, $product_collection->getData('itemdescription'))
			->setCellValue($doc_qty.$row, $product_collection->getData('qty'))
			->setCellValue($price.$row,$product_collection->getData('price'))
			->setCellValue($netValue.$row, $product_collection->getData('total'));
			$totQty = $totQty + $product_collection->getData('qty');
			$row++;
			$j++;
			
					
				}
				$row = $row++;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($total_qty_label.$row, 'Total Qty')
            ->setCellValue($total_qty.$row, $totQty);
			$objPHPExcel->getActiveSheet()->getStyle($total_qty_label.$row.":".$total_qty.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$row = $row+2;
			$i++;
				
			}
			
			
//$objPHPExcel->setActiveSheetIndex(0);  

// Initialise the Excel row number 


// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="outwardreport.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');
			
	exit;		
		
		
		
		
		
		}
}