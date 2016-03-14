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

namespace XLite\Module\Mostad\CustomTheme\View\FormField\Select;


class CategoryListingTemplate extends \XLite\View\FormField\Select\ASelect
{

    public static $categoryListingTemplates = array(
        ''                           => 'Default',
        'anchoredProductListing.tpl' => 'Anchored Product Listing',
        'productListing.tpl'         => 'Product Listing',
        'subcategoryListing.tpl'     => 'Subcategory Listing',
    );

    /**
     * Return default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return self::$categoryListingTemplates;
    }
}