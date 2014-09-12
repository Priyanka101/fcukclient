<?php

class Fcuk_Inwardregister_Adminhtml_InwardregisterController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('inwardregister/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('inwardregister/inwardregister')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('inwardregister_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('inwardregister/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('inwardregister/adminhtml_inwardregister_edit'))
				->_addLeft($this->getLayout()->createBlock('inwardregister/adminhtml_inwardregister_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inwardregister')->__('Item does not exist'));
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
					$path = Mage::getBaseDir('media') . DS ."inward" .DS ;
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
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inwardregister')->__('File is Empty'));
        		$this->_redirect('*/*/');
				return false;
			}
			
			if($this->getRequest()->getParam('id')){
				$helperdata = Mage::helper('inwardregister');
				if($helperdata->_checkUpdatestock($dataCollection,$this->getRequest()->getParam('id'))){
					}else{
						Mage::getSingleton('adminhtml/session')->addError("Inward Not Edit");
						$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						return false;
					}
				
				
				}else{
				$helperdata = Mage::helper('inwardregister');
				if($helperdata->_checkAddstocknew($dataCollection)){
					}else{
						Mage::getSingleton('adminhtml/session')->addError("Inward Not Add");
						$this->_redirect('*/*/', array('id' => $this->getRequest()->getParam('id')));
						return false;
					}
				
				
				}
				
				
			if(!$this->getRequest()->getParam('id')){
	  			
				  $collections = Mage::getModel('inwardregister/inwardregister')->getCollection()->setOrder('inwardregister_id', 'DESC')
	  				->setPageSize(1)->setCurPage(1)->getData();
	  			 $increment_id = $collections[0]['inwardregister_id'] + 1;
				 $data['doc_number'] = $increment_id;
			}
			$model = Mage::getModel('inwardregister/inwardregister');		
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
				if(!$this->getRequest()->getParam('id')){
				$inwardregister_id = $model->getId();
				$modelnew = Mage::getModel('inwardregister/inwardregister');
				$modelnew->setDocNumber($inwardregister_id);
				$modelnew->setId($inwardregister_id);
				$modelnew->save();
				$message = '';
				$count   = 1;
				$helperdata = Mage::helper('inwardregister');
				foreach($dataCollection as $_data){
					
					if($helperdata->_checkIfSkuExists($_data[0])){
						try{
							$helperdata->_updateStocks($_data);
							$helperdata->_addDataProduct($_data , $inwardregister_id);
							//$helperdata->_updatePrice($_data);
						}catch(Exception $e){
							$message .=  $count .'> Error:: while Upating  Qty (' . $_data[2] . ') of Sku (' . $_data[0] . ') => '.$e->getMessage().'<br />';
						}
					}
					
					$count++;
				}
				}else{
					
					$inwardregister_id = $this->getRequest()->getParam('id');
					$message = '';
				$count   = 1;
				$helperdata = Mage::helper('inwardregister');
				foreach($dataCollection as $_data){
					
					if($helperdata->_checkIfSkuExists($_data[0])){
						
						try{
							
							$helperdata->_updateStocksedit($_data , $inwardregister_id);
							$helperdata->_addDataProductedit($_data , $inwardregister_id);
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
		 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inwardregister')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
		
	}
	public function saveoldAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			$helperdata = Mage::helper('inwardregister');
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
					$path = Mage::getBaseDir('media') . DS ."inward" .DS ;
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
							$helperdata->_addData($_data);
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
				
				
				
			}else{
				
				$_data[0] = $data['sku'];
				$_data[1] = $data['qty'];
				$_data[2] = $data['stock_move_to_live'];
				$_data[3] = $data['supplier_id'];
				$_data[4] = $data['comment'];
				if($helperdata->_checkIfSkuExists($_data[0])){
						try{
							$helperdata->_updateStocks($_data);
							$helperdata->_addData($_data);
							$message .= $count . '> Success:: Qty (' . $_data[1] . ') of Sku (' . $_data[0] . ') has been updated. <br />';
							Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('inwardregister')->__($message));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/');
				return;
				 
						}catch(Exception $e){
							$message .=  $count .'> Error:: while Upating  Qty (' . $_data[1] . ') of Sku (' . $_data[0] . ') => '.$e->getMessage().'<br />';
							Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inwardregister')->__($message));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/');
				return;
							
						}
					
					
					
					}else{
						
						//$message .=  $count .'> Error:: Product with Sku (' . $_data[0] . ') does\'t exist.<br />';
					
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inwardregister')->__('Item was not successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/');
				return;
						
						
					}
				
			}
			exit;
	  		//$data['stock_remain_not_move_to_live'] = $data['qty'] - $data['stock_move_to_live']; 
			$data['stock_move_to_live'] = 0;
			$data['stock_remain_not_move_to_live'] = 0;
			
	  			
			$model = Mage::getModel('inwardregister/inwardregister');		
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inwardregister')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		
		if( $this->getRequest()->getParam('id') > 0 ) {
			
			$helperdata = Mage::helper('inwardregister');
			if($helperdata->checkDelete($this->getRequest()->getParam('id'))){
			
			try {
				
				$helperdata->deleteInward($this->getRequest()->getParam('id'));
				$model = Mage::getModel('inwardregister/inwardregister');
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}else{
			Mage::getSingleton('adminhtml/session')->addError("Inward Not Delete");
			$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			return false;
		}
			
			
			
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
		
        $inwardregisterIds = $this->getRequest()->getParam('inwardregister');
        if(!is_array($inwardregisterIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($inwardregisterIds as $inwardregisterId) {
                    $inwardregister = Mage::getModel('inwardregister/inwardregister')->load($inwardregisterId);
                    $inwardregister->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($inwardregisterIds)
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
		
        $inwardregisterIds = $this->getRequest()->getParam('inwardregister');
        if(!is_array($inwardregisterIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($inwardregisterIds as $inwardregisterId) {
                    $inwardregister = Mage::getSingleton('inwardregister/inwardregister')
                        ->load($inwardregisterId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($inwardregisterIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	public function massMovetoliveAction(){
		
		$inwardregisterIds = $this->getRequest()->getParam('inwardregister');
		 if(!is_array($inwardregisterIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
			 try {
                foreach ($inwardregisterIds as $inwardregisterId) {
                    $inwardregister = Mage::getSingleton('inwardregister/inwardregister')
                        ->load($inwardregisterId)->getData();
					if($inwardregister['stock_remain_not_move_to_live'] > 0){	
                		$this->_movetoLive($inwardregister);
					}
					
                }
				  	
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($inwardregisterIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        
        }
		   	
		$this->_redirect('*/*/index');
	}
  
    public function exportCsvAction()
    {
        $fileName   = 'inwardregister.csv';
        $content    = $this->getLayout()->createBlock('inwardregister/adminhtml_inwardregister_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'inwardregister.xml';
        $content    = $this->getLayout()->createBlock('inwardregister/adminhtml_inwardregister_grid')
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
	
	protected function _movetoLive($data){
		$helperdata = Mage::helper('inwardregister');
		$_data[0] = $data['sku'];
		$_data[1] = $data['qty'];
		$_data[2] = $data['stock_remain_not_move_to_live'];
		$_data[3] = $data['supplier_id'];
		$_data[4] = $data['comment'];
		
		if($helperdata->_checkIfSkuExists($_data[0])){
						try{
							$helperdata->_updateStocks($_data);
							$helperdata->_massmovetoLive($_data,$data['inwardregister_id'],$data['stock_move_to_live']);
							$message .= $count . '> Success:: Qty (' . $_data[1] . ') of Sku (' . $_data[0] . ') has been updated. <br />';
				 
						}catch(Exception $e){
							$message .=  $count .'> Error:: while Upating  Qty (' . $_data[1] . ') of Sku (' . $_data[0] . ') => '.$e->getMessage().'<br />';
						}
					}else{
						$message .=  $count .'> Error:: Product with Sku (' . $_data[0] . ') does\'t exist.<br />';
					}
	
	}
	
	public function inwardreportAction(){
		
		 $this->loadLayout()
            ->_setActiveMenu('inwardregister')
            ->_title($this->__('Inward Report'));
 
        // my stuff
 
        $this->renderLayout();
	}
	
	public function pdfinwardcopyAction(){
		
		require_once('Tcpdf/config/lang/eng.php');
		require_once('Tcpdf/tcpdf.php');
		
		
		$from = $this->getRequest()->getPost('from');
		$to = $this->getRequest()->getPost('to');
		
		$collections = Mage::getModel('inwardregister/inwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('dc_date', array('from' => $from , 'to' => $to));
		
		
		$j=1;
		$html = '<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:center; font-size:30px;font-weight: bold; text-decoration: underline;">Inward Report</td>
  </tr>
</table>';
		foreach($collections as $collection){
			/*
			$html .='<table><tr>
			<td width="100px;">Transaction Type</td>
			<td>Chain Store</td>
			<td>Reason Code</td>
			<td>Ref dc/no</td>
			<td>Doc Date</td>
			<td>Doc Remarks</td>
			<td>Doc Prefix</td>
			<td>Doc Number</td>
			</tr></table>';
			$html.='<table><tr>
			<td width="100px;">'.$collection->getData('transaction_type').'</td>
			<td>'.$collection->getData('chainstore').'</td>
			<td>'.$collection->getData('reasoncode').'</td>
			<td>'.$collection->getData('refdcno').'</td>
			<td>'.$collection->getData('dc_date').'</td>
			<td>'.$collection->getData('doc_remarks').'</td>
			<td>'.$collection->getData('doc_prefix').'</td>
			<td>'.$collection->getData('doc_number').'</td>
			</tr></table>';
			*/
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
	<th width="60" style="text-align:center;">Inward Date</th>
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
    <td colspan="9" style="padding:10px;"><table width="900" border="0" cellspacing="1" cellpadding="1" style="margin-top:10px;" >
      <tr>
        <th width="50" style="text-align:center; ">No</th>
        <th width="106" style="text-align:center; ">Stock No</th>
        <th width="300" style="text-align:center;">Item Description</th>
        <th width="70" style="text-align:center; ">Doc Qty</th>
        <th width="70" style="text-align:center;">Price</th>
        <th width="60" style="text-align:center;">Net Value</th>
      </tr>';
	  $product_collections = Mage::getModel('inwardproduct/inwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('inwardregister_id', array('eq' => $collection->getData('inwardregister_id')));
			$i=1;
			foreach($product_collections as $product_collection){
      $html.='<tr>
        <td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$i.'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('itemsku').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$product_collection->getData('itemdescription').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('qty').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('price').'</td>
        <td  style="text-align:center; font-size:22px;font-weight: normal;">'.$product_collection->getData('total').'</td>
      </tr>';
	  $i++;	
			}
			
    $html.='</table></td>
  </tr>
</table>';
		$j++;	
			
		}
		
		//echo '<pre>';
		//print_r($collections->getData());
		
		
	
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('InwardReport');
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
		
		$fileName = 'inwardreport.pdf';
		$pdf->Output($fileName, 'D');
		//return $pdf;
		exit;
		
	}
	
	public function pdfinward5_4_2013Action(){
		
		require_once('Tcpdf/config/lang/eng.php');
		require_once('Tcpdf/tcpdf.php');
		
		
		$from = $this->getRequest()->getPost('from');
		$to = $this->getRequest()->getPost('to');
		
		$collections = Mage::getModel('inwardregister/inwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('dc_date', array('from' => $from , 'to' => $to));
		
		
		$j=1;
		$html = '<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:center; font-size:30px;font-weight: bold; text-decoration: underline;">Inward Report</td>
  </tr>
</table>';
		foreach($collections as $collection){
			
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
	<th width="60" style="text-align:center;">Inward Date</th>
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
	<p >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<table width="700" border="1" style="margin:10px;">
      <tr>
        <th width="50" style="text-align:center; ">No</th>
        <th width="106" style="text-align:center; ">Stock No</th>
        
        <th width="70" style="text-align:center; ">Doc Qty</th>
        <th width="70" style="text-align:center;">Price</th>
        <th width="60" style="text-align:center;">Net Value</th>
      </tr>';
	  $product_collections = Mage::getModel('inwardproduct/inwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('inwardregister_id', array('eq' => $collection->getData('inwardregister_id')));
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
			}
			
    $html.='</table></p></td>
  </tr>
</table>';
		$j++;	
			
		}
		
		//echo '<pre>';
		//print_r($collections->getData());
		//<th width="300" style="text-align:center;">Item Description</th>
		//<td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$product_collection->getData('itemdescription').'</td>
		
	
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('InwardReport');
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
		
		$fileName = 'inwardreport.pdf';
		$pdf->Output($fileName, 'D');
		//return $pdf;
		exit;
		
	}
	
	public function pdfinwardAction(){
			$from = $this->getRequest()->getPost('from');
			$to = $this->getRequest()->getPost('to');
		
			$collections = Mage::getModel('inwardregister/inwardregister')->getCollection();
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
			
			$product_collections = Mage::getModel('inwardproduct/inwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('inwardregister_id', array('eq' => $collection->getData('inwardregister_id')));
		
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
header('Content-Disposition: attachment;filename="inwardreport.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');
			
	exit;		
			
			
			
		}
	
	public function pdfinwardnumber5_4_2013Action(){
		
		
		require_once('Tcpdf/config/lang/eng.php');
		require_once('Tcpdf/tcpdf.php');
		
		
		$from = $this->getRequest()->getPost('fromno');
		$to = $this->getRequest()->getPost('tono');
		
		$collections = Mage::getModel('inwardregister/inwardregister')->getCollection();
		$collections = $collections->addFieldToFilter('doc_number', array('from' => $from , 'to' => $to));
		
		
		$j=1;
		$html = '<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:center; font-size:30px;font-weight: bold; text-decoration: underline;">Inward Report</td>
  </tr>
</table>';
		foreach($collections as $collection){
			
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
	<th width="60" style="text-align:center;">Inward Date</th>
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
	<p >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<table width="700" border="1" style="margin:10px;">
      <tr>
        <th width="50" style="text-align:center; ">No</th>
        <th width="106" style="text-align:center; ">Stock No</th>
        
        <th width="70" style="text-align:center; ">Doc Qty</th>
        <th width="70" style="text-align:center;">Price</th>
        <th width="60" style="text-align:center;">Net Value</th>
      </tr>';
	  $product_collections = Mage::getModel('inwardproduct/inwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('inwardregister_id', array('eq' => $collection->getData('inwardregister_id')));
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
			}
			
   $html.='</table></p></td>
  </tr>
</table>';
		$j++;	
			
		}
		
		//echo '<pre>';
		//print_r($collections->getData());
		//<th width="300" style="text-align:center;">Item Description</th>
		//<td  style="text-align:center; font-size:22px;font-weight: normal; ">'.$product_collection->getData('itemdescription').'</td>
		
		
	
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$pdf->SetCreator(PDF_CREATOR);
		//$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('InwardReport');
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
		
		$fileName = 'inwardreport.pdf';
		$pdf->Output($fileName, 'D');
		//return $pdf;
		exit;
		
	
		}
		
	public function pdfinwardnumberAction(){
		
		$from = $this->getRequest()->getPost('fromno');
		$to = $this->getRequest()->getPost('tono');
		
			$collections = Mage::getModel('inwardregister/inwardregister')->getCollection();
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
			
			$product_collections = Mage::getModel('inwardproduct/inwardproduct')->getCollection();
			$product_collections = $product_collections->addFieldToFilter('inwardregister_id', array('eq' => $collection->getData('inwardregister_id')));
		
			$j = 1;
				foreach($product_collections as $product_collection){
			
				//	$_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($product_collection->getData('itemsku')))->getData();
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($no.$row, $j)
            ->setCellValue($stock_no.$row, $product_collection->getData('itemsku'))
			->setCellValue($UPC_code.$row,  $product_collection->getData('itemdescription'))
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
header('Content-Disposition: attachment;filename="inwardreport.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');
			
	exit;		
			
		
		}	
		
	public function reportstockstatementAction(){
		
		require_once('phpexcelnew/Classes/PHPExcel.php');
		
		$objPHPExcel = new PHPExcel();

 // Set the active Excel worksheet to sheet 0 
			
		$upc = 'A';
		$style = 'B';
		$colour = 'C';
		$sizeheader = 'D';
		$qtyheader = 'E';
		$valueheader = 'F';
		$totalvalueheader = 'G';
		
		$row=1;
		$collection = Mage::getModel('catalog/product')->getCollection();
		
		$productModel = Mage::getModel('catalog/product');
$attr = $productModel->getResource()->getAttribute("color");
$size = $productModel->getResource()->getAttribute("size");


$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($upc.$row, 'UPC')
			->setCellValue($style.$row, 'STYLE')
			->setCellValue($colour.$row, 'COLOUR')
			->setCellValue($sizeheader.$row, 'SIZE')
			->setCellValue($qtyheader.$row, 'QTY')
			->setCellValue($valueheader.$row, 'VALUE')
			->setCellValue($totalvalueheader.$row, 'TOTAL VALUE');
		$row++;	
		foreach($collection as $coll){
			
			if($coll->getData('type_id')=="simple"){
				
			$product = Mage::getModel('catalog/product')->load($coll->getEntityId());
			$qty = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
			$totalValue = $product->getData('price') * $qty;
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($upc.$row, $product->getData('stockno'))
			->setCellValue($style.$row,  $product->getData('stylecode'))
			->setCellValue($colour.$row, $attr->getSource()->getOptionText($product->getData('color')))
			->setCellValue($sizeheader.$row,$size->getSource()->getOptionText($product->getData('size')))
			->setCellValue($qtyheader.$row, $qty)
			->setCellValue($valueheader.$row,$product->getData('price'))
			->setCellValue($totalvalueheader.$row, $totalValue);
			$row++;	
			
			}
			 
		}
		
		header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="stockstatement.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');
			
	exit;	
		
	}	
	
	
	
}