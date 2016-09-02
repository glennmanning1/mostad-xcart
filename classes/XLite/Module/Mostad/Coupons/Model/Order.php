<?php
/**
 * Created by PhpStorm.
 * User: drew
 * Date: 9/2/16
 * Time: 7:34 AM
 */

namespace XLite\Module\Mostad\Coupons\Model;


class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{


    /**
     * Return list of available payment methods
     *
     * @return array
     */
    public function getPaymentMethods()
    {
        $list = [];

        if ($this->hasDeferredCoupon()) {

            $list = $this->getDeferredMethod(true);

        }


        if (!empty($list)) {
            return $list;
        } else {
            return parent::getPaymentMethods();
        }

    }

    /**
     * Renew payment method
     *
     * @return void
     */
    public function renewPaymentMethod()
    {
        if ($this->hasDeferredCoupon()) {
            $method = $this->getDeferredMethod();
            $this->setPaymentMethod($method);
        }

        parent::renewPaymentMethod();
    }

    /**
     * @return bool
     */
    protected function hasDeferredCoupon()
    {
        $deferred = false;

        foreach ($this->usedCoupons as $usedCoupon) {
            if ($usedCoupon->getCoupon()->getType() == 'D') {
                $deferred = true;
            }
        }

        return $deferred;
    }


    /**
     * @param bool $asArray
     *
     * @return mixed
     */
    protected function getDeferredMethod($asArray = false)
    {
        $cnd = new \XLite\Core\CommonCell;

        $cnd->{\XLite\Model\Repo\Payment\Method::P_NAME} = 'Deferred';

        $list = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')
            ->search($cnd);

        if ($asArray) {
            return $list;
        }

        return reset($list);
    }

}