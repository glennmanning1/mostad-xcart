<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 9/2/16
 * Time: 3:37 PM
 */

namespace XLite\Module\Mostad\Coupons\Controller\Customer;

/**
 * @LC_Dependencies("CDev\Coupons")
 */
abstract class ACustomer extends \XLite\Controller\Customer\ACustomer implements \XLite\Base\IDecorator
{

    /**
     * Get fingerprint difference
     *
     * @param array $old Old fingerprint
     * @param array $new New fingerprint
     *
     * @return array
     */
    protected function getCartFingerprintDifference(array $old, array $new)
    {
        $diff = parent::getCartFingerprintDifference($old, $new);

        if (count($old['coupons']) !== count($new['coupons'])
            || count($old['coupons']) !== count(array_intersect($old['coupons'], $new['coupons']))
        ) {
            if (!isset($diff['items'])) {
                $diff['items'] = array();
            }
            $diff['items']['changed'] = 1;

        }

        return $diff;
    }

}