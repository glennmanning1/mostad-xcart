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

namespace XLite\Module\NovaHorizons\WholesaleClasses\View\Menu\Admin;

abstract class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    public function __construct(array $params = [])
    {
        parent::__construct($params);

        if (!isset($this->relatedTargets['wholesale_class_pricing_set'])) {
            $this->relatedTargets['wholesale_class_pricing_set'] = [
                "wholesale_class_price",
                "wholesale_class_pricing_set",
            ];
        }
    }

    protected function defineItems()
    {
        $items = parent::defineItems();

        $items['catalog'][ static::ITEM_CHILDREN ] += [
            'wholesale_class_price' => [
                static::ITEM_TITLE  => static::t('Wholesale Class Pricing'),
                static::ITEM_TARGET => 'wholesale_class_pricing_set',
                static::ITEM_WEIGHT => 450,
            ],
        ];

        return $items;
    }
}