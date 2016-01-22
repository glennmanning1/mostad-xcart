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

namespace XLite\View\Shipping;

/**
 * Online carrier status
 */
class CarrierStatus extends \XLite\View\AView
{
    const PARAM_METHOD = 'method';

    /**
     * Get css files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'shipping/carrier_status/style.css';

        return $list;
    }

    /**
     * Get js files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'shipping/carrier_status/controller.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'shipping/carrier_status/body.tpl';
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_METHOD
                => new \XLite\Model\WidgetParam\Object('Method', null, false, 'XLite\Model\Shipping\Method'),
        );
    }

    /**
     * Returns shipping method object
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function getMethod()
    {
        return $this->getParam(static::PARAM_METHOD);
    }

    /**
     * Returns style class
     *
     * @return string
     */
    protected function getClass()
    {
        return $this->isEnabled()
            ? 'alert alert-success'
            : 'alert alert-warning';
    }

    /**
     * Check if method is enabled
     *
     * @return boolean
     */
    protected function isEnabled()
    {
        $method = $this->getMethod();

        return $method && $method->isEnabled();
    }

    /**
     * Check if method is disabled
     *
     * @return boolean
     */
    protected function isDisabled()
    {
        return !$this->isEnabled();
    }

    /**
     * Check if method status is switchable
     *
     * @return boolean
     */
    protected function isSwitchable()
    {
        $method = $this->getMethod();

        return $method && $method->getProcessorObject() && $method->getProcessorObject()->isConfigured();
    }

    /**
     * Returns sign up URL
     *
     * @return string
     */
    protected function getSignUpURL()
    {
        $method = $this->getMethod();

        return $method && $method->getProcessorObject()
            ? $this->getMethod()->getProcessorObject()->getSignUpURL()
            : '';
    }

    /**
     * Returns processor code
     *
     * @return string
     */
    protected function getProcessor()
    {
        $method = $this->getMethod();

        return $method
            ? $method->getProcessor()
            : '';
    }
}
