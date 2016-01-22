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

namespace XLite\Module\Mostad\CustomTheme\View;

abstract class AView extends \XLite\View\AView implements \XLite\Base\IDecorator
{
    /**
     * @param null $adminZone
     *
     * @return array
     */
    protected function getThemeFiles($adminZone = null)
    {

        $list = parent::getThemeFiles($adminZone);

//        $list[static::RESOURCE_JS][] = '';

        $list[ static::RESOURCE_CSS ][] = [
            'file'  => 'modules/Mostad/CustomTheme/mostad.less',
            'media' => 'screen',
            'merge' => 'bootstrap/css/bootstrap.less',
        ];

        return $list;
    }

}