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

namespace SixtySeven\Faq\Block\Adminhtml\Faq;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * Constructor function
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    /**
     * Construct function
     */
    protected function _construct()
    {
        $this->_objectId = 'sixtyseven_faq_id';
        $this->_blockGroup = 'SixtySeven_Faq';
        $this->_controller = 'adminhtml_faq';
        parent::_construct();
    }
    /**
     * Prepare Layout 
     * @return Layout
     */
    protected function _preparelayout()
    {
        if ($this->_isAllowedAction('SixtySeven_Faq::faq_create') || $this->_isAllowedAction('SixtySeven_Faq::faq_edit')) {
            $this->buttonList->update('save', 'label', __('Save FAQ'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => [
                                'event' => 'saveAndContinueEdit',
                                'target' => '#edit_form'
                            ],
                        ],
                    ]
                ],
                -100
            );

            $faq = $this->_coreRegistry->registry('sixtyseven_faq');
            if (!empty($faq)) {
                if ($faq->getFaqId() && $this->_isAllowedAction('SixtySeven_Faq::faq_delete')) {
                    $this->buttonList->add(
                        'delete',
                        [
                            'label'   => __('Delete'),
                            'class'   => 'delete',
                            'onclick' => 'deleteConfirm("Are you sure you want to delete this item?", "'.$this->getDeleteUrl().'")'
                        ],
                        -100
                    );
                }
            }
        } else {
            $this->removeButton('save');
        }
        return parent::_prepareLayout();
    }

    /**
     * Check if Allowed 
     * @return Bool
     * @param $resourceId
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    /**
     * Get URL Delete
     * @return URL     
     */
    public function getDeleteUrl()
    {
        return $this->getUrl(
            '*/*/delete',
            [
                '_current' => true,
                'id' => $this->getRequest()->getParam('faq_id')
            ]
        );
    }

    /**
     * Save And Continue URL 
     * @return URL
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            [
                '_current' => true,
                'back' => 'edit',
                'active_tab' => ''
            ]
        );
    }
}