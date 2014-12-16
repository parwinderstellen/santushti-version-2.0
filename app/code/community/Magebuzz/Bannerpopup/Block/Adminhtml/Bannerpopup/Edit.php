<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Block_Adminhtml_Bannerpopup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
  public function __construct()
  {
    parent::__construct();

    $this->_objectId = 'id';
    $this->_blockGroup = 'bannerpopup';
    $this->_controller = 'adminhtml_bannerpopup';

    $this->_updateButton('save', 'label', Mage::helper('bannerpopup')->__('Save Image'));
    $this->_updateButton('delete', 'label', Mage::helper('bannerpopup')->__('Delete Image'));

    $this->_addButton('saveandcontinue', array(
    'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
    'onclick'   => 'saveAndContinueEdit()',
    'class'     => 'save',
    ), -100);

    $this->_formScripts[] = "
    function toggleEditor() {
    if (tinyMCE.getInstanceById('bannerpopup_content') == null) {
    tinyMCE.execCommand('mceAddControl', false, 'bannerpopup_content');
    } else {
    tinyMCE.execCommand('mceRemoveControl', false, 'bannerpopup_content');
    }
    }
    function saveAndContinueEdit(){
    editForm.submit($('edit_form').action+'back/edit/');
    }
    ";
  }
  public function getHeaderText()
  {
    if( Mage::registry('bannerpopup_data') && Mage::registry('bannerpopup_data')->getId() ) {
      return Mage::helper('bannerpopup')->__("Edit Image '%s'", $this->htmlEscape(Mage::registry('bannerpopup_data')->getTitle()));
    } else {
      return Mage::helper('bannerpopup')->__('Add Image');
    }
  }
}