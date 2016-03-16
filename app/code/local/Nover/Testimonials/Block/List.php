<?php

class Nover_Testimonials_Block_List extends Mage_Core_Block_Template {

    public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel('testimonials/info')->getEnabledTestimonials();
        $this->setCollection($collection);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(
                2 => 2,
                5 => 5,
                'all' => 'all'
        ));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
