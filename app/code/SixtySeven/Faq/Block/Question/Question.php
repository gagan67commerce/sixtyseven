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
namespace SixtySeven\Faq\Block\Question;

use Magento\Framework\View\Element\Template\Context;
use SixtySeven\Faq\Helper\Question as QuestionHelper;
use SixtySeven\Faq\Model\ResourceModel\Faq;
use SixtySeven\Faq\Helper\Config as ConfigHelper;
use Magento\Cms\Model\Template\FilterProvider;

class Question extends \Magento\Framework\View\Element\Template
{
    
    protected $_questionHelper;

    
    protected $_configHelper;

    
    protected $_faqContent = null;

    
    protected $_faqTitle = null;

    
    protected $_faqCreated = null;

    
    protected $_faqViewed = null;

    
    protected $_userFullName = null;

    
    protected $_faqCategoryTitle = null;

    
    protected $_relatedQuestion = null;

    
    protected $_faqId = null;
    protected $_getLiked = null;
    protected $_getDisliked = null;

    
    protected $filterProvider;
    protected $_faqTab;

    
    public function __construct(
        Context $context,
        QuestionHelper $questionHelper,
        ConfigHelper $configHelper,
        \SixtySeven\Faq\Block\Product\View\Details\Faqtab $_faqTab, 
        FilterProvider $filterProvider
    ) {
        $this->_questionHelper = $questionHelper;
        $this->_configHelper = $configHelper;
        $this->filterProvider = $filterProvider;
        $this->_faqTab    = $_faqTab;
        parent::__construct($context);
    }

    
    public function filterProvider($content)
    {
        return $this->filterProvider->getBlockFilter()
            ->setStoreId($this->_storeManager->getStore()->getId())
            ->filter($content);
    }

    
    protected function getFaq()
    {
        $faq_id = $this->getRequest()->getParam('faq_id');
        return $this->_questionHelper->getFaq($faq_id);
    }


    /**
     * Return Prepare Layout Parent
     *
     * @return parent
     */
    protected function _prepareLayout()
    {
        $faq = $this->getFaq();

        $this->_faqContent   = $faq->getContent();
        $this->_faqTitle     = $faq->getTitle();
        $this->_faqCreated   = $faq->getCreationTime();
        $this->_faqViewed    = $faq->getViewed();
        $this->_userFullName = $faq->getFullName();
        $this->_faqId        = $faq->getFaqId();
        $this->_getLiked     = $faq->getLiked();
        $this->_getDisliked  = $faq->getDisliked();

        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');

        $breadcrumbsBlock->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link'  => $this->_storeManager->getStore()->getBaseUrl()
            ]
        );

        $breadcrumbsBlock->addCrumb(
            'faq',
            [
                'label' => __('FAQs'),
                'title' => __('Go to FAQs Page'),
                'link'  => $this->_storeManager->getStore()->getBaseUrl().Faq::FAQ_REQUEST_PATH
            ]
        );

        

        $breadcrumbsBlock->addCrumb(
            'faq.question.view',
            [
                'label' => $this->_faqTitle,
                'title' => $this->_faqTitle
            ]
        );

        $this->pageConfig->getTitle()->set(__('FAQs'));

        $this->pageConfig->getTitle()->prepend($this->_faqTitle);

        $this->pageConfig->setKeywords($faq->getMetaKeywords()? $faq->getMetaKeywords() : $this->_faqTitle);

        $this->pageConfig->setDescription($faq->getMetaDescription()? $faq->getMetaDescription() : $this->_faqTitle);

        return parent::_prepareLayout();
    }


    /**
     * Get the full name of author, who created the question
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->_userFullName;
    }

    /**
     * Get the content of question
     *
     * @return string
     */
    public function getFaqContent()
    {
        return $this->_faqContent;
    }

    /**
     * Get the title of question
     *
     * @return string
     */
    public function getFaqTitle()
    {
        return $this->_faqTitle;
    }

    /**
     * Get the creation time of question
     *
     * @return string
     */
    public function getFaqCreated()
    {
        return $this->_faqCreated;
    }

    /**
     * Get the view number of question
     *
     * @return string
     */
    public function getFaqViewed()
    {
        return $this->_faqViewed;
    }

    /**
     * Get the list of related questions
     *
     * @param $faq_id and $category_id
     * @return string
     */
    public function getRelatedQuestion()
    {
        return $this->_relatedQuestion;
    }

    /**
     * Get the question id
     *
     * @return string
     */
    public function getFaqId()
    {
        return $this->_faqId;
    }
    public function getLiked()
    {
        return $this->_getLiked;
    }
    public function getDisliked()
    {
        return $this->_getDisliked;
    }

    /**
     * Get the URL of question
     *
     * @param $identifier
     * @return string
     */
    public function getFaqFullPath($identifier)
    {
        return $this->_configHelper->getFaqFullPath($identifier);
    }

    /**
     * Get Ajax URL
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->_storeManager->getStore()->getUrl('faq/question/ajax/faq_id/'.$this->getRequest()->getParam('faq_id'), [
        '_secure' => $this->_storeManager->getStore()->isCurrentlySecure()]);
    }

    
    public function getFaqBlockData()
    {       
        return $this->_faqTab;
    }
}
