<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 3/4/16
 * Time: 9:57 AM
 */

namespace XLite\Module\NovaHorizons\CategoryWholesale\Controller\Customer;


class Category extends \XLite\Controller\Customer\Category implements \XLite\Base\IDecorator
{
    public function isCategoryWholesalePricesEnabled()
    {
        $category = null;

        if (method_exists($this, 'getCategory') && $this->getCategory()) {
            $category = $this->getCategory();
        }

        if ($category === null) {
            return false;
        }


        $wholesaleCategories = \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\CategoryWholesale\Model\CategoryWholesalePrice')
            ->getWholesaleCategories();


        return $category->isCategoryWholesalePricesEnabled($wholesaleCategories);
    }
}