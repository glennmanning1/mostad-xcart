<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 2/18/16
 * Time: 11:09 AM
 */

namespace XLite\Module\Mostad\CustomTheme\View\FormField\Select;


class CategoryListingTemplate extends \XLite\View\FormField\Select\ASelect
{

    public static $categoryListingTemplates = array(
        'center.tpl'                 => 'Default',
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