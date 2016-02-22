<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 2/18/16
 * Time: 10:44 AM
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