<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 9/2/16
 * Time: 8:04 AM
 */

namespace XLite\Module\Mostad\Coupons\View\Checkout;


class PaymentMethodsList extends \XLite\View\Checkout\PaymentMethodsList implements \XLite\Base\IDecorator
{
    /**
     * Check - payment method is selected or not
     *
     * @param \XLite\Model\Payment\Method $method Payment methods
     *
     * @return boolean
     */
    protected function isPaymentSelected(\XLite\Model\Payment\Method $method)
    {
        if (stripos($method->getName(), 'deferred') !== false) {
            return true;
        }

        return parent::isPaymentSelected($method);
    }
}