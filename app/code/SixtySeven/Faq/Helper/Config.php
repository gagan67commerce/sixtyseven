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
namespace SixtySeven\Faq\Helper;

use Magento\Store\Model\StoreManagerInterface;
use SixtySeven\Faq\Model\ResourceModel\Faq as FaqResourceModel;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Config Helper
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class Config
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param StoreManagerInterface $storeManager
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }


    /**
     * Get URL of the files in pub/media folder
     *
     * @param $path
     * @return string
     */
    public function getFileBaseUrl($path)
    {
        return '/'.DirectoryList::PUB.'/'.DirectoryList::MEDIA.'/'.$path;
    }

    /**
     * Get URL of the category
     *
     * @param $identifier
     * @return string
     */
    public function getFaqFullPath($identifier)
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_QUESTION_PATH.'/'.$identifier.FaqResourceModel::FAQ_DOT_HTML;
    }

    /**
     * Get URL of the FAQ page
     *
     * @return string
     */
    public function getFaqPage()
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_REQUEST_PATH;
    }
}
