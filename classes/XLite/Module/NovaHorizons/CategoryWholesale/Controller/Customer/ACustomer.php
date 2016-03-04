<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 3/3/16
 * Time: 3:09 PM
 */

namespace XLite\Module\NovaHorizons\CategoryWholesale\Controller\Customer;


abstract class ACustomer extends \XLite\Controller\Customer\ACustomer implements \XLite\Base\IDecorator
{

    public function isCategoryWholesalePricesEnabled()
    {
        return false;
    }

}