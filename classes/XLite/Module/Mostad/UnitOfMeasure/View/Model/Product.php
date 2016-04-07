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

namespace XLite\Module\Mostad\UnitOfMeasure\View\Model;


class Product extends \XLite\View\Model\Product implements \XLite\Base\IDecorator
{
    public function __construct(array $params = array(), array $sections = array())
    {
        parent::__construct($params, $sections);

        $this->schemaDefault = array_slice($this->schemaDefault, 0, 8, true)
            +  array (
            'uomQuantity' => array(
                self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
                self::SCHEMA_LABEL    => 'Unit of measure quantity',
                self::SCHEMA_REQUIRED => true,
                ),
            'uomDescriptor' => array(
                self::SCHEMA_CLASS    => 'XLite\Module\Mostad\UnitOfMeasure\View\FormField\Select\UnitOfMeasure',
                self::SCHEMA_LABEL    => 'Unit of measure descriptor',
                self::SCHEMA_REQUIRED => true,
                ),
            )
            + array_slice($this->schemaDefault, 8, count($this->schemaDefault)-8, true);
    }
}