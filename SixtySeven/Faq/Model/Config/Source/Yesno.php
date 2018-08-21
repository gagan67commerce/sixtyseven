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
namespace SixtySeven\Faq\Model\Config\Source;

class Yesno implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [];
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function getYesnoOptions()
    {
        $options = [
            '1' => __('Yes'),
            '0' => __('No'),
        ];

        $this->_options = $options;
        return $this->_options;
    }
}
