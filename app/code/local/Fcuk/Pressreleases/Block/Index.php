<?php   
class Fcuk_Pressreleases_Block_Index extends Mage_Core_Block_Template{   
	
	protected $press_collection ;
	protected $press_coverage_collection;
	public function getpresscollection(){
		return $this->press_collection =Mage::getModel("pressreleases/pressreleases")->getCollection();	
	}
	
	public function getpressname(){
		$press_name = $this->getpresscollection()->setOrder('release_id','DSC')->getData();
		$name_array=array();
		foreach($press_name as $name){
			array_push($name_array,$name['release_name']);
		}
		return $name_array;
	}
	public function getBlock(){
		$current_release = $this->getRequest()->getParam('release');
		return $this->getpresscollection()->addFieldToFilter('release_name',array('like'=>$current_release))->getData();
	}
	public function coveragecollection(){
		$coverage = Mage::getModel('pressreleases/presscoverage')->getCollection();
		return $coverage;
	}
	public function unique_coverage_name(){
		$coverage_title = array();
		$collection = $this->coveragecollection()->setOrder('coverage_id','DSC')->getData();
		$prev_title='';
		foreach($collection as $title){
			if($prev_title!=$title['title']){
				array_push($coverage_title,$title);
			}
			$prev_title=$title['title'];
		}
		$final_title=array();
		foreach($coverage_title as $front_title){
			array_push($final_title,$front_title['title']);
		}
		return $final_title;
	}
	public function coverage_images(){	
		$no = 1;
		$coverages = $this->unique_coverage_name();
		foreach($coverages as $coverage){
			$image_list = $this->coveragecollection()->addFieldToFilter('title',array('like'=>$coverage))->getData();
			$images = explode(",",$image_list[0]['image']);
			$imageTitle = explode(",",$image_list[0]['imagetitle']);
			
			$count_image_list = count($images);
			echo '<div rel="'.$no.'">';			
			echo '<a class="grouped_elements'.$no.'" title="'.$imageTitle[0].'" rel="prettyPhoto[gallery'.$no.']"  href="'.$this->getUrl('media').'pressreleases/presscoverage/'.$images[0].'">'.$image_list[0]['title'].'</a>';
			
			for($i=1;$i<$count_image_list;$i++){					
				echo '<a class="grouped_elements'.$no.'" title="'.$imageTitle[$i].'" rel="prettyPhoto[gallery'.$no.']" href="'.$this->getUrl('media').'pressreleases/presscoverage/'.$images[$i].'"></a>';
			}
			echo '</div>';
			$no++;
		}
	}
}