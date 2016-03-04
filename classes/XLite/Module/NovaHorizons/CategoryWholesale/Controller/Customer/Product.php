<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 3/4/16
 * Time: 9:58 AM
 */

namespace XLite\Module\NovaHorizons\CategoryWholesale\Controller\Customer;


class Product extends \XLite\Controller\Customer\Product implements \XLite\Base\IDecorator
{

    public function isCategoryWholesalePricesEnabled()
    {
        $category = null;

        if (method_exists($this, 'getProduct') && $this->getProduct()) {
            $category = $this->getProduct()->getCategory();
        }

        if ($category === null) {
            return false;
        }


        $wholesaleCategories = \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\CategoryWholesale\Model\CategoryWholesalePrice')
            ->getWholesaleCategories();


        return $category->isCategoryWholesalePricesEnabled($wholesaleCategories);
    }

}