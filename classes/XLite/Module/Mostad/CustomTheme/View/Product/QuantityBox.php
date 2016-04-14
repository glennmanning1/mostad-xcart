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

namespace XLite\Module\Mostad\CustomTheme\View\Product;


class QuantityBox extends \XLite\View\Product\QuantityBox implements \XLite\Base\IDecorator
{
    /**
     * CSS class
     *
     * @return string
     */
    protected function getClass()
    {
        return trim(
            'quantity'
//            . ' wheel-ctrl'
            . ($this->isCartPage() ? ' watcher' : '')
            . ' ' . $this->getParam(self::PARAM_STYLE)
            . ' validate[required,custom[integer],min[' . $this->getMinQuantity() . ']'
            . $this->getAdditionalValidate()
            . ']'
        );
    }

}