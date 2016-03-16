<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Resource Model Feedback Class
 */

class Nover_Testimonials_Model_Resource_Feedback extends Mage_Core_Model_Resource_Db_Abstract {

    public function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('testimonials/feedback','id');
    }
}