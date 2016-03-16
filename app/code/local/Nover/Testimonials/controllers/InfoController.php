<?php

class Nover_Testimonials_InfoController extends Mage_Core_Controller_Front_Action {

    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::helper('testimonials')->getEnabled()) {
            $this->_redirectUrl(Mage::helper('core/url')->getHomeUrl());
        }
    }

    public function indexAction(){
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->getLayout()->getBlock('root')->setTemplate(Mage::helper('testimonials')->getLayout());
        $this->renderLayout();
    }

    public function saveAction(){
        if ($data = $this->getRequest()->getPost() && Mage::getSingleton('customer/session')->isLoggedIn()) {

            $model = Mage::getModel('testimonials/feedback');
            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $feedbackData["username"] = $customer->getEmail();
            $feedbackData["testimonial_id"] = $this->getRequest()->getParam('id');
            $feedbackData["status"] = Mage::getSingleton('testimonials/feedback_status')->getPendingStatusId();
            $feedbackData["content"] = $this->getRequest()->getParam('content');

            $model->setData($feedbackData);

            try {
                $model->save();
                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('testimonials')->__('Your feedback was successfully saved'));
            }
            catch(Mage_Core_Exception $e){
                Mage::getSingleton('customer/session')->addError(Mage::helper('testimonials')->__($e->getMessage()));
                Mage::getSingleton('customer/session')->setFormData($data);
            }
        }
        else {
            Mage::getSingleton('customer/session')->addError(Mage::helper('testimonials')->__('Unable to save your feedback'));
        }
        $this->_redirect('*/*/index', array( 'id' => $this->getRequest()->getParam('id')));
    }
}