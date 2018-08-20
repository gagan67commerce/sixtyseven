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
namespace SixtySeven\Faq\Block\Links;

class Link extends \Magento\Framework\View\Element\Html\Link
{

    protected $_configHelper;

    /**
     * @return void
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \SixtySeven\Faq\Helper\Config $configHelper,
        array $data = []
    ) {
        $this->_configHelper = $configHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get Href for FAQ Page
     * @return URL
     */
    public function getHref()
    {
        return $this->_configHelper->getFaqPage();
    }

    /**
     * Return label
     *
     * @return string
     */
    public function getLabel()
    {
         return __('Frequently Asked Questions');
    }
}