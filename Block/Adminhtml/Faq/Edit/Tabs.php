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
namespace SixtySeven\Faq\Block\Adminhtml\Faq\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{    
    protected function _construct()
    {
        parent::_construct();
        $this->setId('faq_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Question Info'));
    }

    protected function _beforeToHtml()
    {
        $this->setActiveTab('general_section');
        return parent::_beforeToHtml();
    }
}