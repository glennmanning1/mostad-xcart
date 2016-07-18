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
 * @LC_Dependencies ("CDev\Wholesale", "XC\ProductVariants")
 */
class OrderItem extends \XLite\Model\OrderItem implements \XLite\Base\IDecorator
{
    protected $quantityPrice;
    /**
     * Get visible price
     *
     * @return float
     */
    public function getDisplayPrice()
    {
        if ($this->getQuantityPrice()) {
            return number_format(
                $this->getQuantityPrice() / $this->getAmount(),
                2
            );
        }

        return parent::getDisplayPrice();
    }


    public function getQuantityPrice()
    {
        $product = $this->getProduct();

        $variant = $this->getVariant();

        $quantityPrices = array();

        if ($variant && $variant->getQuantityPrices()) {
            $quantityPrices = $variant->getQuantityPrices();
        } else if ($product->getQuantityPrices()) {
            $quantityPrices = $product->getQuantityPrices();
        }

        foreach ($quantityPrices as $quantityPrice) {
            if ($this->getAmount() == $quantityPrice->getQuantity()) {
                $this->quantityPrice = $quantityPrice->getPrice();
                break;
            }
        }

        return $this->quantityPrice;


    }

    /**
     * @return float
     */
    public function getClearPrice()
    {
        $this->setQuantityPriceValues();

        return parent::getClearPrice();
    }


    /**
     * 
     */
    protected function setQuantityPriceValues()
    {
        $this->getProduct()->setCurrentQuantity($this->getAmount());

        if ($this->getVariant()) {
            $this->getVariant()->setCurrentQuantity($this->getAmount());
        }
    }

//    public function setPrice($price)
//    {
//        if ($this->getQuantityPrice()) {
//            $this->price = $this->getQuantityPrice();
//        }
//        $this->price = $price;
//
//        if (!isset($this->itemNetPrice)) {
//            $this->setItemNetPrice($this->price);
//        }
//
//        return $this;
//    }
}