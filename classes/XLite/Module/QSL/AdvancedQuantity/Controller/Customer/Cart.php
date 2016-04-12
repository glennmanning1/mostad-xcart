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

namespace XLite\Module\QSL\AdvancedQuantity\Controller\Customer;

/**
 * Cart controller
 */
class Cart extends \XLite\Controller\Customer\Cart implements \XLite\Base\IDecorator
{
    /**
     * Quantity unit for current amount
     *
     * @var \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit
     */
    protected $current_unit;

    /**
     * Current selected amount
     *
     * @var float
     */
    protected $current_selected_amount = 1;

    /**
     * @inheritdoc
     */
    protected function getCurrentAmount()
    {
        $amount = null;

        $this->current_unit = null;
        $this->current_selected_amount = null;

        $product = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($this->getCurrentProductId());
        if (!$product) {
            $amount = $product->formatQuantity(\XLite\Core\Request::getInstance()->amount) ?: 1;

        } elseif (count($product->geQuantitySets()) > 0 || count($product->getQuantityUnits()) > 0) {
            list($this->current_selected_amount, $this->current_unit, $amount) = $this->decodeAdvancedQuantity(
                $product,
                \XLite\Core\Request::getInstance()->amount,
                \XLite\Core\Request::getInstance()->unitid
            );

        } else {
            $amount = $product->formatQuantity(\XLite\Core\Request::getInstance()->amount) ?: 1;
        }

        if (!isset($this->current_selected_amount)) {
            $this->current_selected_amount = $amount;
        }

        return $amount;
    }

    /**
     * @inheritdoc
     */
    protected function prepareOrderItem(\XLite\Model\Product $product = null, $amount = null)
    {
        $item = parent::prepareOrderItem($product, $amount);
        if ($item) {
            $item->setSelectedAmount($this->current_selected_amount);
            $item->setQuantityUnit($this->current_unit);
        }

        return $item;
    }

    /**
     * @inheritdoc
     */
    protected function doActionUpdate()
    {
        $cartId = \XLite\Core\Request::getInstance()->cart_id;
        $amount = \XLite\Core\Request::getInstance()->amount;
        $unit = \XLite\Core\Request::getInstance()->unit ?: \XLite\Core\Request::getInstance()->unitid;

        if (!is_array($amount)) {
            $amount = $cartId
                ? array($cartId => $amount)
                : array();

        } elseif (isset($cartId)) {
            $amount = isset($amount[$cartId])
                ? array($cartId => $amount[$cartId])
                : array();
        }

        foreach ($amount as $id => $quantity) {
            $item = $this->getCart()->getItemByItemId($id);
            if ($item) {
                if (is_array($unit)) {
                    $currentUnit = isset($unit[$id]) ? $unit[$id] : null;

                } else {
                    $currentUnit = $unit ?: null;
                }

                list($current_selected_amount, $current_unit, $amount[$id]) = $this->decodeAdvancedQuantity(
                    $item->getProduct(),
                    $quantity,
                    $currentUnit,
                    true
                );

                $item->setSelectedAmount($current_selected_amount);
                $item->setQuantityUnit($current_unit);
            }
        }

        \XLite\Core\Request::getInstance()->amount = $amount;

        parent::doActionUpdate();
    }

    /**
     * Decode quantity and quantity unit from input data
     *
     * @param \XLite\Model\Product $product  Product
     * @param mixed                $quantity Quantity
     * @param integer              $unitid   Quantity unit ID
     * @param boolean              $cartPage Call from cart page OPTIONAL
     *
     * @return array
     */
    protected function decodeAdvancedQuantity(\XLite\Model\Product $product, $quantity, $unitid, $cartPage = false)
    {
        $current_unit = null;
        $current_selected_amount = $quantity;

        if ($product->isQuantitySetsHasUnits()) {

            // Quantity sets has specified units
            if ($cartPage) {
                $qty = $quantity;

            } else {
                list($qty, $unitid) = explode('|', $quantity, 2);
            }
            $unit = null;
            foreach ($product->getQuantityUnits() as $u) {
                if ($u->getId() == $unitid) {
                    $unit = $u;
                    break;
                }
            }

            if (!$unit) {
                $unit = $product->getQuantityUnits()->first();
            }

            if ($cartPage) {
                $current_unit = $unit;
                $amount = $unit->getMultiplier() * $qty;
                $current_selected_amount = $qty;

            } else {
                foreach ($product->getQuantitySets() as $set) {
                    if (
                        $set->getQuantity() == $qty
                        && (!$set->getQuantityUnit() || $set->getQuantityUnit()->getId() == $unit->getId())
                    ) {
                        $amount = $set->getActualQuantity($unit);
                        $current_unit = $set->getQuantityUnit() ?: $unit;
                        $current_selected_amount = $qty;
                        break;
                    }
                }

                if (!isset($amount)) {
                    $set = $product->getQuantitySets()->first();
                    $amount = $set->getActualQuantity(
                        $set->getQuantityUnit() ?: $unit
                    );
                    $current_unit = $set->getQuantityUnit() ?: $unit;
                    $current_selected_amount = $set->getQuantity();
                }
            }

        } elseif (count($product->getQuantitySets()) > 0) {

            // Quantity set has not units
            $unit = null;
            foreach ($product->getQuantityUnits() as $u) {
                if ($u->getId() == $unitid) {
                    $unit = $u;
                    break;
                }
            }

            if (!$unit) {
                $unit = $product->getQuantityUnits()->first();
            }

            if ($cartPage) {
                $amount = $unit
                    ? ($unit->getMultiplier() * $quantity)
                    : $quantity;
                $current_unit = $unit;
                $current_selected_amount = $quantity;


            } else {
                $current_set = null;
                foreach ($product->getQuantitySets() as $set) {
                    if ($set->getQuantity() == $quantity) {
                        $current_set = $set;
                        break;
                    }
                }

                if (!isset($current_set)) {
                    $current_set = $product->getQuantitySets()->first();
                }

                $amount = $current_set->getActualQuantity(
                    $current_set->getQuantityUnit() ?: $unit
                );
                $current_unit = $current_set->getQuantityUnit() ?: $unit;
                $current_selected_amount = $current_set->getQuantity();
            }

        } elseif (count($product->getQuantityUnits()) > 0) {

            // Quantity set  list is empty but product has quantity units
            $unit = null;
            foreach ($product->getQuantityUnits() as $u) {
                if ($u->getId() == $unitid) {
                    $unit = $u;
                    break;
                }
            }

            if (!$unit) {
                $unit = $product->getQuantityUnits()->first();
            }

            $current_unit = $unit;
            $current_selected_amount = $product->formatQuantity($quantity);
        }

        return array(
            $current_selected_amount,
            $current_unit,
            ($current_unit ? $current_unit->getMultiplier() * $current_selected_amount : $current_selected_amount),
        );
    }
}
