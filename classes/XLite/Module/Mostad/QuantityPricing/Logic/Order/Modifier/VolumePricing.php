<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Nova Horizons
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  X-Cart 5
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */

namespace XLite\Module\Mostad\QuantityPricing\Logic\Order\Modifier;


class VolumePricing extends \XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier\VolumePricing  implements \XLite\Base\IDecorator
{
    
    protected function addSurcharges($volumePricingData)
    {
        $surcharges = array();

        $pricingSets = $this->getPricingSets();

        foreach ($volumePricingData as $classId => $data) {

            if (!isset($pricingSets[$classId])) {
                continue;
            }

            if($pricingSets[$classId]->hasQuantityPrices()) {
                $price =  \XLite\Core\Database::getRepo('XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice')
                    ->getPriceBySetAndQuantity($pricingSets[$classId], $data['quantity']);
            }

            if (!$pricingSets[$classId]->hasQuantityPrices() || empty($price)) {
                $price =  \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice')
                    ->getPriceBySetAndQuantity($pricingSets[$classId], $data['quantity']);
            }


            $surcharge = $this->addOrderSurcharge($this->code . '_' . $classId, $price);

            $surcharge->setName($pricingSets[$classId]->getName() . " volume price");

            $surcharges[] = $surcharge;
        }

        return $surcharges;
    }
    

}