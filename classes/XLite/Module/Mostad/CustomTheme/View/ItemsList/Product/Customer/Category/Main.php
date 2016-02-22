<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 2/19/16
 * Time: 4:05 PM
 */

namespace XLite\Module\Mostad\CustomTheme\View\ItemsList\Product\Customer\Category;


abstract class Main extends \XLite\View\ItemsList\Product\Customer\Category\Main implements \XLite\Base\IDecorator
{

    protected function isVisible()
    {
        if ($this->getCategory()->getListingTemplate() != '') {
            return false;
        }
        return parent::isVisible() && $this->getCategory() && $this->getCategory()->isVisible();
    }

}