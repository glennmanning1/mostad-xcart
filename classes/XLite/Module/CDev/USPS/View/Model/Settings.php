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

namespace XLite\Module\CDev\USPS\View\Model;

/**
 * FedEx configuration form model
 */
class Settings extends \XLite\View\Model\AShippingSettings
{
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
            case 'cod_status':
                $cell[\XLite\View\FormField\Input\Checkbox\OnOff::PARAM_DISABLED] = true;
                $cell[\XLite\View\FormField\Input\Checkbox\OnOff::PARAM_ON_LABEL] = static::t('paymentStatus.Active');
                $cell[\XLite\View\FormField\Input\Checkbox\OnOff::PARAM_OFF_LABEL] = static::t('paymentStatus.Inactive');
                $cell[static::SCHEMA_COMMENT] = static::t(
                    'usps.CODStatusOptionComment',
                    array(
                        'URL' => $this->buildURL('payment_settings')
                    )
                );
                break;

            case 'cod_price':
                $cell[static::SCHEMA_DEPENDENCY] = array(
                    static::DEPENDENCY_SHOW => array(
                        'use_cod_price' => array(true),
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
     * Get editable options
     *
     * @return array
     */
    protected function getEditableOptions()
    {
        $list = parent::getEditableOptions();
        foreach ($list as $k => $option) {
            if ('cod_status' === $option->getName()) {
                unset($list[$k]);
            }
        }

        return $list;
    }
}
