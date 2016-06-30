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

namespace XLite\Module\Mostad\QuantityPricing\View\Product;


use XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice;

class QuantityBox extends \XLite\View\Product\QuantityBox implements \XLite\Base\IDecorator
{
    protected $options;

    protected function isSelectBox()
    {
        return count($this->getProduct()->getQuantityPrices() > 0) && !$this->getOrderItem();
    }

    protected function getQuantitiesAsOptions()
    {
        if (!$this->options) {
            $this->options    = [];
            $this->options[0] = [
                'name'     => $this->getProduct()->getQuantityPriceDescriptor(),
                'quantity' => 0,
                'unit_id'  => false,
                'qty'      => 0,
            ];
            /** @var QuantityPrice $quantityPrice */
            foreach ($this->getProduct()->getQuantityPrices() as $quantityPrice) {
                $this->options[ strval($quantityPrice->getQuantity()) ] = [
                    'name'     => $quantityPrice->getQuantity() . ' for ' . static::formatPrice($quantityPrice->getPrice()),
                    'quantity' => $quantityPrice->getQuantity(),
                    'unit_id'  => false,
                    'qty'      => $quantityPrice->getQuantity(),
                ];
            }
        }

        return $this->options;
    }

    protected function isSelectedQuantity($id)
    {
        return false;
    }

}