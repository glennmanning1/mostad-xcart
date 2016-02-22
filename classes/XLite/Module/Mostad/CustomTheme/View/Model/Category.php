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

namespace XLite\Module\Mostad\CustomTheme\View\Model;


class Category extends \XLite\View\Model\Category implements \XLite\Base\IDecorator
{
    public function __construct(array $params = array(), array $sections = array())
    {
        $this->schemaDefault['listingTemplate'] = array(
            self::SCHEMA_CLASS   => 'XLite\Module\Mostad\CustomTheme\View\FormField\Select\CategoryListingTemplate',
            self::SCHEMA_LABEL   => 'Listing Template',
            self::SCHEMA_REQUIRED => false,
        );

        parent::__construct($params, $sections);
    }

}