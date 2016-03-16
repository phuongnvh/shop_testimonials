<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Feedback Statuses Class
 */

class Nover_Testimonials_Model_Feedback_Status extends Varien_Object
{
    const STATUS_DISABLED  = 0;
    const STATUS_PENDING  = 1;
    const STATUS_APPROVED  = 2;

    public function getDisabledStatusId()
    {
        return self::STATUS_DISABLED;
    }

    public function getApprovedStatusId()
    {
        return self::STATUS_APPROVED;
    }

    public function getPendingStatusId()
    {
        return self::STATUS_PENDING;
    }

    static public function getOptionArray()
    {
        return array(
            self::STATUS_DISABLED  => Mage::helper('testimonials')->__('Disabled'),
            self::STATUS_PENDING  => Mage::helper('testimonials')->__('Pending'),
            self::STATUS_APPROVED  => Mage::helper('testimonials')->__('Approved'),
        );
    }

    public function getFormArray(){
        return array(
            array(
                'value' => self::STATUS_DISABLED,
                'label' => Mage::helper('testimonials')->__('Disabled'),
            ),
            array(
                'value' => self::STATUS_PENDING,
                'label' => Mage::helper('testimonials')->__('Pending'),
            ),
            array(
                'value' => self::STATUS_APPROVED,
                'label' => Mage::helper('testimonials')->__('Approved'),
            )
        );
    }
}