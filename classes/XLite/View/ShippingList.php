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

namespace XLite\View;

/**
 * Shipping rates list
 */
class ShippingList extends \XLite\View\AView
{
    const DISPLAY_SELECTOR_CUTOFF = 5;

    const PARAM_CART = 'cart';

    /**
     * Modifier (cache)
     *
     * @var \XLite\Model\Order\Modifier
     */
    protected $modifier;

    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'form_field/js/shipping_list.js';

        return $list;
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
            static::PARAM_CART => new \XLite\Model\WidgetParam\Object('Cart', null, false, 'XLite\Model\Cart'),
        );
    }

    /**
     * Returns cart
     *
     * @return \XLite\Model\Cart
     */
    protected function getCart()
    {
        return $this->getParam(static::PARAM_CART) ?: \XLite::getController()->getCart();
    }

    /**
     * Get shipping rates
     *
     * @return array
     */
    protected function getRates()
    {
        return $this->getModifier()->getRates();
    }

    /**
     * Check - specified rate is selected or not
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate
     *
     * @return boolean
     */
    protected function isRateSelected(\XLite\Model\Shipping\Rate $rate)
    {
        return $this->getSelectedMethod()
            && $this->getSelectedMethod()->getMethodId() == $rate->getMethod()->getMethodId();
    }

    /**
     * Get selected rate
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function getSelectedMethod()
    {
        return $this->getModifier()->getSelectedRate()
            ? $this->getModifier()->getSelectedRate()->getMethod()
            : null;
    }

    /**
     * Get rate method id
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate
     *
     * @return integer
     */
    protected function getMethodId(\XLite\Model\Shipping\Rate $rate)
    {
        return $rate->getMethod()->getMethodId();
    }

    /**
     * Get rate method name
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate
     *
     * @return string
     */
    protected function getMethodName(\XLite\Model\Shipping\Rate $rate)
    {
        return $rate->getMethod()->getName();
    }

    /**
     * Returns delivery time for method
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate
     *
     * @return string
     */
    protected function getMethodDeliveryTime(\XLite\Model\Shipping\Rate $rate)
    {
        return $rate->getMethod() && 'offline' === $rate->getMethod()->getProcessor()
            ? $rate->getMethod()->getDeliveryTime()
            : '';
    }

    /**
     * Get rate markup
     *
     * @param \XLite\Model\Shipping\Rate $rate Shipping rate
     *
     * @return float
     */
    protected function getTotalRate(\XLite\Model\Shipping\Rate $rate)
    {
        return $rate->getTotalRate();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'shipping_list.tpl';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && $this->getModifier();
    }

    /**
     * Get modifier
     *
     * @return \XLite\Model\Order\Modifier
     */
    protected function getModifier()
    {
        return $this->getCart()->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
    }

    /**
     * Check - display shipping list as select-box or as radio buttons list
     *
     * @return boolean
     */
    protected function isDisplaySelector()
    {
        return static::DISPLAY_SELECTOR_CUTOFF < count($this->getRates());
    }

    /**
     * Get methods as plain list
     *
     * @return array
     */
    protected function getMethodsAsList()
    {
        $list = array();
        foreach ($this->getRates() as $rate) {
            $list[$this->getMethodId($rate)] = $this->getFormattedShippingName($rate);
        }

        return $list;
    }

    /**
     * Get formatted shipping name
     *
     * @param \XLite\Model\Shipping\Rate $rate Rate
     *
     * @return string
     */
    protected function getFormattedShippingName(\XLite\Model\Shipping\Rate $rate)
    {
        $deliveryTimeStr = $this->getMethodDeliveryTime($rate)
            ? sprintf(' (%s) ', $this->getMethodDeliveryTime($rate))
            : '';

        return $this->getMethodName($rate)
            . $deliveryTimeStr
            . ' - '
            . static::formatPrice($this->getTotalRate($rate), $this->getCart()->getCurrency());
    }

    /**
     * Returns field name
     *
     * @return string
     */
    protected function getFieldName()
    {
        return 'methodId';
    }

    /**
     * Returns field id
     *
     * @param \XLite\Model\Shipping\Rate $rate Rate
     *
     * @return string
     */
    protected function getFieldId(\XLite\Model\Shipping\Rate $rate)
    {
        return 'method' . $this->getMethodId($rate);
    }
}
