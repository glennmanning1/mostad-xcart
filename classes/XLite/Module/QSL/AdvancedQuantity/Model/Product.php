<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\QSL\AdvancedQuantity\Model;

/**
 * Product
 */
class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{

    /**
     * Fraction part length
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $fraction_length = 0;

    /**
     * Quantity sets
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantitySet", mappedBy="product", cascade={"all"})
     * @OrderBy   ({"position" = "ASC"})
     */
    protected $quantity_sets;

    /**
     * Quantity units
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit", mappedBy="product", cascade={"all"})
     * @OrderBy   ({"position" = "ASC"})
     */
    protected $quantity_units;

    /**
     * Current order's item quantity
     *
     * @var float
     */
    protected $current_item_quantity;

    /**
     * Current order's item quantity unit
     *
     * @var \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit
     */
    protected $current_item_quantity_unit;

    /**
     * @inheritdoc
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);

        $this->quantity_sets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->quantity_units = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Check - quantity sets has units or not
     *
     * @return boolean
     */
    public function isQuantitySetsHasUnits()
    {
        $result = false;

        foreach ($this->getQuantitySets() as $set) {
            if ($set->getQuantityUnit()) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Format quantity
     *
     * @param mixed $quantity Quantity
     *
     * @return float
     */
    public function formatQuantity($quantity)
    {
        return round(doubleval($quantity), $this->getFractionLength());
    }

    /**
     * Get absolute quantity mininum
     *
     * @return float
     */
    public function getAbsoluteMinimumQuantity()
    {
        return $this->getFractionLength() > 0
            ? (1 / pow(10, $this->getFractionLength()))
            : 1;
    }

    /**
     * @inheritdoc
     */
    public function getMinPurchaseLimit()
    {
        return $this->getAbsoluteMinimumQuantity();
    }

    /**
     * @inheritdoc
     */
    public function cloneEntity()
    {
        $newProduct = parent::cloneEntity();
        $this->cloneQuantityUnits($newProduct);
        $this->cloneQuantitySets($newProduct);

        return $newProduct;
    }

    /**
     * Clone product's quantity units
     *
     * @param \XLite\Model\Product $newProduct New product
     */
    protected function cloneQuantityUnits(\XLite\Model\Product $newProduct)
    {
        foreach ($this->getQuantityUnits() as $unit) {
            $newUnit = $unit->cloneEntity();
            $newUnit->setProduct($newProduct);
            $newProduct->addQuantityUnits($newUnit);
            $newUnit->update();
        }
    }

    /**
     * Clone product's quantity sets
     *
     * @param \XLite\Model\Product $newProduct New product
     */
    protected function cloneQuantitySets(\XLite\Model\Product $newProduct)
    {
        foreach ($this->getQuantitySets() as $set) {
            $newSet = $set->cloneEntity();
            $newSet->setProduct($newProduct);
            $newProduct->addQuantityUnits($newSet);
            $newSet->update();
        }
    }

    // {{{ Order calculation

    /**
     * Setup current product's quantity unit for orde calculation purpose
     *
     * @param float                                                         $quantity Quantity
     * @param \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit $unit     Unit OPTIONAL
     */
    public function setupQuantityUnits($quantity, \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit $unit = null)
    {
        $this->current_item_quantity = $quantity;
        $this->current_item_quantity_unit = $unit;
    }

    /**
     * @inheritdoc
     */
    public function getClearPrice()
    {
        return \XLite\Module\QSL\AdvancedQuantity\Main::isWholesaleModuleEnabled()
            ? parent::getClearPrice()
            : $this->calculateQuantityUnitPrice();
    }

    /**
     * Get base price for quantity unit price calculation
     *
     * @return float
     */
    public  function getQuantityUnitBasePrice()
    {
        return parent::getClearPrice();
    }

    /**
     * Calculate quantity unit based price
     *
     * @param float $base Base price OPTIONAL
     *
     * @return float
     */
    public function calculateQuantityUnitPrice($base = null)
    {
        return $this->current_item_quantity_unit
            ? $this->current_item_quantity_unit->calculatePrice($this, $base)
            : $this->getQuantityUnitBasePrice();
    }

    // }}}

} 