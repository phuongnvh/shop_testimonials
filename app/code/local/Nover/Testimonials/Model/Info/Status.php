<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Info Statuses Class
 */

class Nover_Testimonials_Model_Info_Status extends Varien_Object
{
    const STATUS_DISABLED  = 0;
    const STATUS_ENABLED  = 1;

    public function getDisabledStatusId()
    {
        return self::STATUS_DISABLED;
    }

    public function getEnabledStatusId()
    {
        return self::STATUS_ENABLED;
    }

    static public function getOptionArray()
    {
        return array(
            self::STATUS_DISABLED  => Mage::helper('testimonials')->__('Disabled'),
            self::STATUS_ENABLED  => Mage::helper('testimonials')->__('Enabled'),
        );
    }
}