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

namespace XLite\Module\Mostad\Coupons\Model;


use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @LC_Dependencies("CDev\Coupons","XC\FreeShipping")
 */
class Coupon extends \XLite\Module\CDev\Coupons\Model\Coupon implements \XLite\Base\IDecorator
{
    const TYPE_DEFERRED = 'D';

    /**
     * @var boolean
     *
     * @Column(name="free_shipping", type="boolean")
     */
    protected $freeShipping = false;

    /**
     * @var bool
     *
     * @Column(name="deferred_billing", type="boolean")
     */
    protected $deferredBilling = false;

    /**
     * @var \XLite\Model\Product
     *
     * @ManyToOne(targetEntity="XLite\Model\Product")
     * @JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE", nullable=true)
     */
    protected $product;

    /**
     * Coupon constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);

    }

    /**
     * @return bool
     */
    public function isFreeShipping()
    {
        return static::TYPE_FREESHIP == $this->getType() ||
               $this->freeShipping;
    }

    /**
     * @return bool
     */
    public function getFreeShipping()
    {
        return $this->freeShipping;
    }

    /**
     * @param $freeShipping
     *
     * @return $this
     */
    public function setFreeShipping($freeShipping)
    {
        $this->freeShipping = $freeShipping;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeferredBilling()
    {
        return static::TYPE_DEFERRED == $this->getType() || $this->deferredBilling;
    }

    /**
     * @return bool
     */
    public function getDeferredBilling()
    {
        return $this->deferredBilling;
    }

    /**
     * @param $deferredBilling
     *
     * @return $this
     */
    public function setDeferredBilling($deferredBilling)
    {
        $this->deferredBilling = $deferredBilling;

        return $this;
    }

    public function setProduct($product)
    {
        if (!$product instanceof \XLite\Model\Product) {
            $product = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($product);
        }

        $this->product = $product;

        return $this;
    }

    public function isValidForProduct(\XLite\Model\Product $product)
    {
        $thisProduct = $this->getProduct();

        if (!empty($thisProduct)) {
            return $this->getProduct()->getId() == $product->getId();
        }

        return parent::isValidForProduct($product);
    }

    /**
     * Get amount
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return float
     */
    public function getAmount(\XLite\Model\Order $order)
    {
        $amount = \XLite\Module\CDev\Coupons\Model\CouponAbstract::getAmount($order);

        return $this->isFreeShipping() ? $amount : $amount;
    }

}