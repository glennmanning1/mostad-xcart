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

namespace XLite\Module\Mostad\QuantityPricing\View;


class Price extends \XLite\View\Price implements \XLite\Base\IDecorator
{
    /**
     * Widget parameter names
     */
    const PARAM_QUANTITY = 'quantity';

    /**
     * Return JS files for widget
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/Mostad/QuantityPricing/quantity_controller.js';

        return $list;
    }

    /**
     * Get product
     *
     * @return \XLite\Model\Product
     */
    protected function getProduct()
    {
        if (!$this->product) {
            parent::getProduct();
        }
        $this->product->setCurrentQuantity($this->getParam(static::PARAM_QUANTITY));
        return $this->product;
    }

    protected function getProductVariant()
    {
        if (!$this->productVariant) {
            parent::getProductVariant();
        }

        $this->productVariant->setCurrentQuantity($this->getParam(static::PARAM_QUANTITY));

        return $this->productVariant;
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_QUANTITY => new \XLite\Model\WidgetParam\Int('Product quantity', 1),
        );
    }

}