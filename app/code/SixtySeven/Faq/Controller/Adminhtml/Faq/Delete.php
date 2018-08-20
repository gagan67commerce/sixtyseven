<?php
/**
 * FAQ Extension
 *
 * @package SixtySeven Commerce
 * @author SixtySeven Commerce - All Rights Reserved
 * @copyright 2018 SixtySeven Commerce
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */
namespace SixtySeven\Faq\Controller\Adminhtml\Faq;

use SixtySeven\Faq\Model\ResourceModel\Faq;

class Delete extends \Magento\Backend\App\Action
{
    
    const ADMIN_RESOURCE = 'SixtySeven\Faq::faq_delete';

    
    public function execute()
    {
        // check if we know what should be deleted
        $faq_id = $this->getRequest()->getParam('faq_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($faq_id && (int) $faq_id > 0) {
            $title = '';
            try {
                // init model and delete
                $model = $this->_objectManager->create('SixtySeven\Faq\Model\Faq');
                $model->load($faq_id);
                if ($model->getFaqId()) {
                    $title = $model->getTitle();

                    $model->delete();

                    $this->messageManager->addSuccess(__('The "'.$title.'" FAQ has been deleted.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['faq_id' => $faq_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('FAQ to delete was not found.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}