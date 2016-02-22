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

namespace XLite\Module\Mostad\Marketing\View;


class Page extends \XLite\Module\CDev\SimpleCMS\View\Page implements \XLite\Base\IDecorator
{

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
//        if ($this->isDisableLayout()) {
//            return 'modules/Mostad/Marketing/page/body.tpl';
//        }
        return 'modules/CDev/SimpleCMS/page/body.tpl';
    }

}