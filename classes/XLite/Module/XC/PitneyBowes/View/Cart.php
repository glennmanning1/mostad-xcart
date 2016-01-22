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

namespace XLite\Module\XC\PitneyBowes\View;

/**
 * Cart widget
 */
class Cart extends \XLite\View\Cart implements \XLite\Base\IDecorator
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/PitneyBowes/shopping_cart/style.css';

        return $list;
    }
    /**
     * Get the detailed description of the reason why the cart is disabled
     * 
     * @return string
     */
    protected function getDisabledReason()
    {
        $result = parent::getDisabledReason();

        $cart = $this->getCart();

        if ($cart->containsRestrictedProducts()) {
            $result = $this->getRestrictedErrorReason();
        }

        return $result;
    }

    /**
     * Defines the error message if cart contains restricted products
     *
     * @return string
     */
    protected function getRestrictedErrorReason()
    {
        return static::t('Cart contains the products which are restricted in your country. Try to change the shipping method');
    }
}
