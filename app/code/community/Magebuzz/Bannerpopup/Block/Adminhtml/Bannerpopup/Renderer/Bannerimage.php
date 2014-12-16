<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/

class Magebuzz_Bannerpopup_Block_Adminhtml_Bannerpopup_Renderer_Bannerimage extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
  public function render(Varien_Object $row) {
    $bannerId = $row->getId();
    $collection = Mage::getModel('bannerpopup/bannerpopup')->load($bannerId)  ;
    $imageName = $collection->getFilename()	;
    $imgPath = Mage::getBaseUrl('media')."bannerpopup/".$imageName;
    return $html = '<img src="'.$imgPath.'" border="0" width="100" height="100" />'   ;

  }
}