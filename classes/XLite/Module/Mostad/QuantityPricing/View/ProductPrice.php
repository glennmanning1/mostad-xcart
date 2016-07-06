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

namespace XLite\Module\Mostad\QuantityPricing\View;

/**
 * @LC_Dependencies ("CDev\Wholesale", "NovaHorizons\WholesaleClasses", "XC\ProductVariants")
 */
class ProductPrice extends \XLite\Module\CDev\Wholesale\View\ProductPrice implements \XLite\Base\IDecorator
{

    protected $quantityPricing;

    protected function defineWholesalePrices()
    {
        if ($this->getQuantityPricing()) {
            return $this->quantityPricing;
        }

        return parent::defineWholesalePrices();
    }

    protected function getQuantityPricing()
    {
        if (!empty($this->quantityPricing)) {
            return $this->quantityPricing;
        }

        if ($this->getProduct()->getQuantityPriceEnabled()) {

            if ($this->getProduct()->hasQuantityPrices()) {
                $this->quantityPricing = $this->getProduct()->getQuantityPrices();
            }

            if ($this->getProductVariant()->hasQuantityPrices()) {
                $this->quantityPricing = $this->getProductVariant()->getQuantityPrices();
            }
        }

         if ($this->getProduct()->getProductClass()->hasWholesaleQuantityPricing()) {
            $this->quantityPricing = $this->getProduct()->getProductClass()->getWholesaleQuantityPrices();
        }

        return $this->quantityPricing;
    }

    protected function hasQuantityPricing()
    {
        $result = $this->getQuantityPricing();
        return !empty($result);
    }

    /**
     * Return wholesale prices for the current product
     *
     * @return \Doctrine\ORM\PersistentCollection
     */
    protected function getWholesalePrices()
    {
        if (!$this->hasQuantityPricing()) {
            return parent::getWholesalePrices();
        }

        return $this->defineWholesalePrices();
    }

}