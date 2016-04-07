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

namespace XLite\Module\Mostad\UnitOfMeasure\Logic\Import\Processor;


class Products extends \XLite\Logic\Import\Processor\Products implements \XLite\Base\IDecorator
{
    const QUANTITY_CODE = 'PRODUCT-UOM-QUANTITY';
    const DESCRIPTOR_CODE = 'PRODUCT-UOM-DESCRIPTOR';

    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        $columns['uomQuantity'] = array();
        $columns['uomDescriptor'] = array();

        return $columns;
    }

    public static function getMessages()
    {
        $messages = parent::getMessages();

        $messages += array(
            self::QUANTITY_CODE   => 'Wrong unit of measure quantity',
            self::DESCRIPTOR_CODE => 'Wrong unit of measure descriptor',
        );

        return $messages;
    }


    protected function verifyUomQuantity($value, array $column)
    {
        if (
            !$this->verifyValueAsEmpty($value)
            && !$this->verifyValueAsUinteger($value)
            && $value < 1
        ) {
            $this->addWarning(self::QUANTITY_CODE, array('column' => $column, 'value' => $value));
        }
    }

    protected function verifyUomDescriptor($value, array $column)
    {
        if (
            !$this->verifyValueAsEmpty($value)
            && !in_array($value, array_keys(\XLite\Module\Mostad\UnitOfMeasure\Model\Product::$unitsOfMeasure))
        ) {
            $this->addWarning(self::DESCRIPTOR_CODE, array('column' => $column, 'value' => $value));
        }
    }

}