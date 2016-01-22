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

namespace XLite\View\ShippingEstimator;

/**
 * Selected shipping method view
 */
class SelectedMethod extends \XLite\View\AView
{
    /**
     * Widget parameters
     */
    const PARAM_CART = 'cart';

    /**
     * Shipping modifier
     *
     * @var \XLite\Model\Order\Modifier
     */
    protected $modifier;

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_CART => new \XLite\Model\WidgetParam\Object(
                'Cart',
                $this->getDefaultCart(),
                false,
                'XLite\Model\Cart'
            ),
        );
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'shopping_cart/parts/box.estimator.method.tpl';
    }

    /**
     * Returns default cart value
     *
     * @return \XLite\Model\Cart
     */
    protected function getDefaultCart()
    {
        return \XLite::getController()->getCart();
    }

    /**
     * Get modifier
     *
     * @return \XLite\Model\Order\Modifier
     */
    protected function getModifier()
    {
        if (null === $this->modifier) {
            $this->modifier = $this->getCart()->getModifier(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, 'SHIPPING');
        }

        return $this->modifier;
    }

    /**
     * Returns method name
     *
     * @return string
     */
    protected function getName()
    {
        return $this->getModifier()->getMethod()->getName();
    }

    /**
     * Get shipping cost
     *
     * @return float
     */
    protected function getCost()
    {
        $cart = $this->getCart();
        $cost = $cart->getSurchargesSubtotal(\XLite\Model\Base\Surcharge::TYPE_SHIPPING, false);

        return static::formatPrice($cost, $cart->getCurrency(), !\XLite::isAdminZone());
    }

    /**
     * Returns current cart
     *
     * @return \XLite\Model\Cart
     */
    protected function getCart()
    {
        return $this->getParam(static::PARAM_CART);
    }
}
