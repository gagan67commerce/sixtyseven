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

class Urlkey
{
    /**
     * Generate identifier from the string
     *
     * @param $string
     * @return string
     */
    public function generateIdentifier($string)
    {
        $string = trim($string);

        $string = strtolower($string);

        while (stristr($string, '-')) {
            $string = str_replace('-', ' ', $string);
        }

        while (stristr($string, '  ')) {
            $string = str_replace('  ', ' ', $string);
        }

        $filter = new \Zend\I18n\Filter\Alnum(true);

        $string = $filter->filter($string);

        $string = str_replace(' ', '-', $string);

        while (stristr($string, '--')) {
            $string = str_replace('--', '-', $string);
        }

        return $string;
    }    
    
}
