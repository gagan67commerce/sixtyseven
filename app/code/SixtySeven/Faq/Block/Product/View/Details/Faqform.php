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
namespace SixtySeven\Faq\Block\Product\View\Details;

class Faqform extends \Magento\Framework\View\Element\Template
{

	protected $faqId;
    /**     
     * @param FaqId $faqId
     */
    /**
     * @return void
     */
	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \SixtySeven\Faq\Model\Faq $faq,
        \Magento\Framework\Registry $registry,
        array $data = []
        ) {
		    $this->faq = $faq;
		    $this->_registry = $registry;
            parent::__construct($context, $data);
    }
    /**
     * Get URL To Ajax form Submit
     * @return URL
     */
    public function getFormAction()
    {
        return 'faq/index/product';        
    }
    /**
     * Get Current Product Data
     * @return Array | Bool
     */
    public function getCurrentProduct()
    {       
        return $this->_registry->registry('current_product');
    }     
    
}