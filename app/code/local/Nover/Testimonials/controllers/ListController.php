<?php

class Nover_Testimonials_ListController extends Mage_Core_Controller_Front_Action {

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
}