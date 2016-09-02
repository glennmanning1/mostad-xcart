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

namespace XLite\Module\Mostad\Coupons\View\ItemsList;

/**
 * @LC_Dependencies("CDev\Coupons","XC\FreeShipping")
 */
class Coupons extends \XLite\Module\CDev\Coupons\View\ItemsList\Coupons implements \XLite\Base\IDecorator
{
    /**
     * @return array
     */
    protected function defineColumns()
    {
        $list = parent::defineColumns();

        $list['freeShipping'] = [
            static::COLUMN_NAME    => static::t('Free shipping'),
            static::COLUMN_ORDERBY => 350,
        ];

        $list['deferred'] = [
            static::COLUMN_NAME    => static::t('Deferred billing'),
            static::COLUMN_ORDERBY => 375,
        ];

        return $list;
    }

    /**
     * @param mixed $value
     * @param array $column
     * @param \XLite\Module\CDev\Coupons\Model\Coupon $coupon
     *
     * @return mixed
     */
    protected function preprocessValue($value, array $column, \XLite\Module\CDev\Coupons\Model\Coupon $coupon)
    {
        return \XLite\Module\CDev\Coupons\View\ItemsList\CouponsAbstract::preprocessValue($value, $column, $coupon);
    }

    /**
     * @param $value
     * @param array $column
     * @param \XLite\Module\CDev\Coupons\Model\Coupon $coupon
     *
     * @return string
     */
    protected function preprocessFreeShipping($value, array $column, \XLite\Module\CDev\Coupons\Model\Coupon $coupon)
    {
        return $coupon->isFreeShipping()
            ? static::t('Yes')
            : static::t('No');
    }

    protected function preprocessDeferred($value, array $column, \XLite\Module\CDev\Coupons\Model\Coupon $coupon)
    {
        return $coupon->getType() == \XLite\Module\CDev\Coupons\Model\Coupon::TYPE_DEFERRED
            ? static::t('Yes')
            : static::t('No');
    }

}