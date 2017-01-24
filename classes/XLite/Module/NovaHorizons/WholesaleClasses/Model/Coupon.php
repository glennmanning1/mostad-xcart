<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 10/3/16
 * Time: 4:25 PM
 */

namespace XLite\Module\NovaHorizons\WholesaleClasses\Model;

use XLite\Base\IDecorator;
use XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier\VolumePricing;

/**
 * @LC_Dependencies("Mostad\Coupons", "CDev\Coupons","XC\FreeShipping")
 */
class Coupon extends \XLite\Module\CDev\Coupons\Model\Coupon implements \XLite\Base\IDecorator
{
    /**
     * Get amount
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return float
     */
    public function getAmount(\XLite\Model\Order $order)
    {
        $amount = parent::getAmount($order);

        $volPriceClassIds = [];

        foreach ($order->getItems() as $orderItem) {
            if ($orderItem->hasWholesalePriceClass() && $this->isValidForProduct($orderItem->getProduct())) {
                $volPriceClassIds[] = $orderItem->getProduct()->getProductClass()->getId();
            }
        }

        if (!empty($volPriceClassIds) && $order->getSurchargesByType(VolumePricing::MODIFIER_TYPE)) {
            foreach ($order->getSurchargesByType(VolumePricing::MODIFIER_TYPE) as $item) {
                $starter = \XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier\VolumePricing::MODIFIER_CODE;
                $classId = str_replace($starter . '_', '', $item->getCode());

                if (in_array($classId, $volPriceClassIds)) {
                    $amount += $this->isAbsolute()
                        ? min($item->getValue(), $this->getValue())
                        : ($item->getValue() * $this->getValue() / 100);
                }
            }
        }

        return $amount;
    }
}