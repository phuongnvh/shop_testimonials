<?php

class Nover_Testimonials_Block_Info extends Mage_Core_Block_Template {

    public function __construct()
    {
        parent::__construct();
        $id = $this->getRequest()->getParam('id');
        $info = Mage::getModel('testimonials/info')->load($id);
        $this->setInfo($info);

        $feedbackCol = Mage::getModel('testimonials/feedback')->getApprovedFeedbacks($id);
        $this->setFeedback($feedbackCol);
    }
}