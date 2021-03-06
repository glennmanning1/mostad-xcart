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
 * @copyright Copyright (c) 2011-2016 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\CDev\XPaymentsConnector\Model;

/**
 * XPayments payment processor
 *
 */
class Shipping extends \XLite\Model\Shipping implements \XLite\Base\IDecorator
{

    /**
     * Set $ignoreLongCalculations variable
     *
     * @param boolean $value Mode
     *
     * @return void
     */
    public static function setIgnoreLongCalculationsMode($value)
    {
        $forIframe = \XLite\Module\CDev\XPaymentsConnector\Core\Iframe::getInstance()->useIframe()
            && \XLite\Core\Request::getInstance()->xpc_iframe;

        $forCallback = 'check_cart' == \XLite\Core\Request::getInstance()->action;

        if (
            true == $value
            && (
                $forIframe
                || $forCallback
            )
        ) {
            // Workaround for checkCheckoutAction() method of controller.
            // Otherwise shippings might be not calculated
            $value = false;
        }

        parent::setIgnoreLongCalculationsMode($value);
    }
}
