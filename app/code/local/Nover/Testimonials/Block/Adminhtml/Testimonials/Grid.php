<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials List Grid Block
 */

class Nover_Testimonials_Block_Adminhtml_Testimonials_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('testimonialsGrid');
        $this->setDefaultSort('created_time');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('testimonials/info')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            array(
                'header' => Mage::helper('testimonials')->__('ID'),
                'align'  => 'right',
                'width'  => '50px',
                'index'  => 'id',
            )
        );

        $this->addColumn(
            'testimonial_name',
            array(
                'header' => Mage::helper('testimonials')->__('Testimonials Name'),
                'align'  => 'left',
                'index'  => 'testimonial_name',
            )
        );

        $this->addColumn(
            'created_time',
            array(
                'header'    => Mage::helper('testimonials')->__('Created at'),
                'index'     => 'created_time',
                'type'      => 'datetime',
                'width'     => '150px',
                'gmtoffset' => true,
                'default'   => ' -- '
            )
        );

        $this->addColumn(
            'update_time',
            array(
                'header'    => Mage::helper('testimonials')->__('Updated at'),
                'index'     => 'update_time',
                'width'     => '150px',
                'type'      => 'datetime',
                'gmtoffset' => true,
                'default'   => ' -- '
            )
        );

        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('testimonials')->__('Status'),
                'align'   => 'left',
                'width'   => '80px',
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    0 => Mage::helper('testimonials')->__('Disabled'),
                    1 => Mage::helper('testimonials')->__('Enabled'),
                ),
            )
        );

        $this->addColumn(
            'action',
            array(
                'header'    => Mage::helper('testimonials')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('testimonials')->__('Edit'),
                        'url'     => array('base' => '*/*/edit'),
                        'field'   => 'id',
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
            )
        );

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('testimonials');

        $statuses = Mage::getSingleton('testimonials/info_status')->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('testimonials')->__('Change status'),
                'url'        => $this->getUrl('*/*/massUpdateStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('testimonials')->__('Status'),
                        'values' => $statuses,
                    )
                )
            )
        );

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'      => Mage::helper('testimonials')->__('Remove Testimonial(s)'),
                'url'        => $this->getUrl('*/*/massDelete', array('_current' => true)),
            )
        );
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}