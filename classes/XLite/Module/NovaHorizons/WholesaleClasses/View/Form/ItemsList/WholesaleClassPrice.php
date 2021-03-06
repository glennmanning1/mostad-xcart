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

namespace XLite\Module\NovaHorizons\WholesaleClasses\View\Form\ItemsList;


class WholesaleClassPrice extends \XLite\View\Form\ItemsList\AItemsList
{
    protected function getDefaultTarget()
    {
        return 'wholesale_class_price';
    }

    protected function getDefaultAction()
    {
        return 'update';


    }

    protected function getDefaultParams()
    {
        $list = parent::getDefaultParams();

        $list['pricing_set_id'] = \XLite\Core\Request::getInstance()->pricing_set_id;;

        return $list;
    }
}