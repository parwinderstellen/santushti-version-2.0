<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Block_Adminhtml_Bannerpopup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
    parent::__construct();
    $this->setId('bannerpopup_tabs');
    $this->setDestElementId('edit_form');
    $this->setTitle(Mage::helper('bannerpopup')->__('Image Information'));
  }

  protected function _beforeToHtml()
  {
    $this->addTab('form_section', array(
    'label'     => Mage::helper('bannerpopup')->__('Image Information'),
    'title'     => Mage::helper('bannerpopup')->__('Image Information'),
    'content'   => $this->getLayout()->createBlock('bannerpopup/adminhtml_bannerpopup_edit_tab_main')->toHtml(),
    ));  
    return parent::_beforeToHtml();
  }
}