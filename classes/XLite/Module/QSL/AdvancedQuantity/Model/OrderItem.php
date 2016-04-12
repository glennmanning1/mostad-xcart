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
 */
class OrderItem extends \XLite\Model\OrderItem implements \XLite\Base\IDecorator
{
    /**
     * Item quantity
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $amount = 1;

    /**
     * Item selected quantity
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=4, nullable=true)
     */
    protected $selected_amount;

    /**
     * Quantity unit
     *
     * @var \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit
     *
     * @OneToOne (targetEntity="XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit", cascade={"merge","detach"})
     * @JoinColumn (name="quantity_unit_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $quantity_unit;

    protected $forbid_calculate_display_price = false;

    /**
     * Get amount for displying
     *
     * @return string
     */
    public function getDisplayAmount()
    {
        return $this->getQuantityUnit()
            ? $this->getQuantityUnit()->formatAmount($this->getSelectedAmount())
            : $this->getAmount();
    }

    /**
     * Get visible amount
     *
     * @return float
     */
    public function getPublicAmount()
    {
        return $this->getQuantityUnit()
            ? $this->getSelectedAmount()
            : $this->getAmount();
    }

    /**
     * Get visible price
     *
     * @return float
     */
    public function getDisplayPrice()
    {
        return ($this->getQuantityUnit() && !$this->forbid_calculate_display_price)
            ? ($this->getQuantityUnit()->getMultiplier() * parent::getDisplayPrice())
            : parent::getDisplayPrice();
    }

    /**
     * Get visible item net price
     *
     * @return float
     */
    public function getDisplayItemNetPrice()
    {
        return $this->getQuantityUnit()
            ? ($this->getQuantityUnit()->getMultiplier() * $this->getItemNetPrice())
            : $this->getItemNetPrice();
    }

    /**
     * Format quantity
     *
     * @param mixed $quantity Quantity OPTIONAL
     *
     * @return float
     */
    public function formatQuantity($quantity = null)
    {
        if (!isset($quantity)) {
            $quantity = $this->getAmount();
        }

        return $this->getProduct()->formatQuantity($quantity);
    }

    /**
     * Increase / decrease product inventory amount
     *
     * @param integer $delta Amount delta
     *
     * @return void
     */
    public function changeSelectedAmount($delta)
    {
        if ($this->getQuantityUnit()) {
            $delta = $delta * $this->getQuantityUnit()->getMultiplier();
        }
        $this->changeAmount($delta);
    }

    /**
     * @inheritdoc
     */
    public function hasWrongAmount()
    {
        $result = parent::hasWrongAmount();

        if (!$result && $this->getQuantityUnit()) {
            $amount = $this->getAmount() / $this->getQuantityUnit()->getMultiplier();
            $result = $amount != $this->getProduct()->formatQuantity($amount);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function isPriceControlledServer()
    {
        $result = parent::isPriceControlledServer();

        if (!$result && $this->getProduct()) {
            $result = count($this->getProduct()->getQuantityUnits()) > 0;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getKey()
    {
        $key = parent::getKey();
        if ($this->getQuantityUnit()) {
            $key .= ':qu' . $this->getQuantityUnit()->getId();
        }

        return $key;
    }

    /**
     * @inheritdoc
     */
    public function cloneEntity()
    {
        $newItem = parent::cloneEntity();

        if ($this->getQuantityUnit()) {
            $newItem->setQuantityUnit($this->getQuantityUnit());
        }

        return $newItem;
    }

}
