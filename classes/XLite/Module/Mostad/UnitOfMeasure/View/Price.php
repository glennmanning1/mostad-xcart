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

namespace XLite\Module\Mostad\UnitOfMeasure\View;


class Price extends \XLite\View\Price implements \XLite\Base\IDecorator
{

    public function getUOM()
    {
        $product = $this->getProduct();

        $output = 'per ' . $product->getUomDescriptor(true);

        if ($product->getUomQuantity() <= 1) {
            return $output;
        }

        return $output . ' of ' . $product->getUomQuantity();
    }
}