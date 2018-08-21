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

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    protected $faqCollectionFactory;
    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \SixtySeven\Faq\Model\ResourceModel\Faq\CollectionFactory $faqCollectionFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();      
        if ($data) {
            $id = $this->getRequest()->getParam('faq_id');

            /** @var \SixtySeven\Faq\Model\Faq $model */
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

                $this->saveProducts($model, $data);

                $this->messageManager->addSuccess(__('You saved the FAQ.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['faq_id' => $model->getFaqId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the FAQ.'));
                // $this->messageManager->addError($e->getMessage());
            }

            $this->_getSession()->setFormData($data);
            if ($this->getRequest()->getParam('faq_id')) {
                return $resultRedirect->setPath('*/*/edit', ['faq_id' => $this->getRequest()->getParam('faq_id')]);
            }
            return $resultRedirect->setPath('*/*/new');
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        if ($this->_authorization->isAllowed('SixtySeven_Faq::faq_edit') || $this->_authorization->isAllowed('SixtySeven_Faq::faq_create')) {
            return true;
        }
        return false;
    }

    public function saveProducts($model, $post)
    {
        
        if (isset($post['products'])) {
            //$productIds = $this->_jsHelper->decodeGridSerializedInput($post['products']);
            
            if (strpos($post['products'], '&') == false) {
                $productIds = $post['products'];
            } else{
                
                $productsArr = explode('&',$post['products']);

                $productIds = $productsArr;


            }

            try {
                $oldProducts = (array) $model->getProducts($model);
                $newProducts = (array) $productIds;

                $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = $this->_resources->getTableName(\SixtySeven\Faq\Model\ResourceModel\Faq::TBL_ATT_PRODUCT);
                $insert = array_diff($newProducts, $oldProducts);
                $delete = array_diff($oldProducts, $newProducts);
               
                if ($delete) {
                    $where = ['faq_id = ?' => (int)$model->getId(), 'product_id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

                if ($insert) {
                    $data = [];
                    foreach ($insert as $product_id) {
                        $data[] = ['faq_id' => (int)$model->getId(), 'product_id' => (int)$product_id,
                        'is_active' => (int)$post['is_active']];
                    }
                    $connection->insertMultiple($table, $data);
                }
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the products.'));
            }
        }
        if(!isset($post['products'])) {

            $resource = \Magento\Framework\App\ObjectManager::getInstance()
                            ->create('\Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection
                            (\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
            $values = $connection->fetchAll('select * from `sixtyseven_faq_attachment_rel` where faq_id = '.$post['faq_id'] );
            if ($values) {
                $sql = "Update `sixtyseven_faq_attachment_rel` Set is_active = ".$post['is_active']." where faq_id = ".$post['faq_id'];
                $connection->query($sql);
            }            
        }

    }
}
