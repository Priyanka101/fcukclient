<?php

class Mac_Landingpages_Adminhtml_LandingpagesController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("landingpages/landingpages")->_addBreadcrumb(Mage::helper("adminhtml")->__("Landingpages  Manager"),Mage::helper("adminhtml")->__("Landingpages Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Landingpages"));
			    $this->_title($this->__("Manager Landingpages"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Landingpages"));
				$this->_title($this->__("Landingpages"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("landingpages/landingpages")->load($id);
				if ($model->getId()) {
					Mage::register("landingpages_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("landingpages/landingpages");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Landingpages Manager"), Mage::helper("adminhtml")->__("Landingpages Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Landingpages Description"), Mage::helper("adminhtml")->__("Landingpages Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("landingpages/adminhtml_landingpages_edit"))->_addLeft($this->getLayout()->createBlock("landingpages/adminhtml_landingpages_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("landingpages")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Landingpages"));
		$this->_title($this->__("Landingpages"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("landingpages/landingpages")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("landingpages_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("landingpages/landingpages");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Landingpages Manager"), Mage::helper("adminhtml")->__("Landingpages Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Landingpages Description"), Mage::helper("adminhtml")->__("Landingpages Description"));


		$this->_addContent($this->getLayout()->createBlock("landingpages/adminhtml_landingpages_edit"))->_addLeft($this->getLayout()->createBlock("landingpages/adminhtml_landingpages_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						
				 //save image
		try{

if((bool)$post_data['bannerimage']['delete']==1) {

	        $post_data['bannerimage']='';

}
else {

	unset($post_data['bannerimage']);

	if (isset($_FILES)){

		if ($_FILES['bannerimage']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("landingpages/landingpages")->load($this->getRequest()->getParam("id"));
				if($model->getData('bannerimage')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('bannerimage'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'landingpages' . DS .'landingpages'.DS;
						$uploader = new Varien_File_Uploader('bannerimage');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['bannerimage']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['bannerimage']='landingpages/landingpages/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image

				 //save image
		try{

if((bool)$post_data['image']['delete']==1) {

	        $post_data['image']='';

}
else {

	unset($post_data['image']);

	if (isset($_FILES)){

		if ($_FILES['image']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("landingpages/landingpages")->load($this->getRequest()->getParam("id"));
				if($model->getData('image')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('image'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'landingpages' . DS .'landingpages'.DS;
						$uploader = new Varien_File_Uploader('image');
						$uploader->setAllowedExtensions(array('jpg','png','gif'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['image']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['image']='landingpages/landingpages/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image

				 //save image
		try{

if((bool)$post_data['video']['delete']==1) {

	        $post_data['video']='';

}
else {

	unset($post_data['video']);

	if (isset($_FILES)){

		if ($_FILES['video']['name']) {

			if($this->getRequest()->getParam("id")){
				$model = Mage::getModel("landingpages/landingpages")->load($this->getRequest()->getParam("id"));
				if($model->getData('video')){
						$io = new Varien_Io_File();
						$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('video'))));	
				}
			}
						$path = Mage::getBaseDir('media') . DS . 'landingpages' . DS .'landingpages'.DS;
						$uploader = new Varien_File_Uploader('video');
						$uploader->setAllowedExtensions(array('jpg','png','gif','mp4'));
						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);
						$destFile = $path.$_FILES['video']['name'];
						$filename = $uploader->getNewFileName($destFile);
						$uploader->save($path, $filename);

						$post_data['video']='landingpages/landingpages/'.$filename;
		}
    }
}

        } catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
        }
//save image


						$model = Mage::getModel("landingpages/landingpages")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Landingpages was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setLandingpagesData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setLandingpagesData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("landingpages/landingpages");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("landingpages/landingpages");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'landingpages.csv';
			$grid       = $this->getLayout()->createBlock('landingpages/adminhtml_landingpages_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'landingpages.xml';
			$grid       = $this->getLayout()->createBlock('landingpages/adminhtml_landingpages_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
}
