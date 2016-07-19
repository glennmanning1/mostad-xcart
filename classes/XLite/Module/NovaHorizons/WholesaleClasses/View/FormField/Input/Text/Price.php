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

namespace XLite\Module\NovaHorizons\WholesaleClasses\View\FormField\Input\Text;


class Price extends \XLite\View\FormField\Input\Text\Price implements \XLite\Base\IDecorator
{

    const PARAM_SHOW_SYMBOL = 'show_symbol';

    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_SHOW_SYMBOL => new \XLite\Model\WidgetParam\Bool(
                'Show symbol',
                true,
                false,
                []
            ),
        );
    }

    public function getSymbol()
    {
        if (!$this->getParam(self::PARAM_SHOW_SYMBOL)) {
            return '';
        }

        return parent::getSymbol();
    }

}