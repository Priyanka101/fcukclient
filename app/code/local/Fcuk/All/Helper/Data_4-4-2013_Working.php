<?php
class Fcuk_All_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function getColorOptions($_product)
	{

	
		if (!$_product->getId()) {
			return '';
		}
	
		//Load all simple products
		$products = array();
		$allProducts = $_product->getTypeInstance(true)->getUsedProducts(null, $_product);
		
		//print_r( $allProducts);exit;
		//$finalGrid = array();
		foreach ($allProducts as $product) {
		
			// echo $currColor = $product->getColor()->getColorName();exit;
			// $currSize = $product->getSize();
			// if($product->isSaleable()){
				// $currIsSalable = 1;
			// }else{
				// $currIsSalable = 0;
			// }
			
			// $size_salable = array('size' => $currSize, 'is_salable' => $currIsSalable);
			
			// $finalGrid[$currColor][] = $size_salable; 
			
			
			if ($product->isSaleable() && $product->getQty()>0) {
				  $products[] = $product;
			} else {
				$products[] = $product;
			}
		}
		//print_r($finalGrid); exit;
	
		//Load all used configurable attributes
		$configurableAttributeCollection = $_product->getTypeInstance()->getConfigurableAttributes();
		//$result = array();
		//Get combinations
		$finalGrid = array();
		$swatches = array();
		foreach ($products as $product) {
			//$items = array();
			//echo '<pre>';print_r($product->getData());exit;
			//echo '<pre>';print_r(get_class_methods($product));exit;
			if($product->isSaleable() && $product->getisInStock() ){
				$currIsSalable = 1;
			}else{
				$currIsSalable = 0;
			}
			//$sku = $product->getSku();
			
			//echo $stylecode.'<br/>';
			 
			//echo $stylecode;
			//echo $sku;exit;
			$sizeCode = $product->getSize();
			//echo '<pre>';print_r($sizeCode);exit;
			$colorCode = $product->getcolor();
			//echo '<pre>';print_r($colorCode);exit;
			
			
			foreach($configurableAttributeCollection as $attribute) {
			
				$attrValue = $product->getResource()->getAttribute($attribute->getProductAttribute()->getAttributeCode())->getFrontend();
				$attrCode = $attribute->getProductAttribute()->getAttributeCode();
				
				//echo '<pre>';
				//print_r(get_Class_methods($attrValue));exit;
				
				if ($attrCode=='color'){
				$attr = $product->getResource()->getAttribute($attrCode);
				$currColor = $attrValue->getValue($product);
				//echo $currColor.'<br/>';
				if($currColor != $prev_color)
				{	
					//echo $currColor;
					//$sku = $product->getSku();
					$stylecode = $product->getStylecode();
					$swatch_variable = $stylecode."_".strtolower($currColor);
					array_push($swatches,$swatch_variable);
				}
				$prev_color = $currColor;
					
				
				
				//$currSku =  $attrValue->getValue($product);
			//	print_r($currSku);exit;
				if($attr->usesSource()){
					
					$color_id = $attr->getSource()->getOptionId($currColor);
				
				}
				}
				else if ($attrCode=='size'){
				$currSize = $attrValue->getValue($product);
				//echo '<pre>';print_r($currSize);exit;
				}
				//$items[$attrCode] = $value;
			}
			$finalSize[] = $currSize;
			
			$size_salable = array('size' => $currSize, 'is_salable' => $currIsSalable ,'color_code'=> $colorCode  ,'size_code'=> $sizeCode,'color_id'=>$color_id,'sku'=> $sku);
			
			$finalGrid[$currColor][] = $size_salable; 
			
			//$result[] = $items;
		}
		$html .= "SELECT YOUR COLOUR AND SIZE";
		
		//asort($finalSize);
		//echo '<pre>';print_r($swatches);exit;
		// $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'size');
		// foreach ( $attribute->getSource()->getAllOptions(true, true) as $option){
		// $attributeArray[] = $option['label'];
		// }
		//echo '<pre>';
		//print_r ($finalGrid);exit;
		$html .= '<table border="1" width=100% cellspacing="5" cellpadding="2">';
		$html .= '<th>&nbsp;</th>';
		$finalSize = array_unique($finalSize);
		/* foreach ($finalSize as $value){
			$html .= '<th style="text-align:center">'.$value.'</th>';
		} */
		
		
		function cmp($a, $b)
		{
			if ($a['size_code'] == $b['size_code']) {
				return 0;
			}
			return ($a['size_code'] < $b['size_code']) ? -1 : 1;
		}
		$boolean = true;
		$counter = 0;
		foreach($finalGrid as $option=>$val){
		
			usort($val,'cmp');
			//echo '<pre>';print_r($val); exit;
			$color_id =  $val[0]['color_code'];
			
			//echo $swatches[$counter];
			$swatch = str_replace('/','-',$swatches[$counter]);
			//echo $swatch;exit; 
			$img_dir = Mage::getBaseDir('media').'/amconf/images/'.$swatch.'.gif';
			$img_src = '';
			$sizes_count = count($finalSize);
			$sortedSize = array();
			for($i=0;$i < $sizes_count;$i++)
			{
				foreach($finalSize as $fsize){
					 if($val[$i]['size'] == $fsize)
					 {
						array_push($sortedSize,$val[$i]['size']);
					 }
				}
			} 
			
			//echo '<pre>';print_r($sortedSize);exit;
			if($boolean)
			{	
				foreach ($sortedSize as $value){
					$html .= '<th style="text-align:center">'.$value.'</th>';
				}
				$boolean = false;
			}
			//echo $img_dir;exit;
		 if(file_exists($img_dir)){
				//echo 'exists';exit;
				$img_src = Mage::getBaseUrl('media').'amconf/images/'.$swatch.'.gif';
			}
				//echo 'exists';exit;
				//echo $sku;exit;
			//$img_src = Mage::getBaseUrl('media').'amconf/images/'.$swatches[$counter].'.gif';
			 
			$counter++;
			//echo $img_src;exit;
			$html .= '<tr>';
			$html .= '<td style="width:120px;text-align:center" >
			<div style="width:34px;float:left; height:34px; margin-right:5px;">';
			
			$html .= '<img src="'.$img_src.'" width="30px"/>';
			$html .= '</div><span>'.$option.'</span></td>';
	
			
			//print_r($finalSize);
			//echo '<pre>';print_r($val); exit;
		
			
			
			foreach($sortedSize as $fsize){
				$bool = false;
				foreach ($val as $size){
					if ($fsize == $size['size'] && $size['is_salable'] != 0){
						//echo $ssize;
						$bool = true;
						$sizeCode= $size['size_code'];
						$colorCode= $size['color_code'];
						break;
					}
				}
				if ($bool){
					//echo $size['size'];exit;
					$html .= '<td style="text-align:center"><label for="radio-'.$sizeCode.'-'.$colorCode.'" class="radio-'.$sizeCode.'"></label><input type="radio" id="radio-'.$sizeCode.'-'.$colorCode.'" name="attribute" class="attribute" value="'.$sizeCode.','.$colorCode.'"/></td>';
					//$bool = false;
				}
				else{
					$html .='<td style="text-align:center">X</td>';
				}
				
			}
			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
		
		
	}
	public function getQuickview($_product){
		$current_cat = Mage::registry('current_category')->getId();
				//print_r($current_cat);exit;
		
		if (!$_product->getId()) {
			return '';
		}
		$products = array();
		$allProducts = $_product->getTypeInstance(true)->getUsedProducts(null, $_product);
		foreach ($allProducts as $product) {
			if ($product->isSaleable() && $product->getQty()>0) {
				  $products[] = $product;
			} else {
				$products[] = $product;
			}
		}
		$configurableAttributeCollection = $_product->getTypeInstance()->getConfigurableAttributes();
		$finalGrid = array();
		
		foreach ($products as $product) {
			$sizeCode = $product->getSize();
			$colorCode = $product->getcolor();
			
			if($product->isSaleable() && $product->getisInStock() ){
				$currIsSalable = 1;
			}else{
				$currIsSalable = 0;
			}
			$sizeCode = $product->getSize();
			//echo '<pre>';print_r($sizeCode);exit;
			$colorCode = $product->getcolor();
			//echo '<pre>';print_r($colorCode);exit;
			
			foreach($configurableAttributeCollection as $attribute) {
				$attrValue = $product->getResource()->getAttribute($attribute->getProductAttribute()->getAttributeCode())->getFrontend();
				$attrCode = $attribute->getProductAttribute()->getAttributeCode();
				if ($attrCode=='color'){
					$attr = $product->getResource()->getAttribute($attrCode);
					$currColor = $attrValue->getValue($product);
					//echo $currColor.'<br/>';
					if($currColor != $prev_color)
					{	
						//echo $currColor;
						//$sku = $product->getSku();
						$stylecode = $product->getStylecode();
						$swatch_variable = $stylecode."_".strtolower($currColor);
						array_push($swatches,$swatch_variable);
					}
					
					$prev_color = $currColor;
						
					
					
					//$currSku =  $attrValue->getValue($product);
				//	print_r($currSku);exit;
					if($attr->usesSource()){
						
						$color_id = $attr->getSource()->getOptionId($currColor);
					
					}
				}
				else if ($attrCode=='size'){
				$currSize = $attrValue->getValue($product);
				}
				//$items[$attrCode] = $value;
			}
			$finalSize[] = $currSize;
			$size_salable = array('size' => $currSize, 'is_salable' => $currIsSalable ,'color_code'=> $colorCode  ,'size_code'=> $sizeCode );
			$finalGrid[$currColor][] = $size_salable; 
		}
		//asort($finalSize);
		$finalSize = array_unique($finalSize); 
		// $html .='<lable> size</lable>';
		// $html .='<lable> color </lable>';
		//echo'<pre>';print_r($finalGrid);
			$html .= '<div id="quickshop-main-data">';
			$html .= '<div id="color_div">';
			$html .= '<label class="label_color">Select Color</label>';
		foreach($finalGrid as $option=>$val){
				//print_r($option);exit;
				
					
						$option = str_replace('/','-',str_replace(' ','-',$option));
					
				$html .= '<label for="'.$option.'" class="'.$option.'" style="background-color:'.$option.'; " ></label><input type="radio" name="attribute" value="'.$val[0]['color_code'].'" class="quick-radio"  id="'.$option.'" />';
		}
		$html .='</div>';
		$html .='<label class="size_label ">Size</label>';
		foreach($finalGrid as $option=>$val){
			$option = str_replace('/','-',str_replace(' ','-',$option));
			$html .= '<select  name="selectbox" class="'.$option.'" style="display:none; float:left; margin-top:10px;">';
				foreach ($val as $array){
					if($array['is_salable']== 1){
					$html .='<option class="option" stock="1" value="'.$array['size_code'].'" >'.$array['size'].'- in stock </option>';
					}else if ($array['is_salable']== 0){
					$html .='<option class="option" stock="0" value="'.$array['size_code'].'">'.$array['size'].'- out of stock </option>';
					}
				}
			$html .='</select>';
		
		}
		
		$html .= '</div>';
		
		return $html;
		
	}
	public function getPreviousProduct(){
	$prodId = Mage::registry('current_product')->getId();
        $catArray = Mage::registry('current_category');
        if($catArray){
            $catArray = $catArray->getProductsPosition();
            $keys = array_flip(array_keys($catArray));
            $values = array_keys($catArray);
            $productId = $values[$keys[$prodId]-1];
            $product = Mage::getModel('catalog/product');
            if($productId){
                $product->load($productId);
                return $product->getProductUrl();
            }
            return false;
        }
        return false;
		
	}
	public function getNextProduct(){
		 $prodId = Mage::registry('current_product')->getId();
        $catArray = Mage::registry('current_category');
        if($catArray){
            $catArray = $catArray->getProductsPosition();
            $keys = array_flip(array_keys($catArray));
            $values = array_keys($catArray);
            $productId = $values[$keys[$prodId]+1];
            $product = Mage::getModel('catalog/product');
            if($productId){
                $product->load($productId);
                return $product->getProductUrl();
            }
            return false;
        }
        return false;
    }
	public function getColorCount($_product){
	 
		if (!$_product->getId()) {
			return '';
		}
		$products = array();
		
		$allProducts = $_product->getTypeInstance(true)->getUsedProducts(null, $_product);
		foreach ($allProducts as $product) {
			
			if ($product->isSaleable() && $product->getQty()>0) {
				  $products[] = $product;
			} else {
				$products[] = $product;
			}
		}
		$configurableAttributeCollection = $_product->getTypeInstance()->getConfigurableAttributes();$result = array();
		$_colours = array();
		foreach ($products as $product) {
            $_colours[] = $product->getAttributeText('color');
		}
			$new = array_unique($_colours);
			if (count($new) > 1){
				echo '<div class="more-colours"><a href="'.$_product->getProductUrl().'">More colours</a></div>';
			}
	}
}
?> 