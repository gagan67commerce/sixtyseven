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
namespace SixtySeven\Faq\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Faq extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{
    /**
     * Cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'sixtyseven_faq';    
    /**
     * @var string
     */
    protected $_cacheTag = 'sixtyseven_faq';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'sixtyseven_faq';
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('SixtySeven\Faq\Model\ResourceModel\Faq');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getProducts(\SixtySeven\Faq\Model\Faq $object)
    {
        $tbl = $this->getResource()->getTable(\SixtySeven\Faq\Model\ResourceModel\Faq::TBL_ATT_PRODUCT);
        
        $isEmptyQuery = $this->getResource()->getConnection()->select()->from(
            $tbl
        );

        $isEmpty = $this->getResource()->getConnection()->fetchAll($isEmptyQuery);
        if($isEmpty == null){
            return ;     
        } 

        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['product_id']
        )
        ->where(
            'faq_id = ?',
            (int)$object->getId()
        );
       
        return $this->getResource()->getConnection()->fetchCol($select);
    }

    public function getAllProducts()
    {
        $tbl = $this->getResource()->getTable(\SixtySeven\Faq\Model\ResourceModel\Faq::TBL_ATT_PRODUCT);
        
        $fetchQuery = $this->getResource()->getConnection()->select()->from(
            $tbl
        );

        return $this->getResource()->getConnection()->fetchAll($fetchQuery);
        
    }

    public function getFaqByProductId($id)
    {
        $tbl = $this->getResource()->getTable(\SixtySeven\Faq\Model\ResourceModel\Faq::TBL_ATT_PRODUCT);                
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl
        )
        ->where(
            'product_id = ?',
            $id
        );
        return $this->getResource()->getConnection()->fetchCol($select);
    }

    public function getFaqDataById($faqid)
    {
        $tbl = $this->getResource()->getTable('sixtyseven_faq');                
        $select = $this->getResource()->getConnection()->select()->
        from(
            $tbl
        )
        ->where(
            'faq_id = ?',
            $faqid
        )
        ->where('is_active = ?', 1);

        return $this->getResource()->getConnection()->fetchAll($select);
    }

    
}
