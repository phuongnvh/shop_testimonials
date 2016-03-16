<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Feedback Grid Container Block
 */

class Nover_Testimonials_Block_Adminhtml_Testimonials_Feedback extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_controller = 'adminhtml_testimonials_feedback';
        $this->_blockGroup = 'testimonials';
        $this->_headerText = Mage::helper('testimonials')->__('Testimonials Feedback');
        parent::__construct();
    }
}