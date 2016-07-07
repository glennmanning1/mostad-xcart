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


class WholesaleClassPricingSet extends \XLite\Module\NovaHorizons\WholesaleClasses\View\ItemsList\Model\WholesaleClassPricingSet implements \XLite\Base\IDecorator
{
    protected function defineColumns()
    {
        $list = parent::defineColumns();

        $list['quantity_pricing'] = [
            static::COLUMN_TEMPLATE      => 'modules/Mostad/QuantityPricing/page/wholesale_class_pricing_set/parts/edit_quantity_pricing.tpl',
            static::COLUMN_HEAD_TEMPLATE => 'modules/Mostad/QuantityPricing/page/wholesale_class_pricing_set/parts/quantity_pricing_header.tpl',
            static::COLUMN_ORDERBY       => 400,
        ];

        return $list;
    }

    protected function getEditQuantityPricingURL($entity)
    {
        //wholesale_class_price&pricing_set_id=2&page=quantity_pricing
        return $entity ? $this->buildURL('wholesale_class_price', null, array('pricing_set_id' => $entity->getId(), 'page' => 'quantity_pricing')) : null;
    }

}