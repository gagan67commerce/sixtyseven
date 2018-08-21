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

namespace SixtySeven\Faq\Block\Adminhtml;

class Faq extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'SixtySeven_Faq';
        $this->_controller = 'Adminhtml_Faq';
        $this->_headerText = __("FAQ's Manager");
        $this->_addButtonLabel = __('Add New FAQ');
        parent::_construct();
    }
}
