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
namespace SixtySeven\Faq\Controller\Index;

use Magento\Framework\Controller\ResultFactory;


class Product extends \Magento\Framework\App\Action\Action
{
    protected $_coreRegistry;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \SixtySeven\Faq\Model\ResourceModel\Faq\CollectionFactory $faqCollectionFactory,
        \SixtySeven\Faq\Controller\Adminhtml\Faq\Save $save

    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_save = $save;
        parent::__construct($context);
    }   
    public function execute()
    {
        
        // 1. POST request : Get booking data
         
        $data = $this->getRequest()->getPostValue();
        $data['is_active'] = '0';   

        if (!empty($data)) {
            // Retrieve your form data  
            $id = $this->getRequest()->getParam('faq_id');
            $model = $this->_objectManager->create('SixtySeven\Faq\Model\Faq')->load($id);
            
            if (!$model->getFaqId() && $id) {
                $this->messageManager->addError(__('This FAQ no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $model->setData($data);

            $this->_eventManager->dispatch(
                'faq_faq_prepare_save',
                ['faq' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();

   
                $this->_save->saveProducts($model, $data);
                $this->messageManager->addSuccess(__('Thanks! We will get back to you.'));

                return;
                
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the FAQ.'));
                // $this->messageManager->addError($e->getMessage());
            }

            // // Redirect to your form page (or anywhere you want...)
            // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            // $resultRedirect->setUrl('/faq/frontend_product/index');

            //return $resultRedirect;
        }
        // 2. GET request : Render the booking page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}