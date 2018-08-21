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


use Magento\Framework\View\Element\Template as Template;
class Faqtab extends Template
{
	protected $faqId;
    protected $_customerSession;
    /**     
     * @param FaqId $faqId
     * @param CustomerSession $_customerSession
     * @return void
     */
	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \SixtySeven\Faq\Model\Faq $faq,
        \SixtySeven\Faq\Helper\Data $dataHelper,
        \Magento\Customer\Model\Url $customerUrl,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\SessionFactory $_customerSession,
        array $data = []
        ) {
            $this->_isScopePrivate = true;
		    $this->faq = $faq;
		    $this->_registry = $registry;
            $this->_dataHelper = $dataHelper;
            $this->_customerUrl = $customerUrl;
            $this->_customerSession = $customerSession;
            $this->request = $request;
            $this->customerRepository = $customerRepository;
            $this->customerSession = $_customerSession;
            parent::__construct($context, $data);
            $this->setTabTitle();
    }
    /**     
     * Get Products Block for FAQ     
     * @return Array
     */
    public function getProductsBlock() {
        
        return $this->faq->getAllProducts();        
    	
    }
    /**     
     * Get Current Product Data     
     * @return Array
     */
    public function getCurrentProduct()
    {       
        return $this->_registry->registry('current_product');
    }
    /**     
     * Get Block Data by Current Product     
     * @return Array
     */
    public function getBlockFaqByProductId()
    { 
    	$id = $this->getCurrentProduct()->getId();
    	$faq_id = $this->faq->getFaqByProductId($id);    	
        return $faq_id;   
    }
    /**     
     * Get Block Faq Data by Current Product ID     
     * @return Array
     */
    public function getBlockFaqDataById()
    { 
    	$faqData = $this->getBlockFaqByProductId();
    	$faqDataArray = array();
        $i=0;
    	foreach ($faqData as $faqvalue) {                		  
    		$faqDataArray[] = $this->faq->getFaqDataById($faqvalue);	            	    	
            $i++;
    	}    	    	
        return $faqDataArray;   
    }
    /**     
     * Set Title of Tab on Product Details Page     
     * @return void
     */
    public function setTabTitle()
    {
        $controller = $this->getRequest()->getControllerName();
        if($controller == 'product'){
            $id = $this->getCurrentProduct()->getId();
            $faqArr = $this->faq->getFaqByProductId($id);
            $faqCount =  count($faqArr);
             $title = "QUESTIONS";
            return $this->setTitle($title);
        }    
    }
}