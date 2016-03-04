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

namespace XLite\Module\NovaHorizons\CategoryWholesale;


abstract class Main extends \XLite\Module\AModule
{
    public static function getAuthorName()
    {
        return 'Nova Horizons';
    }

    public static function getMajorVersion()
    {
        return '5.2';
    }

    public static function getMinorVersion()
    {
        return '0';
    }

    public static function getModuleName()
    {
        return 'Category Based Wholesale';
    }

    public static function getDescription()
    {
        return 'Enables wholesale or volume pricing based on category and customer membership level.';
    }

    public static function runBuildCacheHandler()
    {
        parent::runBuildCacheHandler();

        \XLite\Core\Layout::getInstance()->removeTemplateFromLists('common/price_parts/price.tpl');
    }

}