<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 9/20/16
 * Time: 3:26 PM
 */

namespace XLite\Module\Mostad\TaxCorrection\Logic\Order\Modifier;

/**
 * @LC_Dependencies("CDev\SalesTax")
 */
class Tax extends \XLite\Module\CDev\SalesTax\Logic\Order\Modifier\Tax implements \XLite\Base\IDecorator
{
    /**
     * Get order-based address
     *
     * @return \XLite\Model\Address
     */
    protected function getOrderAddress()
    {
        $profile = $this->getOrder()->getProfile();

        if (!$profile) {
            return null;
        }

        if (
            'shipping' === \XLite\Core\Config::getInstance()->CDev->SalesTax->addressType
            && $profile->getShippingAddress()
        ) {
            return $profile->getShippingAddress();
        }

        return $profile->getBillingAddress();
    }
}