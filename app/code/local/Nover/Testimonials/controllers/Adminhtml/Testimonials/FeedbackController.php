<?php
/**
 * PYCOGROUP
 * Author: phuong.nvh
 * Admin Testimonials Feedback Controller
 */

class Nover_Testimonials_Adminhtml_Testimonials_FeedbackController extends Mage_Adminhtml_Controller_Action {

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
        $this->_title("Testimonials Feedback List");
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new testimonial feedback action
     */
    public function newAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('testimonials/feedback')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('feedback_data', $model);

        $this->_initAction();
        $this->_title('Add new feedback');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this
            ->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_feedback_edit'));

        $this->renderLayout();
    }

    /**
     * Edit testimonial feedback action
     */
    public function editAction(){

        $id = $this->getRequest()->getParam('id');

        //Get all testimonials feedback
        $model = Mage::getModel('testimonials/feedback')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('feedback_data', $model);

            $this->_initAction();

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_feedback_edit'));
            $this->_title('Edit feedback');

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Feedback does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Save testimonial feedback action
     * @throws Exception
     */
    public function saveAction(){
        if ($data = $this->getRequest()->getPost()) {

            $feedbackData = $data;
            if($feedbackData["username"] != ""){
                $userEmail = $feedbackData["username"];
                $userExisted = Mage::helper('testimonials')->checkIfUserExisted($userEmail);
//                var_dump($user->getData());die;
                if(!$userExisted){
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('This user does not existed.'));
                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }
            }
            $feedback = Mage::getModel('testimonials/feedback');

            $feedback->setData($feedbackData);

            $feedback->setId($this->getRequest()->getParam('id'));

            try {
                $feedback->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Feedback was successfully saved'));
                ;                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $feedback->getId()));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Unable to find feedback to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Remove testimonials feedback function
     * @param $testimonialId
     * @throws Exception
     */
    protected function _feedbackDelete($feedbackId)
    {
        $feedback = Mage::getModel('testimonials/feedback')->load($feedbackId);

        $feedback->delete();
    }

    /**
     * Testimonial delete feedback action
     */
    public function deleteAction(){
        $feedbackId = (int)$this->getRequest()->getParam('id');
        if ($feedbackId) {
            try {
                $this->_feedbackDelete($feedbackId);
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Feedback was successfully deleted')
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
     * Remove testimonials feedback mass action
     */
    public function massDeleteAction(){
        $feedbackIds = $this->getRequest()->getParam('feedbacks');
        if (!is_array($feedbackIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select feedback(s)'));
        } else {
            try {
                foreach ($feedbackIds as $fId) {
                    $this->_feedbackDelete($fId);
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d feedback(s) were successfully removed', count($feedbackIds))
                );
            }
            catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Update testimonials feedback status mass action
     */
    public function massUpdateStatusAction(){
        $feedbackIds = $this->getRequest()->getParam('feedbacks');
        if (!is_array($feedbackIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select feedback(s)'));
        } else {
            try {
                $status = $this->getRequest()->getParam('status');
                foreach ($feedbackIds as $fId) {
                    //load testimonial info by testimonial ID
                    $feedback = Mage::getSingleton('testimonials/feedback')
                        ->load($fId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save()
                    ;
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d testimonial(s) were successfully changed status', count($feedbackIds))
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }
}