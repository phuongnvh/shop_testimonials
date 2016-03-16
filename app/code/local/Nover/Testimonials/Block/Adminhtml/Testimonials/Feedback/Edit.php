<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonial Feedback Container Class
 */

class Nover_Testimonials_Block_Adminhtml_Testimonials_Feedback_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'testimonials';
        $this->_controller = 'adminhtml_testimonials_feedback';

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
                if (tinyMCE.getInstanceById('feedback_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'feedback_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'feedback_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('feedback_data') && Mage::registry('feedback_data')->getId()) {
            return Mage::helper('testimonials')->__(
                "Feedback of '%s'", $this->escapeHtml(Mage::registry('feedback_data')->getUsername())
            );
        } else {
            return Mage::helper('testimonials')->__('Add New Feedback');
        }
    }
}