<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\XC\PitneyBowes\View\Model;

/**
 * PitneyBowes configuration form model
 */
class Settings extends \XLite\View\Model\AShippingSettings
{
     /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        $requestCredentialsBtn = new \XLite\Module\XC\PitneyBowes\View\Button\CredentialsForm(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL    => 'Request credentials',
                \XLite\View\Button\AButton::PARAM_STYLE    => 'action always-enabled',
            )
        );

        $result = static::arrayInsertBefore('shipping_methods', $result, 'request', $requestCredentialsBtn);

        return $result;
    }

    /**
     * Inserts a new key/value before the key in the array.
     *
     * @param $key
     *   The key to insert before.
     * @param $array
     *   An array to insert in to.
     * @param $new_key
     *   The key to insert.
     * @param $new_value
     *   The value to insert.
     *
     * @return
     *   The new array if the key exists, FALSE otherwise.
     *
     */
    protected static function arrayInsertBefore($key, array $array, $new_key, $new_value)
    {
        if (array_key_exists($key, $array)) {
            $new = array();
            foreach ($array as $k => $value) {
                if ($k === $key) {
                    $new[$new_key] = $new_value;
                }
                $new[$k] = $value;
            }

            return $new;
        }

        return false;
    }

    // {{{ Oh my god why

    /**
     * Get list of counties selectors
     * 
     * @return array
     */
    protected function getCountriesSelector()
    {
        return array(
            'applicable_countries',
            'free_transportation_countries',
            'free_importation_countries',
        );
    }

    /**
     * Check if given name is for countries selector
     * 
     * @return array
     */
    protected function isCountriesSelector($optionName)
    {
        return in_array($optionName, $this->getCountriesSelector());
    }

    /**
     * Detect form field class by option
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return string
     */
    protected function detectFormFieldClassByOption(\XLite\Model\Config $option)
    {
        return $this->isCountriesSelector($option->getName())
            ? 'XLite\Module\XC\PitneyBowes\View\FormField\Select\Country'
            : parent:: detectFormFieldClassByOption($option);
    }

    /**
     * Retrieve property from the model object
     *
     * @param mixed $name Field/property name
     *
     * @return mixed
     */
    protected function getModelObjectValue($name)
    {
        $value = parent::getModelObjectValue($name);

        if ($this->isCountriesSelector($name)) {
            $value = unserialize($value);
        }

        return $value;
    }

    // }}}
}
