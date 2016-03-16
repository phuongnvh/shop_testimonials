<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Admin Testimonials Controller
 */

class Nover_Testimonials_Adminhtml_TestimonialsController extends Mage_Adminhtml_Controller_Action {

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/nover/testimonials');
    }

    protected function _initAction()
    {
        $this
            ->loadLayout()
            ->_setActiveMenu('nover/testimonials')
        ;

        return $this;
    }

    public function indexAction(){
        $this->_forward('list');
    }

    public function listAction(){
        $this->_title("Testimonials List");
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new testimonial action
     */
    public function newAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('testimonials/info')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('testimonial_data', $model);

        $this->_initAction();
        $this->_title('Add new testimonial');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this
            ->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit'));

        $this->renderLayout();
    }

    /**
     * Edit testimonial action
     */
    public function editAction(){

        $id = $this->getRequest()->getParam('id');

        //Get all testimonials info
        $model = Mage::getModel('testimonials/info')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('testimonial_data', $model);

            $this->_initAction();

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit'));
            $this->_title('Edit testimonial');

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Testimonial does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Save testimonial action
     * @throws Exception
     */
    public function saveAction(){
        if ($data = $this->getRequest()->getPost()) {

            $infoData = $data;

            $info = Mage::getModel('testimonials/info');

            $info->setData($infoData);

            $info->setId($this->getRequest()->getParam('id'));

            try {
                $info->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Testimonial was successfully saved'));
                ;                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $info->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch(Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__($e->getMessage()));
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Unable to find testimonial to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Remove testimonials function
     * @param $testimonialId
     * @throws Exception
     */
    protected function _testimonialDelete($testimonialId)
    {
        $info = Mage::getModel('testimonials/info')->load($testimonialId);
        $feedbacks = Mage::getModel('testimonials/feedback')->getFeedbackByTestiId($testimonialId);

        foreach($feedbacks as $fb){
            $fb->delete();
        }

        $info->delete();
    }

    /**
     * Testimonial delete action
     */
    public function deleteAction(){
        $testimonialId = (int)$this->getRequest()->getParam('id');
        if ($testimonialId) {
            try {
                $this->_testimonialDelete($testimonialId);
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Testimonial was successfully deleted')
                );
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Remove testimonials mass action
     */
    public function massDeleteAction(){
        $testimonialIds = $this->getRequest()->getParam('testimonials');
        if (!is_array($testimonialIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select testimonial(s)'));
        } else {
            try {
                foreach ($testimonialIds as $tId) {
                    $this->_testimonialDelete($tId);
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d testimonial(s) were successfully removed', count($testimonialIds))
                );
            }
            catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Update testimonials status mass action
     */
    public function massUpdateStatusAction(){
        $testimonialIds = $this->getRequest()->getParam('testimonials');
        if (!is_array($testimonialIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select testimonial(s)'));
        } else {
            try {
                $status = $this->getRequest()->getParam('status');
                foreach ($testimonialIds as $tId) {
                    //load testimonial info by testimonial ID
                    $info = Mage::getSingleton('testimonials/info')
                        ->load($tId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save()
                    ;
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d testimonial(s) were successfully changed status', count($testimonialIds))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }
}