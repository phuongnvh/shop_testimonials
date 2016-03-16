<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Resource Model Info Class
 */

class Nover_Testimonials_Model_Resource_Info extends Mage_Core_Model_Resource_Db_Abstract {

    public function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('testimonials/info','id');
    }

    public function getEnabledTestimonials(){
        $collection = $this->getCollection()
            ->addFieldToFilter('status', Mage::getSingleton('testimonials/info_status')->getEnabledStatusId());
        return $collection;
    }
}