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

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    
    const ADMIN_RESOURCE = 'SixtySeven_Faq::faq_edit';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('SixtySeven_Faq::faqs');
        return $resultPage;
    }
   
    public function execute()
    {
        // Get ID and create model
        $id = $this->getRequest()->getParam('faq_id');
        $model = $this->_objectManager->create('SixtySeven\Faq\Model\Faq');
        $model->setData([]);
        // Initial checking
        if ($id && (int) $id > 0) {
            $model->load($id);
            if (!$model->getFaqId()) {
                $this->messageManager->addError(__('This FAQ no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $title = $model->getTitle();
        }

        $formData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($formData)) {
            $model->setData($formData);
        }

        $this->_coreRegistry->register('sixtyseven_faq', $model);

        // Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit FAQ') : __('New FAQ'),
            $id ? __('Edit FAQ') : __('New FAQ')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('FAQs Manager'));
        $resultPage->getConfig()->getTitle()
            ->prepend($id ? 'Edit: '.$title.' ('.$id.')' : __('New FAQ'));

        return $resultPage;
    }
}