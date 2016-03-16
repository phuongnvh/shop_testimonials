<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials List Grid Container Block
 */

class Nover_Testimonials_Block_Adminhtml_List extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_controller = 'adminhtml_testimonials';
        $this->_blockGroup = 'testimonials';
        $this->_headerText = Mage::helper('testimonials')->__('Testimonials List');
        parent::__construct();
    }
}