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

namespace XLite\Module\Mostad\QuantityPricing\Controller\Admin;


class ProductVariant extends \XLite\Module\XC\ProductVariants\Controller\Admin\ProductVariant implements \XLite\Base\IDecorator
{
    const PAGE_QUANTITY_PRICING = 'quantity_pricing';
    public function getPages()
    {
        $list = parent::getPages();
        $list[static::PAGE_QUANTITY_PRICING] = static::t('Quantity pricing');

        return $list;
    }

    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();
        $list[static::PAGE_QUANTITY_PRICING] = 'modules/Mostad/QuantityPricing/page/quantity_pricing.tpl';
        
        return $list;
    }

    public function getObject()
    {
        return $this->getProductVariant();
    }

    /**
     * Handle the update to product variant quantity pricing
     */
    protected function doActionQuantityPricingUpdate()
    {
        $list = new \XLite\Module\Mostad\QuantityPricing\View\ItemsList\Model\QuantityPrice();
        $list->processQuick();
    }

}