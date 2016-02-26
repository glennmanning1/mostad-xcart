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

namespace XLite\Module\NovaHorizons\CategoryWholesale\View\Tabs;


class Category extends \XLite\View\Tabs\Category implements \XLite\Base\IDecorator
{
    /**
     * Returns the list of targets where this widget is available
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'category_wholesale';

        return $list;
    }

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->tabs['category_wholesale'] = array(
            'title'    => 'Wholesale pricing',
            'template' => 'modules/NovaHorizons/CategoryWholesale/page/body.tpl',
        );
    }

}