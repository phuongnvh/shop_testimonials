<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonial Info Container Class
 */

class Nover_Testimonials_Block_Adminhtml_Testimonials_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'testimonials';
        $this->_controller = 'adminhtml_testimonials';

        $this->_updateButton('save', 'label', Mage::helper('testimonials')->__('Save'));

        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );

        $this->_formScripts[]
            = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('testimonial_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'testimonial_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'testimonial_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('testimonial_data') && Mage::registry('testimonial_data')->getId()) {
            return Mage::helper('testimonials')->__(
                "Testimonials '%s'", $this->escapeHtml(Mage::registry('testimonial_data')->getTestimonialName())
            );
        } else {
            return Mage::helper('testimonials')->__('Add New Testimonial');
        }
    }
}