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

namespace XLite\Module\Mostad\QuantityPricing\Model;


class ProductVariant extends \XLite\Module\XC\ProductVariants\Model\ProductVariant implements \XLite\Base\IDecorator
{

    protected $quantityPrices;

    protected $currentQuantity;

    protected $lowestQuantity;

    protected $lowestQuantityPrice;

    public function getQuantityPrices()
    {
        if (!$this->quantityPrices) {
            $cnd = new \XLite\Core\CommonCell();
            $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_ID}   = $this->getId();
            $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_TYPE} = 'XLite\Module\XC\ProductVariants\Model\ProductVariant';

            $this->quantityPrices = \XLite\Core\Database::getRepo('XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice')
                ->search($cnd, false);

            foreach ($this->quantityPrices as $quantityPrice) {
                $quantityPrice->setModel($this);
            }
        }

        return $this->quantityPrices;
    }

       public function getCurrentQuantityPrice()
    {
        foreach ($this->getQuantityPrices() as $quantityPrice) {
            if ($this->getCurrentQuantity() == $quantityPrice->getQuantity()) {
                return $quantityPrice->getPrice();
            }
        }
    }

    public function getPrice()
    {
        if ($this->hasQuantityPrices()) {
            if ($this->getCurrentQuantity() && $this->hasCurrentQuantity()) {
                return $this->getCurrentQuantityPrice() / $this->getCurrentQuantity();
            }

            return $this->getLowestQuantityPrice() / $this->getLowestQuantity();
        }

        return parent::getPrice();
    }

    public function hasQuantityPrices()
    {
        $result = $this->getQuantityPrices();

        return !empty($result);
    }

    public function setCurrentQuantity($quantity)
    {
        $this->currentQuantity = $quantity;

        return $this;
    }

    public function getCurrentQuantity()
    {
        return $this->currentQuantity;
    }

    public function getLowestQuantityPrice()
    {
        if (!$this->lowestQuantityPrice()) {
            $this->setLowestValues();
        }

        return $this->lowestQuantityPrice;
    }

    public function getLowestQuantity()
    {
        if (!$this->lowestQuantity) {
            $this->setLowestValues();
        }
        return $this->lowestQuantity;
    }

    protected function setLowestValues()
    {
        foreach ($this->getQuantityPrices() as $quantityPrice) {
            if ($this->lowestQuantity === null || $quantityPrice->getQuantity > $this->lowestQuantity) {
                $this->lowestQuantity = $quantityPrice->getQuantity();
                $this->lowestQuantityPrice = $quantityPrice->getPrice();
            }
        }
    }

    protected function hasCurrentQuantity()
    {
        foreach ($this->getQuantityPrices() as $quantityPrice) {
            if ($quantityPrice->getQuantity() == $this->getCurrentQuantity()) {
                return true;
            }
        }

        return false;
    }
    
    public function getClearPrice()
    {
        if (!$this->hasQuantityPrices()) {
            return parent::getClearPrice();
        }

        //return  \XLite\Module\XC\ProductVariants\Model\ProductVariantAbstract::getClearPrice();
        return !$this->getDefaultValue()
            ? $this->getProduct()->getPrice()
            : $this->getPrice();
    }

    public function getLowestPrice()
    {
        if ($this->hasQuantityPrices()) {
            return $this->getLowestQuantityPrice() / $this->getLowestQuantity();
        }

        return $this->getClearPrice();
    }

    public function getDisplayPrice()
    {
        if ($this->getDefaultPrice()) {
            return $this->getProduct()->getDisplayPrice();
        }

        if ($this->hasQuantityPrices()) {
            return $this->getLowestQuantityPrice();
        }

        return parent::getDisplayPrice();

    }

}