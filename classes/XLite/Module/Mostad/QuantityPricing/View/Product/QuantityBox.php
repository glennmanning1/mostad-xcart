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

    protected $quantityPrices;

    const PARAM_PRODUCT_VARIANT = 'productVariant';


    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_PRODUCT_VARIANT => new \XLite\Model\WidgetParam\Object('ProductVariant', null, false, '\XLite\Module\CDev\Wholesale\Model\ProductVariant')
        );
    }

    protected function isSelectBox()
    {
        return count($this->getQuantityPrices() > 0) && !$this->getOrderItem();
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
            foreach ($this->getQuantityPrices() as $quantityPrice) {
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

    protected function getProductVariant()
    {
//        return $this->getOrderItem()
//            ? $this->getOrderItem()->getProduct()
//            : $this->getParam(self::PARAM_PRODUCT_VARIANT);

        return $this->getParam(self::PARAM_PRODUCT_VARIANT);
    }

    protected function getQuantityPrices()
    {
        if (!$this->quantityPrices) {
            $this->quantityPrices = array();
            /** @var Product $product */
            $product = $this->getProduct();
            /** @var ProductVariant $variant */
            $variant = $this->getProductVariant();

            if(!$variant->getDefaultValue() && $variant->getQuantityPrices()) {
                $this->quantityPrices = $variant->getQuantityPrices();
            } else {
                $this->quantityPrices = $product->getQuantityPrices();
            }
        }

        return $this->quantityPrices;
    }

}