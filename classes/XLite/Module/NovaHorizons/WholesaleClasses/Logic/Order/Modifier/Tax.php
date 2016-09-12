<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 9/9/16
 * Time: 10:51 AM
 */

namespace XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier;


use XLite\Module\CDev\SalesTax\Model\Tax\Rate;
use XLite\View\Surcharge;

class Tax extends \XLite\Module\CDev\SalesTax\Logic\Order\Modifier\Tax implements \XLite\Base\IDecorator
{

    public function calculate()
    {
        $result = array();
        $surchargeArray = parent::calculate();

        $volumeSurchargeArray = $this->getOrder()->getSurchargesByType(\XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier\VolumePricing::MODIFIER_TYPE);

        $volumeSurchargeValue = 0;

        foreach ($volumeSurchargeArray as $volumeSurcharge) {
            $volumeSurchargeValue += $volumeSurcharge->getValue();
        }

        if (empty($volumeSurchargeArray) || empty($volumeSurchargeValue) || empty($surchargeArray)) {
            return $surchargeArray;
        }

        $zones = $this->getZonesList();
        $membership = $this->getMembership();

        /** @var \XLite\Module\CDev\SalesTax\Model\Tax $tax */
        foreach ($this->getTaxes() as $tax) {
            $cost = 0;
            $rates = $tax->getFilteredRates($zones, $membership);
            if ($rates) {
                /** @var Rate $rate */
                foreach ($rates as $rate) {
                    $cost += $volumeSurchargeValue * ($rate->getValue() / 100);
                }
            }
            if ($cost) {
                foreach ($surchargeArray as $surcharge) {
                    $this->order->removeSurcharge($surcharge);

                    $result[] = $this->addOrderSurcharge(
                        $surcharge->getCode(),
                        $surcharge->getValue() + $cost,
                        $surcharge->getInclude(),
                        $surcharge->getAvailable()
                    );
                }
            }
        }


        return $result;

    }

}