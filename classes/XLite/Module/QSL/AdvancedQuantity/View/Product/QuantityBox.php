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

namespace XLite\Module\QSL\AdvancedQuantity\View\Product;

/**
 * QuantityBox
 */
class QuantityBox extends \XLite\View\Product\QuantityBox implements \XLite\Base\IDecorator
{

    /**
     * Cache selct box options
     *
     * @var string[]
     */
    protected $options;

    /**
     * @inheritdoc
     */
    protected function getBoxValue()
    {
        if (
            $this->getParam(static::PARAM_ORDER_ITEM)
            && $this->getParam(static::PARAM_ORDER_ITEM)->getQuantityUnit()
        ) {
            $result = $this->getParam(static::PARAM_ORDER_ITEM)->getSelectedAmount();

        } elseif (
            !$this->isSelectBox()
            && count($this->getProduct()->getQuantityUnits()) > 0
            && \XLite\Core\Request::getInstance()->unit
            && $this->getQuantityUnit()
        ) {
            $result = $this->getProduct()->formatQuantity(parent::getBoxValue() / $this->getQuantityUnit()->getMultiplier());

        } else {
            $result = parent::getBoxValue();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultTemplate()
    {
        return 'modules/QSL/AdvancedQuantity/quantity_box.tpl';
    }

    /**
     * @inheritdoc
     */
    protected function getClass()
    {
        return $this->processClass(parent::getClass());
    }

    /**
     * Process class
     *
     * @param string $class Class
     *
     * @return string
     */
    protected function processClass($class)
    {
        if ($this->isSelectBox()) {
            $class = preg_replace('/validate\[.+\]/Ss', '', $class);
            $class = preg_replace('/wheel-ctrl/Ss', '', $class);

        } elseif ($this->getProduct()->getFractionLength() > 0) {
            $class = preg_replace('/wheel-ctrl/Ss', '', $class);
            $class = preg_replace('/custom\[integer\]/Ss', 'custom[number]', $class);

        } elseif (count($this->getProduct()->getQuantityUnits()) > 0 && $this->getOrderItem()) {
            $class = preg_replace('/wheel-ctrl/Ss', '', $class);
        }

        if ($this->getProduct()->getFractionLength() > 0) {
            $class .= ' fraction-length-' . $this->getProduct()->getFractionLength();
        }

        if ($this->getOrderItem()) {
            $class .= ' order-item-quantity';
        }

        return trim(preg_replace('/\s{2,}/Ss', ' ', $class));
    }

    /**
     * Check - display quantity control as select box or not
     *
     * @return boolean
     */
    protected function isSelectBox()
    {
        return count($this->getProduct()->getQuantitySets()) > 0 && !$this->getOrderItem();
    }

    /**
     * Get quantities as select box's  options
     *
     * @return string[]
     */
    protected function getQuantitiesAsOptions()
    {
        if (!isset($this->options)) {
            $this->options = array();
            $hasUnits = $this->getProduct()->isQuantitySetsHasUnits();

            foreach ($this->getProduct()->getQuantitySets() as $set) {
                if ($hasUnits) {
                    if ($set->getQuantityUnit()) {
                        $this->options[$set->getQuantity() . '|' . $set->getQuantityUnit()->getId()] = array(
                            'name'     => static::t(
                                'qty / unit',
                                array(
                                    'quantity' => $set->getQuantity(),
                                    'unit'     => $set->getQuantityUnit()->getName(),
                                )
                            ),
                            'quantity' => $set->getActualQuantity(),
                            'unit_id'  => $set->getQuantityUnit()->getId(),
                            'qty'      => $set->getQuantity(),
                        );

                    } else {
                        foreach ($this->getProduct()->getQuantityUnits() as $unit) {
                            $this->options[$set->getQuantity() . '|' . $unit->getId()] = array(
                                'name'     => static::t(
                                    'qty / unit',
                                    array(
                                        'quantity' => $set->getQuantity(),
                                        'unit'     => $unit->getName(),
                                    )
                                ),
                                'quantity' => $set->getActualQuantity($unit),
                                'unit_id'  => $unit->getId(),
                                'qty'      => $set->getQuantity(),
                            );
                        }
                    }

                } else {
                    $this->options[strval($set->getQuantity())] = array(
                        'name'     => $set->getQuantity(),
                        'quantity' => $set->getActualQuantity(),
                        'unit_id'  => false,
                        'qty'      => $set->getQuantity(),
                    );
                }
            }

            $this->options = $this->prepareOptions($this->options);
        }

        return $this->options;
    }

    /**
     * Prepare quantity selectbox options
     *
     * @param mixed[] $options Options
     *
     * @return array
     */
    protected function prepareOptions(array $options)
    {
        $minQuantity = $this->getMinQuantity();
        $maxQuantity = $this->getMaxQuantity();

        foreach ($options as $k => $v) {
            if ($v['quantity'] < $minQuantity || $v['quantity'] > $maxQuantity) {
                unset($options[$k]);
            }
        }

        return $options;
    }

    /**
     * Check - specified option selected or not
     *
     * @param string $id Option ID
     *
     * @return boolean
     */
    protected function isSelectedQuantity($id)
    {
        $list = $this->getQuantitiesAsOptions();
        $unit = $this->getQuantityUnit();

        if (!$list[$id]['unit_id'] && $unit) {
            $list[$id]['qty'] *= $unit->getMultiplier();
        }

        return $list[$id]['qty'] == $this->getBoxValue()
            && (!$unit || $unit->getId() == $list[$id]['unit_id'] || !$list[$id]['unit_id']);
    }

    /**
     * Check - has product quantity units or not
     *
     * @return boolean
     */
    protected function hasUnits()
    {
        return count($this->getProduct()->getQuantityUnits()) > 0;
    }

    /**
     * Check - display units select box if quantity control is select box
     *
     * @return boolean
     */
    protected function isDisplayUnitsForSelectBox()
    {
        return $this->hasUnits() && !$this->getProduct()->isQuantitySetsHasUnits();
    }

    /**
     * Get current quantity unit
     *
     * @return \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit
     */
    protected function getQuantityUnit()
    {
        $result = null;

        if ($this->isCartPage()) {
            $result = $this->getParam(static::PARAM_ORDER_ITEM)->getQuantityUnit();

        } else {
            $unitId = intval(\XLite\Core\Request::getInstance()->unit);
            if ($unitId) {
                foreach ($this->getProduct()->getQuantityUnits() as $unit) {
                    if ($unit->getId() == $unitId) {
                        $result = $unit;
                        break;
                    }
                }
            }
        }

        if (!$result && count($this->getProduct()->getQuantityUnits()) > 0) {
            $result = $this->getProduct()->getQuantityUnits()->first();
        }

        return $result;
    }

    /**
     * Check - specified quantity unit is selected or not
     *
     * @param \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit $unit Quantity unit
     *
     * @return boolean
     */
    protected function isSelectedUnit(\XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit $unit)
    {
        return $unit->getId() == $this->getQuantityUnit()->getId();
    }

    /**
     * Get class for quantity unit selector
     *
     * @return string
     */
    protected function getQuantityUnitSelectorClass()
    {
        return 'quantity-unit'
            . ($this->isCartPage() ? ' watcher' : '');
    }

    /**
     * @inheritdoc
     */
    protected function getMinQuantity()
    {
        return $this->getProduct()->getAbsoluteMinimumQuantity();
    }

}
