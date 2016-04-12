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

namespace XLite\Module\QSL\AdvancedQuantity\View;

/**
 * Product price
 */
class Price extends \XLite\View\Price implements \XLite\Base\IDecorator
{
    /**
     * Widget parameter names
     */
    const PARAM_QUANTITY = 'quantity';
    const PARAM_UNIT     = 'unit';

    /**
     * @inheritdoc
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/QSL/AdvancedQuantity/product_quantity_ctrl.js';
        $list[] = 'modules/QSL/AdvancedQuantity/quantity_ctrl.js';

        return $list;
    }

    /**
     * @inheritdoc
     */
    protected function getProduct()
    {
        if (!$this->product) {
            parent::getProduct();
            $this->normalizeProductQuantity();
        }
        $this->product->setupQuantityUnits(
            $this->getParam(static::PARAM_QUANTITY),
            $this->getQuantityUnit()
        );

        return $this->product;
    }

    /**
     * @inheritdoc
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        if (!\XLite\Module\QSL\AdvancedQuantity\Main::isWholesaleModuleEnabled()) {
            $this->widgetParams += array(
                static::PARAM_QUANTITY => new \XLite\Model\WidgetParam\Int('Product quantity', 1),
            );
        }

        $this->widgetParams += array(
            static::PARAM_UNIT     => new \XLite\Model\WidgetParam\Int(
                'Product quantity unit ID',
                null
            ),
        );
    }

    /**
     * Get quantity unit
     *
     * @return \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit
     */
    protected function getQuantityUnit()
    {
        $result = null;

        if (!$this->product) {
            parent::getProduct();
        }

        foreach ($this->product->getQuantityUnits() as $unit) {
            if ($unit->getId() == $this->getParam(static::PARAM_UNIT)) {
                $result = $unit;
                break;
            }
        }
        if (!$result && count($this->product->getQuantityUnits()) > 0) {
            $result = $this->product->getQuantityUnits()->first();
        }

        return $result;
    }

    /**
     * Normalize product quantity
     */
    protected function normalizeProductQuantity()
    {
        $this->getWidgetParams(static::PARAM_QUANTITY)->setValue(
            $this->product->formatQuantity($this->getParam(static::PARAM_QUANTITY))
        );

        $unit = $this->getQuantityUnit();
        if ($this->product->isQuantitySetsHasUnits()) {
            $found = false;
            foreach ($this->product->getQuantitySets() as $set) {
                if (
                    $set->getQuantity() == $this->getParam(static::PARAM_QUANTITY)
                    && (!$set->getQuantityUnit() || ($unit && $set->getQuantityUnit()->getId() == $unit->getId()))
                ) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $set = $this->product->getQuantitySets()->first();
                $this->getWidgetParams(static::PARAM_QUANTITY)->setValue($set->getQuantity());
                if (count($this->product->getQuantityUnits()) > 0) {
                    $this->getWidgetParams(static::PARAM_UNIT)->setValue(
                        $set->getQuantityUnit()
                            ? $set->getQuantityUnit()->getId()
                            : $this->product->getQuantityUnits()->first()->getId()
                    );

                } else {
                    $this->getWidgetParams(static::PARAM_UNIT)->setValue(null);
                }
            }

        } else {
            $this->getWidgetParams(static::PARAM_UNIT)->setValue($unit ? $unit->getId() : null);
        }
    }
}
