<script type="text/javascript">
function ChangeValue(data,year){
	var prefix = '';
	if(data=="Purchase Out"){
		prefix = "PO-"+year;
	}else if(data=="Transfer Out"){
		prefix = "TO-"+year;
	}else{
		prefix = "AO-"+year;
	}
	document.getElementById('doc_prefix').value = prefix;
}

</script>
<?php

class Fcuk_Outwardregister_Block_Adminhtml_Outwardregister_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('outwardregister_form', array('legend'=>Mage::helper('outwardregister')->__('Item information')));
      $year = substr(date("Y") , 2 ,2);
      $fieldset->addField('transaction_type', 'select', array(
          'label'     => Mage::helper('outwardregister')->__('Transaction Type'),
          'name'      => 'transaction_type',
		  'onchange' => "ChangeValue(this.value,$year);",
          'values'    => array(
              array(
                  'value'     => 'Purchase Out',
                  'label'     => Mage::helper('outwardregister')->__('Purchase Out'),
              ),

              array(
                  'value'     => 'Transfer Out',
                  'label'     => Mage::helper('outwardregister')->__('Transfer Out'),
              ),
			  
			  array(
                  'value'     => 'Adjustment',
                  'label'     => Mage::helper('outwardregister')->__('Adjustment'),
              ),
          ),
      ));  

	 $fieldset->addField('chainstore', 'text', array(
          'label'     => Mage::helper('outwardregister')->__('Chain Store'),
          'class'     => 'required-entry',
          'required'  => true, 
          'name'      => 'chainstore',
		  
      ));
	  
     
      $fieldset->addField('reasoncode', 'text', array(
          'label'     => Mage::helper('outwardregister')->__('Reason Code'),
          'class'     => 'required-entry',
          'required'  => true, 
          'name'      => 'reasoncode',
      ));


		$fieldset->addField('refdcno', 'text', array(
          'label'     => Mage::helper('outwardregister')->__('Reference Doc No'),
          'class'     => 'required-entry',
          'required'  => true, 
          'name'      => 'refdcno',
      ));
	  
	   $fieldset->addField('dc_date', 'date', array(
            'name'      => 'dc_date',
            'title'     => Mage::helper('outwardregister')->__('Reference Doc Date'),
            'label'     => Mage::helper('outwardregister')->__('Reference Doc Date'),
          'format' => 'YYYY-MM-DD',
            'required'  => true,
			'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
        )); 
	  
	  
	  $fieldset->addField('doc_remarks', 'text', array(
          'label'     => Mage::helper('outwardregister')->__('Doc Remarks'),
         'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'doc_remarks',
      ));
	  
	  
	  $fieldset->addField('doc_prefix', 'text', array(
          'label'     => Mage::helper('outwardregister')->__('Doc Prefix'),
         'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'doc_prefix',
		   'readonly' => true,
      ));
	  
	  if($this->getRequest()->getParam('id')){
		   $fieldset->addField('doc_number', 'text', array(
          'label'     => Mage::helper('outwardregister')->__('Doc Number'),
          'required'  => false,
          'name'      => 'doc_number',
		  'style'   => "border:none; background:none repeat scroll 0 0 #FAFAFA",
		  'readonly' => true
      ));
		  }else{
	  
	  
	  $collections = Mage::getModel('outwardregister/outwardregister')->getCollection()->setOrder('outwardregister_id', 'DESC')
	  				->setPageSize(1)->setCurPage(1)->getData();
	  
	  
	   $increment_id = $collections[0]['outwardregister_id'] + 1;
	  
		 $fieldset->addField('doc_number', 'text', array(
          'label'     => Mage::helper('outwardregister')->__('Doc Number'),
          'required'  => false,
          'name'      => 'doc_number',
		  'style'   => "width:0px; border:none; background:none repeat scroll 0 0 #FAFAFA",
		  'after_element_html' => $increment_id,
		   'readonly' => true
      ));
	  
	  }

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('outwardregister')->__('File'),
          'required'  => true,
          'name'      => 'filename',
	  ));
	/*	
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('outwardregister')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('outwardregister')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('outwardregister')->__('Disabled'),
              ),
          ),
      )); */
   /*  
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('outwardregister')->__('Content'),
          'title'     => Mage::helper('outwardregister')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     */
      if ( Mage::getSingleton('adminhtml/session')->getOutwardregisterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOutwardregisterData());
          Mage::getSingleton('adminhtml/session')->setOutwardregisterData(null);
      } elseif ( Mage::registry('outwardregister_data') ) {
          $form->setValues(Mage::registry('outwardregister_data')->getData());
      }
      return parent::_prepareForm();
  }
}?>
<script>
document.observe("dom:loaded", function() {
  var last2 = new Date().getFullYear().toString();
  last2 = last2.split("20");
  document.getElementById("doc_prefix").value = "PO-"+last2[1];
});	
</script>