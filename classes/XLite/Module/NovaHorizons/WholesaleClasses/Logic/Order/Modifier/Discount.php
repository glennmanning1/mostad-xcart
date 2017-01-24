<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 10/3/16
 * Time: 5:19 PM
 */

namespace XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier;

/**
 * @LC_Dependencies("Mostad\Coupons", "CDev\Coupons","XC\FreeShipping")
 */
class Discount extends \XLite\Module\CDev\Coupons\Logic\Order\Modifier\Discount implements \XLite\Base\IDecorator
{
    public function calculate()
    {
        $surcharge = null;

        $total = 0;

        foreach ($this->getUsedCoupons() as $used) {
            if ($used->getCoupon()) {
                $used->setValue($used->getCoupon()->getAmount($this->order));
            }
            $total += $used->getValue();
        }

        if ($this->isValidTotal($total)) {
            if ($this->order->getSubtotal() != 0) {
                $total = min($total, $this->order->getSubtotal());
            }
            $surcharge = $this->addOrderSurcharge($this->code, $total * -1, false);

            // Distribute discount value among the ordered products
            $this->distributeDiscount($total);
        }

        return $surcharge;
    }

}