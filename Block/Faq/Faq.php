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

namespace SixtySeven\Faq\Block\Faq;

use Magento\Framework\View\Element\Template\Context;
use SixtySeven\Faq\Helper\Question as QuestionHelper;
use SixtySeven\Faq\Model\ResourceModel\Faq as FaqResourceModel;
use Magento\Framework\App\Filesystem\DirectoryList;
use SixtySeven\Faq\Helper\Config as ConfigHelper;
use Magento\Cms\Model\Template\FilterProvider;

class Faq extends \Magento\Framework\View\Element\Template
{
    
    protected $_questionHelper;

    
    protected $_categoryHelper;

    
    protected $_faqResourceModel;

    
    protected $_directoryList;

    
    protected $_faqCategoriesList = null;

    
    protected $_configHelper;

    
    protected $filterProvider;

    /**
     *
     * @param Context $context
     * @param DirectoryList $directoryList
     * @param FaqResourceModel $faqResourceModel
     * @param ConfigHelper $configHelper
     * @param FilterProvider $filterProvider
     */
    /**
     * @return void
     */
    public function __construct(
        Context $context,
        QuestionHelper $questionHelper,
        DirectoryList $directoryList,
        FaqResourceModel $faqResourceModel,
        ConfigHelper $configHelper,
        FilterProvider $filterProvider
    ) {
        $this->_questionHelper = $questionHelper;
        $this->_directoryList = $directoryList;
        $this->_faqResourceModel = $faqResourceModel;
        $this->_configHelper = $configHelper;
        $this->filterProvider = $filterProvider;
        parent::__construct($context);
    }

    /**
     * @return parent
     */
    protected function _prepareLayout()
    {

        $this->pageConfig->getTitle()->set(__('FAQs'));

        $this->pageConfig->setKeywords(__('FAQs'));

        $this->pageConfig->setDescription(__('FAQs'));

        $breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs');

        $breadcrumbBlock->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Home'),
                'link' => $this->_storeManager->getStore()->getBaseUrl(),
            ]
        );

        $breadcrumbBlock->addCrumb(
            'faq',
            [
                'label' => __('FAQs'),
                'title' => __('FAQs')
            ]
        );

        return parent::_prepareLayout();
    }

    /**
     * Filter provider
     *
     * @param string $content
     * @return string
     */
    public function filterProvider($content)
    {
        return $this->filterProvider->getBlockFilter()
            ->setStoreId($this->_storeManager->getStore()->getId())
            ->filter($content);
    }

    /**
     * Get the questions most frequently
     *
     * @return array|bool
     */
    public function getFrequentlyAskedQuestion()
    {
        return $this->getFaq(1);
    }

    /**
     * Get the latest questions
     *
     * @return array|bool
     */
    public function getLatestFAQ()
    {
        return $this->getFaq(null, 1);
    }

    /**
     * Get the questions
     *
     * @return array|bool
     */
    public function getFaq($frequently = null, $latest = null)
    {
        $select = $this->_faqResourceModel->getConnection()->select()
            ->from(['faq' => $this->_faqResourceModel->getMainTable()])
            ->joinLeft(
                ['faq_store' => $this->_faqResourceModel->getTable('sixtyseven_faq_store')],
                'faq.faq_id = faq_store.faq_id',
                ['store_id']
            )
            ->where('faq_store.store_id =?', $this->_storeManager->getStore()->getStoreId())
            ->where('faq.is_active = ?', '1');

        if ($frequently) {
            $select->where('faq.most_frequently = ?', '1');
        }

        $select->group('faq.faq_id');

        if ($frequently) {
            $select->order('faq.sort_order ASC');
        }

        if ($latest) {
            $select->where('faq.most_frequently <> ?', '1');
            $select->order('faq.sort_order ASC');
        }

        if ($results = $this->_faqResourceModel->getConnection()->fetchAll($select)) {
            return $results;
        }
        return false;
    }

    

    /**
     * Get URL of the files in pub/media folder
     *
     * @param $path
     * @return string
     */
    public function getFileBaseUrl($path)
    {
        return $this->_configHelper->getFileBaseUrl($path);
    }

    /**
     * Get URL of the question
     *
     * @param $identifier
     * @return string
     */
    public function getFaqFullPath($identifier)
    {
        return $this->_configHelper->getFaqFullPath($identifier);
    }
}