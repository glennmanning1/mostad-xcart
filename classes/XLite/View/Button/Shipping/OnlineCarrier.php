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

namespace XLite\View\Button\Shipping;

/**
 * Online carrier popup link
 */
class OnlineCarrier extends \XLite\View\Button\Link
{
    const PARAM_METHOD = 'method';

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
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/shipping/online_carrier.tpl';
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
     * Return CSS classes
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass() . ' add-shipping-carrier-link';
    }

    /**
     * Return button text
     *
     * @return string
     */
    protected function getButtonLabel()
    {
        return $this->getMethod()->getProcessorObject()->getProcessorName();
    }

    /**
     * We make the full location path for the provided URL
     *
     * @return string
     */
    protected function getLocationURL()
    {
        $method = $this->getMethod();

        return $method->getProcessorObject()->getSettingsURL();
    }
}
