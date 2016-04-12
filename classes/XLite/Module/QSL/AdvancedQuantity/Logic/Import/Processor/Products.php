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

namespace XLite\Module\QSL\AdvancedQuantity\Logic\Import\Processor;

/**
 * Products import processor
 */
class Products extends \XLite\Logic\Import\Processor\Products implements \XLite\Base\IDecorator
{

    /**
     * Current fraction length
     *
     * @var integer
     */
    protected $current_fraction_length = 0;


    /**
     * @inheritdoc
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();
        $columns['fractionLength'] = array();
        $columns['quantitySets'] = array(static::COLUMN_IS_MULTIPLE => true);
        $columns['quantityUnits'] = array(static::COLUMN_IS_MULTIPLE => true);

        return $columns;
    }

    /**
     * @inheritdoc
     */
    protected function verifyStockLevel($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && !$this->verifyValueAsFloat($value)) {
            $this->addWarning('PRODUCT-STOCK-LEVEL-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * @inheritdoc
     */
    protected function importStockLevelColumn(\XLite\Model\Product $model, $value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && $this->verifyValueAsFloat($value)) {
            // Update quantity only if $value is non-empty float value
            $model->getInventory()->setAmount($this->normalizeValueAsQuantity($value, $model));
        }
    }

    /**
     * Verify 'fraction length' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyFractionLength($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && (!$this->verifyValueAsUinteger($value) || $value > 4)) {
            $this->addWarning('PRODUCT-FRACTION-LENGTH-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * Import 'fraction length' value
     *
     * @param \XLite\Model\Product $model  Product
     * @param mixed                $value  Value
     * @param array                $column Column info
     *
     * @return void
     */
    protected function importFractionLengthColumn(\XLite\Model\Product $model, $value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && $this->verifyValueAsUinteger($value)) {
            // Update quantity only if $value is non-empty integer value
            $model->setFractionLength(min(4, abs(intval($value))));
        }
    }

    /**
     * Get messages
     *
     * @return array
     */
    public static function getMessages()
    {
        return parent::getMessages()
            + array(
                'PRODUCT-FRACTION-LENGTH-FMT' => 'Length of fractional part of quantity is incorrect. Fractional part must be 0-4 digits in length.',
                'PRODUCT-QUANTITY-SET-FMT'    => 'Quantity format is incorrect',
                'PRODUCT-QUANTITY-UNIT-FMT'   => 'Quantity unit format is incorrect',
            );
    }

    /**
     * @inheritdoc
     */
    protected function verifyData(array $data)
    {
        $this->current_fraction_length = isset($data['fractionLength'])
            ? min(4, max(0, intval($data['fractionLength'])))
            : 0;

        return parent::verifyData($data);
    }

    /**
     * @inheritdoc
     */
    protected function updateModel(\XLite\Model\AEntity $model, array $data)
    {
        if (!empty($data['fractionLength'])) {
            $model->setFractionLength(min(4, abs(intval($data['fractionLength']))));
        }

        $result = parent::updateModel($model, $data);

        // Link quantity set and quantity unit
        if ($result && !empty($data['quantitySets'])) {
            try {
                \XLite\Core\Database::getEM()->flush();

            } catch (\Exception $e) {
                \XLite\Logger::getInstance()->registerException($e);
                $result = false;
            }

            if ($result) {
                foreach ($data['quantitySets'] as $row) {
                    $parts = explode('/', $row, 2);
                    $quantity = $this->normalizeValueAsQuantity($parts[0], $model);
                    if (!empty($parts[1]) && $quantity > 0) {
                        $found = false;
                        foreach ($model->getQuantityUnits() as $unit) {
                            if ($unit->getName() == $parts[1]) {
                                $found = $unit;
                                break;
                            }
                        }

                        if ($found) {
                            foreach ($model->getQuantitySets() as $set) {
                                if ($set->getQuantity() == $quantity) {
                                    $set->setQuantityUnit($found);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Verify 'quantity sets' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyQuantitySets($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && !$this->verifyValueAsNull($value)) {
            foreach ($value as $row) {
                $parts = explode('/', $row, 2);
                if (!$this->verifyValueAsEmpty($parts[0]) && !$this->verifyValueAsFloat($parts[0])) {
                    $this->addWarning('PRODUCT-QUANTITY-SET-FMT', array('column' => $column, 'value' => $row, 'fraction_length' => $this->current_fraction_length));
                }
            }
        }
    }

    /**
     * Import 'quantity sets' value
     *
     * @param \XLite\Model\Product $model  Product
     * @param array                $value  Value
     * @param array                $column Column info
     *
     * @return void
     */
    protected function importQuantitySetsColumn(\XLite\Model\Product $model, array $value, array $column)
    {
        if ($value) {
            foreach ($model->getQuantitySets() as $submodel) {
                $submodel->setProduct(null);
                \XLite\Core\Database::getEM()->remove($submodel);
            }
            $model->getQuantitySets()->clear();

            if (!$this->verifyValueAsNull($value)) {
                $i = 0;
                foreach ($value as $row) {
                    $parts = explode('/', $row, 2);
                    $quantity = $this->normalizeValueAsQuantity($parts[0], $model);
                    if ($quantity) {
                        $submodel = new \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantitySet();
                        $submodel->setQuantity($quantity);
                        $submodel->setPosition($i++);
                        $model->addQuantitySets($submodel);
                        $submodel->setProduct($model);
                    }
                }
            }
        }
    }

    /**
     * Verify 'quantity units' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyQuantityUnits($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && !$this->verifyValueAsNull($value)) {
            foreach ($value as $row) {
                if (!$this->verifyValueAsEmpty($row)) {
                    $parts = explode('=', $row);
                    $quantity = array_pop($parts);
                    $name = implode('=', $parts);
                    if (!$this->verifyValueAsFloat($quantity) || $this->verifyValueAsEmpty($name)) {
                        $this->addWarning('PRODUCT-QUANTITY-UNIT-FMT', array('column' => $column, 'value' => $row));
                    }
                }
            }
        }
    }

    /**
     * Import 'quantity units' value
     *
     * @param \XLite\Model\Product $model  Product
     * @param array                $value  Value
     * @param array                $column Column info
     *
     * @return void
     */
    protected function importQuantityUnitsColumn(\XLite\Model\Product $model, array $value, array $column)
    {
        if ($value) {
            foreach ($model->getQuantityUnits() as $submodel) {
                $submodel->setProduct(null);
                \XLite\Core\Database::getEM()->remove($submodel);
            }
            $model->getQuantityUnits()->clear();

            if (!$this->verifyValueAsNull($value)) {
                $i = 0;
                foreach ($value as $row) {
                    $parts = explode('=', $row);
                    $quantity = array_pop($parts);
                    $name = implode('=', $parts);
                    $quantity = $this->normalizeValueAsQuantity($quantity, $model);
                    if ($quantity) {
                        $submodel = new \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit();
                        $submodel->setMultiplier($quantity);
                        $submodel->setName($name);
                        $submodel->setPosition($i++);
                        $model->addQuantityUnits($submodel);
                        $submodel->setProduct($model);
                    }
                }
            }
        }
    }

    /**
     * Normalize quantity
     *
     * @param float                $quantity Quantity
     * @param \XLite\Model\Product $model    Product
     *
     * @return float
     */
    protected function normalizeValueAsQuantity($quantity, \XLite\Model\Product $model)
    {
        return round(abs(doubleval($quantity)), $model->getFractionlength());
    }

}
