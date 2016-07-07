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

namespace XLite\Module\Mostad\QuantityPricing\View\Menu\Admin;


abstract class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    protected function defineItems()
    {
        $items = parent::defineItems();

        $items['catalog'][static::ITEM_CHILDREN] += array(
            'redirects' => array(
                static::ITEM_TITLE      => static::t('Quantity pricing'),
                static::ITEM_TARGET     => 'quantity_pricing',
                static::ITEM_WEIGHT     => 900,
            ),
        );

        return $items;
    }
}
