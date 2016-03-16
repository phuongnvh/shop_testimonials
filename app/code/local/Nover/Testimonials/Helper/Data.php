<?php

class Nover_Testimonials_Helper_Data extends Mage_Core_Helper_Data {

    /** Layout template */
    const XML_PATH_LAYOUT = 'testimonials/general/layout';

    public function conf($code, $store = null)
    {
        return Mage::getStoreConfig($code, $store);
    }

    public function getEnabled()
    {
        return Mage::getStoreConfig('testimonials/general/enabled') && $this->extensionEnabled('Nover_Testimonials');
    }

    public function extensionEnabled($extensionName)
    {
        $modules = (array)Mage::getConfig()->getNode('modules')->children();
        if (
            !isset($modules[$extensionName])
            || $modules[$extensionName]->descend('active')->asArray() == 'false'
            || Mage::getStoreConfig('advanced/modules_disable_output/' . $extensionName)
        ) {
            return false;
        }
        return true;
    }

    public function getLayout($store = null)
    {
        return $this->conf(self::XML_PATH_LAYOUT, $store);
    }

    public function getTestimonialsUrl(){
        return $this->_getUrl('testimonials/list');
    }

    public function checkIfUserExisted($email){
        $user = Mage::getModel('customer/customer')
            ->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('email', $email )
            ->getFirstItem();
        return $user->getId()? $user->getId() : 0 ;
    }

    public function getTestimonialInfoUrl($id){
        return $this->_getUrl('testimonials/info', array('id' => $id));
    }
}