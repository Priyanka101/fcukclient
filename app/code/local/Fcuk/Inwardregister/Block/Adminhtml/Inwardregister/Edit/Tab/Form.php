<script type="text/javascript">
function ChangeValue(data,year){
	var prefix = '';
	if(data=="Purchase"){
		prefix = "PI-"+year;
	}else if(data=="Transfer in"){
		prefix = "TI-"+year;
	}else{
		prefix = "AI-"+year;
	}
	document.getElementById('doc_prefix').value = prefix;
}

</script>

<?php

class Fcuk_Inwardregister_Block_Adminhtml_Inwardregister_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('inwardregister_form', array('legend'=>Mage::helper('inwardregister')->__('Item information')));
	  
	   $year = substr(date("Y") , 2 ,2);
	  
	$fieldset->addField('transaction_type', 'select', array(
          'label'     => Mage::helper('inwardregister')->__('Transaction Type'),
          'name'      => 'transaction_type',
		   'onchange' => "ChangeValue(this.value,$year);",
          'values'    => array(
              array(
                  'value'     => 'Purchase',
                  'label'     => Mage::helper('inwardregister')->__('Purchase'),
              ),

              array(
                  'value'     => 'Transfer in',
                  'label'     => Mage::helper('inwardregister')->__('Transfer in'),
              ),
			  
			  array(
                  'value'     => 'Adjustment',
                  'label'     => Mage::helper('inwardregister')->__('Adjustment'),
              ),
          ),
      ));  
	  
	  $fieldset->addField('chainstore', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Party'),
          'class'     => 'required-entry',
          'required'  => true, 
          'name'      => 'chainstore',
      ));
	  
     
      $fieldset->addField('reasoncode', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Reason Code'),
          'class'     => 'required-entry',
          'required'  => true, 
          'name'      => 'reasoncode',
      ));


		$fieldset->addField('refdcno', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Reference Doc No'),
          'class'     => 'required-entry',
          'required'  => true, 
          'name'      => 'refdcno',
      ));
	  
	   $fieldset->addField('dc_date', 'date', array(
            'name'      => 'dc_date',
            'title'     => Mage::helper('inwardregister')->__('Reference Doc Date'),
            'label'     => Mage::helper('inwardregister')->__('Reference Doc Date'),
          'format' => 'YYYY-MM-DD',
            'required'  => true,
			'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
        )); 
	  
	  
	  $fieldset->addField('doc_remarks', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Doc Remarks'),
         'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'doc_remarks',
      ));
	  
	  
	 $fieldset->addField('doc_prefix', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Doc Prefix'),
         'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'doc_prefix',
		  'style'   => "border:none; background:none repeat scroll 0 0 #FAFAFA",
		   'readonly' => true,
      ));
	  
	
	  
	 

/*
	  
	  $fieldset->addField('doc_prefix', 'select', array(
          'label'     => Mage::helper('inwardregister')->__('Transaction Type'),
          'name'      => 'doc_prefix',
		  'values'    => array(
              array(
                  'value'     => 'P-'.$year,
                  'label'     => Mage::helper('inwardregister')->__('P-'.$year),
              ),

              array(
                  'value'     => 'T-'.$year,
                  'label'     => Mage::helper('inwardregister')->__('T-'.$year),
              ),
			  
			  array(
                  'value'     => 'A-'.$year,
                  'label'     => Mage::helper('inwardregister')->__('A-'.$year),
              ),
          ),
      ));  
	  
	  
	  */
	  
	    if($this->getRequest()->getParam('id')){
		    $fieldset->addField('doc_number', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Doc Number'),
          'required'  => false,
          'name'      => 'doc_number',
		  'style'   => "border:none; background:none repeat scroll 0 0 #FAFAFA",
		  'readonly' => true
      ));
	  
	   }else{
	  
	  $collections = Mage::getModel('inwardregister/inwardregister')->getCollection()->setOrder('inwardregister_id', 'DESC')
	  				->setPageSize(1)->setCurPage(1)->getData();
	  
	  
	   $increment_id = $collections[0]['inwardregister_id'] + 1;
	  
	   $fieldset->addField('doc_number', 'text', array(
          'label'     => Mage::helper('inwardregister')->__('Doc Number'),
          'required'  => false,
          'name'      => 'doc_number',
		  'style'   => "width:0px; border:none; background:none repeat scroll 0 0 #FAFAFA",
		  'after_element_html' => $increment_id,
		   'readonly' => true
      ));
	  
	   }
	   $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('inwardproduct')->__('File'),
          'required'  => true,
          'name'      => 'filename',
	  ));
	
	/*	
    $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('inwardregister')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('inwardregister')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('inwardregister')->__('Disabled'),
              ),
          ),
      ));*/
     /*
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('inwardregister')->__('Content'),
          'title'     => Mage::helper('inwardregister')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     */
      if ( Mage::getSingleton('adminhtml/session')->getInwardregisterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInwardregisterData());
          Mage::getSingleton('adminhtml/session')->setInwardregisterData(null);
      } elseif ( Mage::registry('inwardregister_data') ) {
          $form->setValues(Mage::registry('inwardregister_data')->getData());
      }
      return parent::_prepareForm();
  }
}
?>
<script>
document.observe("dom:loaded", function() {
  var last2 = new Date().getFullYear().toString();
  last2 = last2.split("20");
  document.getElementById("doc_prefix").value = "PI-"+last2[1];
});	
</script>