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
 * @author    Nova Horizons LLC <xcart@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horizons LLC <xcart@novahorizons.io>. All rights reserved
 * @license   https://novahorizons.io/x-cart/license License Agreement
 * @link      https://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\Redirects\View\Menu\Admin;

abstract class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    protected function defineItems()
    {
        $items = parent::defineItems();

        $items['system_settings'][static::ITEM_CHILDREN] += array(
            'redirects' => array(
                static::ITEM_TITLE      => static::t('Redirects'),
                static::ITEM_TARGET     => 'redirects',
                static::ITEM_WEIGHT     => 900,
            ),
        );

        return $items;
    }
}
