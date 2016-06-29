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

namespace XLite\Module\Mostad\QuantityPricing\View\ItemsList\Model;


class ProductVariant extends \XLite\Module\XC\ProductVariants\View\ItemsList\Model\ProductVariant implements \XLite\Base\IDecorator
{
    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        if (isset($columns['price'])) {
            $columns['quantityPricing'] =  array(
                static::COLUMN_CLASS   => 'XLite\Module\Mostad\QuantityPricing\View\FormField\QuantityPricing',
                static::COLUMN_ORDERBY => $columns['price'][static::COLUMN_ORDERBY] + 2,
            );
        }

        return $columns;
    }
}