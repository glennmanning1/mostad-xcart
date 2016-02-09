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

namespace XLite\Module\CDev\Coupons\Controller\Customer;

/**
 * Coupon controller
 */
class Coupon extends \XLite\Controller\Customer\ACustomer
{

    /**
     * Controller marks the cart calculation.
     * On the checkout page we need cart recalculation
     *
     * @return boolean
     */
    protected function markCartCalculate()
    {
        return true;
    }

    /**
     * Apply coupon to the cart
     *
     * @return void
     */
    protected function doActionAdd()
    {
        $code = (string) \XLite\Core\Request::getInstance()->code;
        /** @var \XLite\Module\CDev\Coupons\Model\Coupon $coupon */
        $coupon = \XLite\Core\Database::getRepo('XLite\Module\CDev\Coupons\Model\Coupon')
            ->findOneByCode($code);

        $cart = $this->getCart();

        if ($coupon) {
            $error = $this->checkCompatibility($coupon, $cart);
        } else {
            $error = static::t(
                'There is no such a coupon, please check the spelling: X',
                array('code' => $code)
            );
        }

        if ('' === $error) {
            $cart->addCoupon($coupon);
            \XLite\Core\Database::getEM()->flush();

            $this->updateCart();
            \XLite\Core\TopMessage::addInfo('The coupon has been applied to your order');

        } elseif ($error) {
            \XLite\Core\Event::invalidElement('code', $error);
        }

        $this->setPureAction();
    }

    /**
     * @param \XLite\Module\CDev\Coupons\Model\Coupon $coupon Coupon
     * @param \XLite\Model\Order                      $cart   Cart
     *
     * @return string
     */
    protected function checkCompatibility($coupon, $cart)
    {
        $error = '';

        try {
            $coupon->checkUnique($cart);
            $coupon->checkCompatibility($cart);
        } catch (\XLite\Module\CDev\Coupons\Core\CompatibilityException $exception) {
            $error = static::t($exception->getMessage(), $exception->getParams());
        }

        return $error;
    }

    /**
     * Remove coupon from the cart
     *
     * @return void
     */
    protected function doActionRemove()
    {
        $id = (int) \XLite\Core\Request::getInstance()->id;

        $cart = $this->getCart();

        $usedCoupon = $this->getUsedCoupon($cart, $id);

        if ($usedCoupon) {
            $cart->removeUsedCoupon($usedCoupon);
            $this->updateCart();

            \XLite\Core\Database::getEM()->flush();

        } else {
            // Not found
            $this->valid = false;
        }

        $this->setPureAction();
    }

    /**
     * Get used coupon by id
     *
     * @param \XLite\Model\Order $cart Cart
     * @param integer            $id   Used coupon id
     *
     * @return \XLite\Module\CDev\Coupons\Model\UsedCoupon
     */
    protected function getUsedCoupon($cart, $id)
    {
        return array_reduce($cart->getUsedCoupons()->toArray(), function ($carry, $item) use ($id) {
            return $carry ?: ($item->getId() === $id ? $item : null);
        }, null);
    }
}
