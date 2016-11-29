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

namespace XLite\Module\NovaHorizons\WholesaleClasses\Logic\Order\Modifier;


class VolumePricing extends \XLite\Logic\Order\Modifier\AModifier
{

    const MODIFIER_CODE = 'VOLUME_PRICE_CLASS';

    const MODIFIER_TYPE = 'vpc';

    protected $type = self::MODIFIER_TYPE;

    protected $code = self::MODIFIER_CODE;

    protected $volumeClassData = array();

    protected $volumePricingSets = array();


    /**
     * Calculate and return added surcharge or array of surcharges
     *
     * @return \XLite\Model\Order\Surcharge|array
     */
    public function calculate()
    {

        $volumePricingData = $this->getVolumePricingData();

        return $this->addSurcharges($volumePricingData);

    }

    /**
     * Get surcharge information
     *
     * @param \XLite\Model\Base\Surcharge $surcharge Surcharge
     *
     * @return \XLite\DataSet\Transport\Order\Surcharge
     */
    public function getSurchargeInfo(\XLite\Model\Base\Surcharge $surcharge)
    {
        $info = new \XLite\DataSet\Transport\Order\Surcharge;

        $info->name = 'Volume Pricing Class';

        return $info;
    }

    protected function getVolumePricingData()
    {
        if (!empty($this->volumeClassData)) {
            return $this->volumeClassData;
        }


        /** @var \XLite\Model\OrderItem $item */
        foreach ($this->getOrder()->getItems() as $item) {
            $productClass = $item->getProduct()->getProductClass();

            if (empty($productClass)) {
                continue;
            }

            $productClassId = $productClass->getId();

            if (!isset($this->volumeClassData[$productClassId])) {
                $this->volumeClassData[$productClassId] = array(
                    'quantity' => 0,
                );
            }

            $this->volumeClassData[$productClassId]['quantity'] += $item->getAmount();
        }

        return $this->volumeClassData;
    }

    protected function addSurcharges($volumePricingData)
    {
        $surcharges = array();

        $pricingSets = $this->getPricingSets();

        foreach ($volumePricingData as $classId => $data) {

            if (!isset($pricingSets[$classId])) {
                continue;
            }

            $price =  \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice')
                ->getPriceBySetAndQuantity($pricingSets[$classId], $data['quantity']);

            $surcharge = $this->addOrderSurcharge($this->code . '_' . $classId, $price);

            $surcharge->setName($pricingSets[$classId]->getName() . " volume price");

            $surcharges[] = $surcharge;
        }

        return $surcharges;
    }

    protected function getPricingSets()
    {
        if (!empty($this->volumePricingSets)) {
            return $this->volumePricingSets;
        }

        $sets = \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet')
            ->findAll();

        /** @var \XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet $set */
        foreach ($sets as $set) {
            $this->volumePricingSets[$set->getClass()->getId()] = $set;
        }

        return $this->volumePricingSets;
    }
}