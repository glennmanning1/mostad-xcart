<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\CDev\Coupons\Core;

/**
 * Coupon compatibility exception
 */
class CompatibilityException extends \XLite\Core\Exception
{
    /**
     * Coupon
     *
     * @var \XLite\Module\CDev\Coupons\Model\Coupon
     */
    protected $coupon;

    /**
     * Message params
     *
     * @var array
     */
    protected $params;

    /**
     * Error code
     *
     * @var string
     */
    protected $errorCode;

    /**
     * Constructor
     *
     * @param string                                  $message  Message text
     * @param array                                   $params   Message params
     * @param \XLite\Module\CDev\Coupons\Model\Coupon $coupon   Coupon
     * @param string                                  $code     Code
     * @param \Exception                              $previous Previous
     */
    public function __construct(
        $message = '',
        array $params = array(),
        \XLite\Module\CDev\Coupons\Model\Coupon $coupon = null,
        $code = '',
        \Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);

        $this->setErrorCode($code);
        $this->setParams($params);
        $this->setCoupon($coupon);
    }

    /**
     * Set coupon
     *
     * @param \XLite\Module\CDev\Coupons\Model\Coupon $coupon Coupon
     *
     * @return void
     */
    public function setCoupon(\XLite\Module\CDev\Coupons\Model\Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Returns coupon
     *
     * @return \XLite\Module\CDev\Coupons\Model\Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Set params
     *
     * @param array $params Params OPTIONAL
     *
     * @return void
     */
    public function setParams(array $params = array())
    {
        $this->params = $params;
    }

    /**
     * Returns params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params ?: array();
    }

    /**
     * Set error code
     *
     * @param string $errorCode Error code OPTIONAL
     *
     * @return void
     */
    public function setErrorCode($errorCode = '')
    {
        $this->errorCode = $errorCode;
    }

    /**
     * Returns error code
     *
     * @return array
     */
    public function getErrorCode()
    {
        return $this->errorCode ?: '';
    }
}
