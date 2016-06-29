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

namespace XLite\Module\Mostad\QuantityPricing\View\Form\ItemsList;


class ProductVariantQuantityPricing extends \XLite\Module\Mostad\QuantityPricing\View\Form\ItemsList\QuantityPricing implements \XLite\Base\IDecorator
{
    /**
     * Return list of the form default parameters
     *
     * @return array
     */
    protected function getDefaultParams()
    {
        if ('product_variant' == $this->getTarget()) {
            $list['page'] = $this->page;
            $list['id'] = $this->getProductVariant()->getId();

        } else {
            $list = parent::getDefaultParams();
        }

        return $list;
    }
}