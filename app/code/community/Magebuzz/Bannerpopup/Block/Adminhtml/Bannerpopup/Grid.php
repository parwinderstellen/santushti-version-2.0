<?php
/*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
class Magebuzz_Bannerpopup_Block_Adminhtml_Bannerpopup_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
    parent::__construct();
    $this->setId('bannerpopupGrid');
    $this->setUseAjax(true);
    $this->setDefaultSort('bannerpopup_id');
    $this->setDefaultDir('ASC');
    $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
    $collection = Mage::getModel('bannerpopup/bannerpopup')->getCollection();
    $this->setCollection($collection);
    return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
    $this->addColumn('bannerpopup_id', array(
    'header'    => Mage::helper('bannerpopup')->__('ID'),
    'align'     =>'right',
    'width'     => '50px',
    'index'     => 'bannerpopup_id',
    ));

    $this->addColumn('title', array(
    'header'    => Mage::helper('bannerpopup')->__('Title'),
    'align'     =>'left',
    'index'     => 'title',
    ));
    
    $this->addColumn('link', array(
    'header'    => Mage::helper('bannerpopup')->__('Link'),
    'align'     =>'left',
    'index'     => 'link',
    ));

    $this->addColumn('count_click', array(
    'header'    => Mage::helper('bannerpopup')->__('Count Click'),
    'align'     =>'left',
    'index'     => 'viewcounts',
    ));
    
    $this->addColumn('count_show', array(
    'header'    => Mage::helper('bannerpopup')->__('Count Show Image'),
    'align'     =>'left',
    'index'     => 'showcounts',
    ));
    
    $this->addColumn('imgage_id', array(
    'header'    => Mage::helper('bannerpopup')->__('Image'),
    'align'     =>'center',
    'index'     => 'filename',
    'type'      => 'text',
    'width'     => '100px',
    'renderer'    => Magebuzz_Bannerpopup_Block_Adminhtml_Bannerpopup_Renderer_Bannerimage        
    ));

    $this->addColumn('status', array(
    'header'    => Mage::helper('bannerpopup')->__('Status'),
    'align'     => 'left',
    'width'     => '80px',
    'index'     => 'status',
    'type'      => 'options',
    'options'   => array(
    1 => 'Enabled',
    2 => 'Disabled',
    ),
    ));

    $this->addColumn('action',
    array(
    'header'    =>  Mage::helper('bannerpopup')->__('Action'),
    'width'     => '100',
    'type'      => 'action',
    'getter'    => 'getId',
    'actions'   => array(
    array(
    'caption'   => Mage::helper('bannerpopup')->__('Edit'),
    'url'       => array('base'=> '*/*/edit'),
    'field'     => 'id'
    )
    ),
    'filter'    => false,
    'sortable'  => false,
    'index'     => 'stores',
    'is_system' => true,
    ));

    $this->addExportType('*/*/exportCsv', Mage::helper('bannerpopup')->__('CSV'));
    $this->addExportType('*/*/exportXml', Mage::helper('bannerpopup')->__('XML'));

    return parent::_prepareColumns();
  }

  protected function _prepareMassaction()
  {
    $this->setMassactionIdField('bannerpopup_id');
    $this->getMassactionBlock()->setFormFieldName('bannerpopup');

    $this->getMassactionBlock()->addItem('delete', array(
    'label'    => Mage::helper('bannerpopup')->__('Delete'),
    'url'      => $this->getUrl('*/*/massDelete'),
    'confirm'  => Mage::helper('bannerpopup')->__('Are you sure?')
    ));

    $statuses = Mage::getSingleton('bannerpopup/status')->getOptionArray();

    array_unshift($statuses, array('label'=>'', 'value'=>''));
    $this->getMassactionBlock()->addItem('status', array(
    'label'=> Mage::helper('bannerpopup')->__('Change status'),
    'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
    'additional' => array(
    'visibility' => array(
    'name' => 'status',
    'type' => 'select',
    'class' => 'required-entry',
    'label' => Mage::helper('bannerpopup')->__('Status'),
    'values' => $statuses
    )
    )
    ));
    return $this;
  }

  public function getRowUrl($row)
  {
    return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
  public function getGridUrl()
  {
    return $this->getUrl('*/*/grid', array('_current'=> true));
  }  

}