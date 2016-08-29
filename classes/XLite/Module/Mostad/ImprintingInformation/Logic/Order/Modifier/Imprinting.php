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

namespace XLite\Module\Mostad\ImprintingInformation\Logic\Order\Modifier;


class Imprinting extends \XLite\Logic\Order\Modifier\AModifier
{

    const MODIFIER_CODE = 'IMPRINTING';

    protected $code = self::MODIFIER_CODE;

    protected $brochureClass;

    protected $brochureCount = 0;

    protected $imprintingFee = 0;

    /**
     * Modifier type (see \XLite\Model\Base\Surcharge)
     *
     * @var string
     */
    protected $type = \XLite\Model\Base\Surcharge::TYPE_HANDLING;

    /**
     * Calculate and return added surcharge or array of surcharges
     *
     * @return \XLite\Model\Order\Surcharge|array
     */
    public function calculate()
    {
        $surcharge = null;

        $this->imprintingFee = 0;
        $this->brochureCount = 0;

        foreach ($this->getOrder()->getItems() as $item) {
            if ($item->needsImprinting()) {
                // if we're a brochure
                if ($item->getProduct()->getProductClass() == $this->getBrochureClass()) {
                    $this->brochureCount += $item->getAmount();
                }
                
            }
        }

        if ($this->brochureCount > 0) {
            $this->imprintingFee += 29;
            if ($this->brochureCount > 100) {
                $this->imprintingFee += 7 * floor(($this->brochureCount - 100) / 25);
            }
        }
        $imprinting = $this->getOrder()->getImprinting();
        if ($imprinting) {
            if ($imprinting->getStatus() == \XLite\Module\Mostad\ImprintingInformation\Model\Imprinting::STATUS_UPDATE) {
                $this->imprintingFee += 17;
            }
            if ($imprinting->getAddLogo()) {
                $this->imprintingFee += 40;
            }
            if ($imprinting->getOnlineAddLogo()) {
                $this->imprintingFee += 40;
            }
            if ($imprinting->getOnlineAddToSite()) {
                $this->imprintingFee += 20;
            }
        }


        if ($this->imprintingFee > 0) {
            $surcharge = $this->addOrderSurcharge($this->code, (float)$this->imprintingFee);
        }

        return $surcharge;
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
        $info = new \XLite\DataSet\Collection\OrderModifier();


        $info->name = \XLite\Core\Translation::lbl('Imprinting fee');


        return $info;

    }

    protected function getBrochureClass()
    {
        if (!$this->brochureClass) {
            $this->brochureClass = \XLite\Core\Database::getRepo('XLite\Model\ProductClass')->findOneByName("Brochures");
        }

        return $this->brochureClass;
    }
}