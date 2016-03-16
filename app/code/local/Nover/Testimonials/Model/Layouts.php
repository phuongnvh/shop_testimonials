<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Testimonials Layout Class
 */

class Nover_Testimonials_Model_Layouts
{
    protected $_options = null;

    public function toOptionArray()
    {
        if ($this->_options === null) {
            $this->_options = array();
            foreach (Mage::getSingleton('page/config')->getPageLayouts() as $layout) {
                $this->_options[] = array(
                    'value' => $layout->getTemplate(),
                    'label' => $layout->getLabel(),
                );
            }
        }
        return $this->_options;
    }
}