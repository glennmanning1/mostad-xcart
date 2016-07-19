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

namespace XLite\Module\Mostad\Shipping\Logic\Order\Modifier;


class Shipping extends \XLite\Logic\Order\Modifier\Shipping
{
    protected $productClassData = [];

    protected $additionalShipping;

    protected $chocolatesClass;

    protected $newsletterClass;

    protected $tplClass;

    protected $itemCount;

    protected $excludeBaseShipping = false;

    protected $hasStandardItems = false;

    /**
     * Calculate and return added surcharge or array of surcharges
     *
     * @return \XLite\Model\Order\Surcharge|array
     */
    public function calculate()
    {
        $this->additionalShipping = 0;

        $this->productClassData = [];

        $this->itemCount = 0;

        /** @var \XLite\Model\OrderItem $item */
        foreach ($this->getOrder()->getItems() as $item) {
            $productClass = $item->getProduct()->getProductClass();

            $this->itemCount += $item->getAmount();

            // If we don't have a product class, bounce.
            // If we're not shippable, bounce.
            // If we are shippable, but have free shipping set up, bounce.
            if (
                !$item->getProduct()->getShippable()
                || ($item->getProduct()->getShippable() && $item->getProduct()->getFreeShipping())
            ) {
                $this->excludeBaseShipping = true;
                continue;
            }

            if (empty($productClass)) {
                $this->hasStandardItems = true;
                continue;
            }

            $productClassId = $productClass->getId();

            if (!isset($this->productClassData[ $productClassId ])) {
                $this->productClassData[ $productClassId ]         = [
                    'quantity' => 0,
                ];
                $this->productClassData[ $productClassId ]['skus'] = [];

            }

            $this->productClassData[ $productClassId ]['quantity'] += $item->getAmount();

            $attrValues = $item->getProduct()->getAttrValues();

            $this->productClassData[ $productClassId ]['skus'][ $item->getProduct()
                ->getSku() ] = $item->getAttributeValuesAsString();

        }

        $this->checkChocolates();

        $this->checkNewsletters();

        $this->checkTpl();

        $this->checkDefaultShipping();

        $sucharge = $this->addOrderSurcharge($this->code, (float) $this->additionalShipping, false, true);

        return $sucharge;
    }


    /**
     * Check to see if we have chocolates, add appropriate shipping.
     *
     */
    protected function checkChocolates()
    {
        $chocolateProductClass = \XLite\Core\Config::getInstance()->Mostad->Shipping->chocolates_class;

        if (empty($chocolateProductClass) || !isset($this->productClassData[ $chocolateProductClass ])) {
            return;
        }

        $quantity = $this->productClassData[ $chocolateProductClass ]['quantity'];

        if ($quantity == $this->itemCount) {
            $this->excludeBaseShipping = true;
        }

        if ($quantity <= 3) {
            $this->additionalShipping += 19.00;
        } else {
            $this->additionalShipping += 32.00;
        }

        unset($this->productClassData[ $chocolateProductClass ]);
    }

    /**
     * Check to see if we have newsletters, add appropriate shipping.
     */
    protected function checkNewsletters()
    {
        $newsletterProductClass = \XLite\Core\Config::getInstance()->Mostad->Shipping->newsletter_class;

        if (empty($newsletterProductClass) || !isset($this->productClassData[ $newsletterProductClass ])) {
            return;
        }

        $quantity = $this->productClassData[ $newsletterProductClass ]['quantity'];

        if ($quantity == $this->itemCount) {
            $this->excludeBaseShipping = true;
        }

        if ($quantity > 0) {
            $this->additionalShipping += (60 * count($this->productClassData[ $newsletterProductClass ]['skus']));
        }

        unset($this->productClassData[ $newsletterProductClass ]);
    }

    /**
     * Check for tax planning letters, add appropriate shipping.
     *
     */
    protected function checkTpl()
    {
        $tplProductClass = \XLite\Core\Config::getInstance()->Mostad->Shipping->planning_letters_class;

        if (empty($tplProductClass) || !isset($this->productClassData[ $tplProductClass ])) {
            return;
        }

        $quantity = $this->productClassData[ $tplProductClass ]['quantity'];

        if ($quantity == $this->itemCount) {
            $this->excludeBaseShipping = true;
        }

        if ($quantity > 0) {
            $issueCount = 0;
            foreach ($this->productClassData[ $tplProductClass ]['skus'] as $sku => $attrString) {
                preg_match('`.*(\d+)\sIssues.*`', $attrString, $matches);

                if (isset($matches[1])) {
                    $issueCount += (int) $matches[1];
                }
            }

            $this->additionalShipping += (15 * $issueCount);
        }

        unset($this->productClassData[ $tplProductClass ]);
    }

    /**
     * Check if we need to include or exclude default shipping.
     */
    protected function checkDefaultShipping()
    {
        if (!empty($this->productClassData)) {
            $this->hasStandardItems = true;
        }

        if ($this->additionalShipping > 15) {
            if ($this->excludeBaseShipping || !$this->hasStandardItems) {
                $this->additionalShipping -= 15;
            }
        }
    }
}