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

namespace XLite\Module\NovaHorizons\CategoryWholesale\Controller\Admin;


class CategoryWholesale extends \XLite\Controller\Admin\Category
{

    public function getCategroyId()
    {
        return 10;
    }

    public function doActionCategoryWholesalePriceUpdate()
    {
        $list = new \XLite\Module\NovaHorizons\CategoryWholesale\View\ItemsList\CategoryWholesale();
        $list->processQuick();


    }

}