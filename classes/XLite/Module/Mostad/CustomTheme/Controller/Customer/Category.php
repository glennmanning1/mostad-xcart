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

namespace XLite\Module\Mostad\CustomTheme\Controller\Customer;


abstract class Category extends \XLite\Controller\Customer\Category implements \XLite\Base\IDecorator
{

    const TEMPLATE_PATH = 'modules/Mostad/CustomTheme/categoryListingTemplate/';

    public function getListingTemplate()
    {
        $template = $this->getCategory()->getListingTemplate();

        if (empty($template)) {
            return 'center.tpl';
        }

        return self::TEMPLATE_PATH . $template;
    }

}