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

namespace XLite\Module\CDev\FedEx\Controller\Admin;

/**
 * FedEx module settings page controller
 */
class Fedex extends \XLite\Controller\Admin\ShippingSettings
{
    /**
     * Returns shipping options
     *
     * @return array
     */
    public function getOptions()
    {
        $list = array();
        foreach (parent::getOptions() as $option) {
            if ('cod_type' !== $option->getName() || $this->isFedExCODPaymentEnabled()) {
                $list[] = $option;
            }

            if ('cacheOnDeliverySeparator' === $option->getName()) {
                $list[] = new \XLite\Model\Config(array(
                    'name'        => 'cod_status',
                    'type'        => 'XLite\View\FormField\Input\Checkbox\OnOff',
                    'value'       => $this->isFedExCODPaymentEnabled() ? true : false,
                    'orderby'     => $option->getOrderby() + 1,
                    'option_name' => static::t('"Cash on delivery" status'),
                ));
            }
        }

        return $list;
    }

    /**
     * getOptionsCategory
     *
     * @return string
     */
    protected function getOptionsCategory()
    {
        return 'CDev\FedEx';
    }

    /**
     * Class name for the \XLite\View\Model\ form (optional)
     *
     * @return string|void
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\CDev\FedEx\View\Model\Settings';
    }


    /**
     * Get shipping processor
     *
     * @return \XLite\Model\Shipping\Processor\AProcessor
     */
    protected function getProcessor()
    {
        return new \XLite\Module\CDev\FedEx\Model\Shipping\Processor\FEDEX();
    }

    /**
     * Returns request data
     *
     * @return array
     */
    protected function getRequestData()
    {
        $list = parent::getRequestData();
        $list['dimensions'] = serialize($list['dimensions']);

        return $list;
    }

    /**
     * Check if 'Cash on delivery (FedEx)' payment method enabled
     * @todo: rename
     *
     * @return boolean
     */
    protected function isFedExCODPaymentEnabled()
    {
        return \XLite\Module\CDev\FedEx\Model\Shipping\Processor\FEDEX::isCODPaymentEnabled();
    }

    /**
     * Get schema of an array for test rates routine
     *
     * @return array
     */
    protected function getTestRatesSchema()
    {
        $schema = parent::getTestRatesSchema();
        foreach (array('srcAddress', 'dstAddress') as $k) {
            unset($schema[$k]['city'], $schema[$k]['state']);
        }

        return $schema;
    }

    /**
     * Get input data to calculate test rates
     *
     * @param array $schema  Input data schema
     * @param array &$errors Array of fields which are not set
     *
     * @return array
     */
    protected function getTestRatesData(array $schema, &$errors)
    {
        $data = parent::getTestRatesData($schema, $errors);

        $package = array(
            'weight'   => $data['weight'],
            'subtotal' => $data['subtotal'],
        );

        $data['packages'] = array($package);

        unset($data['weight'], $data['subtotal']);

        return $data;
    }
}
