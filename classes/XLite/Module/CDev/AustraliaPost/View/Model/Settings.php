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

namespace XLite\Module\CDev\AustraliaPost\View\Model;

/**
 * Australia post configuration form model
 */
class Settings extends \XLite\View\Model\AShippingSettings
{
    /**
     * Get schema fields
     *
     * @return array
     */
    public function getSchemaFields()
    {
        $config = \XLite\Core\Config::getInstance()->CDev->AustraliaPost;

        return $config->optionValues
            ? parent::getSchemaFields()
            : array();
    }

    /**
     * Get editable options
     *
     * @return array
     */
    protected function getEditableOptions()
    {
        $options = parent::getEditableOptions();

        foreach ($options as $key => $option) {
            if ($option->getName() === 'optionValues') {
                unset($options[$key]);
            }
        }

        return $options;
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
        return 'dimensions' === $option->getName()
            ? 'XLite\View\FormField\Input\Text\Dimensions'
            : parent:: detectFormFieldClassByOption($option);
    }

    /**
     * Get form field by option
     *
     * @param \XLite\Model\Config $option Option
     *
     * @return array
     */
    protected function getFormFieldByOption(\XLite\Model\Config $option)
    {
        $cell = parent::getFormFieldByOption($option);

        switch ($option->getName()) {
            case 'api_key':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'test_mode' => array(false),
                    ),
                );
                break;

            case 'dimensions':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'package_box_type' => array('AUS_PARCEL_TYPE_BOXED_OTH'),
                    ),
                );
                break;

            case 'extra_cover_value':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'extra_cover' => array(true),
                    ),
                );
                break;
        }


        return $cell;
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
        if ('dimensions' === $name) {
            $value = unserialize($value);
        }

        return $value;
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = array();

        $buttons = parent::getFormButtons();
        $submit = $buttons['submit'];

        unset($buttons['submit']);

        $config = \XLite\Core\Config::getInstance()->CDev->AustraliaPost;
        if ($config->optionValues) {
            $result['submit'] = $submit;

            $url = $this->buildURL('aupost', 'renew_settings');
            $result['module_settings'] = new \XLite\View\Button\ProgressState(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL   => 'Renew available settings',
                    \XLite\View\Button\AButton::PARAM_STYLE   => 'action always-enabled',
                    \XLite\View\Button\Regular::PARAM_JS_CODE => 'self.location=\'' . $url . '\'',
                )
            );
        } else {
            $url = $this->buildURL('aupost', 'renew_settings');
            $result['module_settings'] = new \XLite\View\Button\ProgressState(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL    => 'Get module settings',
                    \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                    \XLite\View\Button\AButton::PARAM_STYLE    => 'action always-enabled',
                    \XLite\View\Button\Regular::PARAM_JS_CODE  => 'self.location=\'' . $url . '\'',
                )
            );
        }

        return $result + $buttons;
    }
}
