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


abstract class ACustomer extends \XLite\Controller\Customer\ACustomer implements \XLite\Base\IDecorator
{
    const TEMPLATE_PATH = 'modules/Mostad/CustomTheme/categoryListingTemplate/';

    const DEFAULT_TEMPLATE = 'center.tpl';

    public function getListingTemplate()
    {

        if (method_exists($this, 'getCategory') && $this->getCategory()) {
            $template = $this->getCategory()->getListingTemplate();

            if (!empty($template) && $template !== self::DEFAULT_TEMPLATE) {
                return self::TEMPLATE_PATH . $template;
            }
        }

        return self::DEFAULT_TEMPLATE;
    }

}