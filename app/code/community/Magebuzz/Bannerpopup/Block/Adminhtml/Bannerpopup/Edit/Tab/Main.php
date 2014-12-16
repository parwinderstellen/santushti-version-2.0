<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Block_Adminhtml_Bannerpopup_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{

  protected function _prepareForm()
  {
    $form = new Varien_Data_Form();
    $form->setHtmlIdPrefix('bannerpopup_');
    $this->setForm($form);
    $fieldset = $form->addFieldset('bannerpopup_form', array('legend'=>Mage::helper('bannerpopup')->__('Image information')));

    $fieldset->addField('title', 'text', array(
    'label'     => Mage::helper('bannerpopup')->__('Title'),
    'class'     => 'required-entry',
    'required'  => true,
    'name'      => 'title',
    ));

    $object = Mage::getModel('bannerpopup/bannerpopup')->load( $this->getRequest()->getParam('id') );
    $imgPath = Mage::getBaseUrl('media')."bannerpopup/".$object['filename'];

    if($object['filename']){
      $fieldset->addField('image', 'label', array(
      'label' => Mage::helper('bannerpopup')->__('Banner Image'),
      'name'  =>'filename',
      'value'     => $imgPath,
      'after_element_html' => '<img src="'.$imgPath .'" alt=" '. $imgPath .'" height="120" width="120" />',
      ));
    }

    if($object['filename']){
      $fieldset->addField('filename', 'file', array(
      'label'     => Mage::helper('bannerpopup')->__('Change Image'),
      'required'  => false,
      'name'      => 'filename',
      ));
    }else {
      $fieldset->addField('filename', 'file', array(
      'label'     => Mage::helper('bannerpopup')->__('Choose Image'),
      'required'  => true,
      'name'      => 'filename',
      ));
    }

    $fieldset->addField('link', 'text', array(
    'label'     => Mage::helper('bannerpopup')->__('Link'),    
    'required'  => false,
    'class'  => 'validate-url',
    'name'      => 'link',
    ));
    
    $fieldset->addField('status', 'select', array(        
    'label'     => Mage::helper('bannerpopup')->__('Status'),
    'name'      => 'status',
    'values'    => array(
    array(
    'value'     => 1,
    'label'     => Mage::helper('bannerpopup')->__('Enabled'),
    ),
    array(
    'value'     => 2,
    'label'     => Mage::helper('bannerpopup')->__('Disabled'),
    ),
    ),
    ));

    if ( Mage::getSingleton('adminhtml/session')->getBannerpopupData() )
    {
      $form->setValues(Mage::getSingleton('adminhtml/session')->getBannerpopupData());
      Mage::getSingleton('adminhtml/session')->setBannerpopupData(null);
    } elseif ( Mage::registry('bannerpopup_data') ) {
      $form->setValues(Mage::registry('bannerpopup_data')->getData());
    }
    return parent::_prepareForm();
  }
}