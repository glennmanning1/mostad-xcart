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

/**
 * @LC_Dependencies ("CDev\Wholesale")
 */
class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $quantityPrices;

    protected $currentQuantity;

    protected $lowestQuantity;

    protected $lowestQuantityPrice;

    /**
     * @var boolean
     *
     * @Column(name="quantity_price_enabled", type="boolean")
     */
    protected $quantityPriceEnabled = false;

    /**
     * @var string
     */
    protected $quantityPriceDescriptor;

    public function getQuantityPrices()
    {
        if (!$this->quantityPrices) {
            $cnd = new \XLite\Core\CommonCell();
            $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_ID}   = $this->getId();
            $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_TYPE} = 'XLite\Model\Product';

            $this->quantityPrices = \XLite\Core\Database::getRepo('XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice')
                ->search($cnd, false);

            foreach ($this->quantityPrices as $quantityPrice) {
                $quantityPrice->setModel($this);
            }
        }
        
        return $this->quantityPrices;
    }

    public function getQuantityPriceDescriptor()
    {
        return $this->quantityPriceDescriptor ?: 'Select Quantity';
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
        if (!$this->getQuantityPriceEnabled()) {
            return false;
        }
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
        if (!$this->lowestQuantityPrice) {
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

    public function isWholesalePricesEnabled()
    {
        if ($this->hasQuantityPrices()) {
            return false;
        }

        return parent::isWholesalePricesEnabled();
    }


    /**
     * Set quantityPriceEnabled
     *
     * @param boolean $quantityPriceEnabled
     * @return Product
     */
    public function setQuantityPriceEnabled($quantityPriceEnabled)
    {
        $this->quantityPriceEnabled = $quantityPriceEnabled;
        return $this;
    }

    /**
     * Get quantityPriceEnabled
     *
     * @return boolean 
     */
    public function getQuantityPriceEnabled()
    {
        return $this->quantityPriceEnabled;
    }

    public function getLowestPrice()
    {
        if ($this->hasQuantityPrices()) {
            return $this->getLowestQuantityPrice() / $this->getLowestQuantity();
        }

        return parent::getPrice();
    }
}