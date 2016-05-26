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

namespace XLite\Module\CDev\Coupons\View;

/**
 * Cart coupons
 *
 * @ListChild (list="cart.panel.box", weight="200")
 * @ListChild (list="checkout.review.selected", weight="15")
 */
class CartCoupons extends \XLite\View\AView
{
    /**
     * Used coupons list (local cache)
     *
     * @var   array
     */
    protected $coupons;

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/CDev/Coupons/cart_coupons.css';

        return $list;
    }

    /**
     * Get a list of JavaScript files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/CDev/Coupons/cart_coupons.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/CDev/Coupons/cart_coupons.tpl';
    }

    // {{{ Content helpers

    /**
     * Get coupons
     *
     * @return array
     */
    protected function getCoupons()
    {
        if (null === $this->coupons) {
            $this->coupons = $this->getCart()->getUsedCoupons()->toArray();
        }

        return $this->coupons;
    }

    // }}}

    /**
     * Check if coupon panel 'Have a discount coupon?' is visible
     *
     * @return boolean
     */
    protected function isCouponPanelVisible()
    {
        return !$this->getCart()->hasSingleUseCoupon();
    }
}
