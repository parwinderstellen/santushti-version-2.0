<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Block_Adminhtml_Bannerpopup extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_bannerpopup';
    $this->_blockGroup = 'bannerpopup';
    $this->_headerText = Mage::helper('bannerpopup')->__('Image Manager');
    $this->_addButtonLabel = Mage::helper('bannerpopup')->__('Add Image');
    parent::__construct();
  }
}