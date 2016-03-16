<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Model Feedback Class
 */

class Nover_Testimonials_Model_Feedback extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        parent::_construct(); // TODO: Change the autogenerated stub
        $this->_init('testimonials/feedback');
    }

    public function getFeedbackByTestiId($testimonialId){
        $feedbacks = $this->getCollection()
            ->addFieldToFilter('testimonial_id', $testimonialId);

        return $feedbacks;
    }

    public function getApprovedFeedbacks($testimonialId){

        $feedbacks = $this->getCollection()
            ->addFieldToFilter('testimonial_id', $testimonialId)
            ->addFieldToFilter('status', Mage::getSingleton('testimonials/feedback_status')->getApprovedStatusId());

        return $feedbacks;
    }
}