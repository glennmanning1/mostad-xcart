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

    /**
     * @var boolean
     *
     * @Column(name="free_shipping", type="boolean")
     */
    protected $freeShipping = false;

    /**
     * @var \XLite\Model\Product
     *
     * @ManyToOne(targetEntity="XLite\Model\Product")
     * @JoinColumn(name="product_id", referencedColumnName="product_id", onDelete="CASCADE")
     */
    protected $product;

    protected $foo;

    /**
     * Coupon constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = array())
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

    public function setProduct(\XLite\Model\Product $product)
    {
        if (!$product instanceof \XLite\Model\Product) {
            $product = \XLite\Core\Database::getRepo('XLite\Model\Product')->find($product);
        }

        $this->product = $product;

        return $this;
    }

    public function isValidForProduct(\XLite\Model\Product $product)
    {
        $result = true;

        if ($this->getProduct() == $product) {
            return $result;
        }

        if (0 < count($this->getProductClasses())) {
            // Check product class
            $result = $product->getProductClass()
                && $this->getProductClasses()->contains($product->getProductClass());
        }

        if ($result && 0 < count($this->getCategories())) {
            // Check categories
            $result = false;
            foreach ($product->getCategories() as $category) {
                if ($this->getCategories()->contains($category)) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

}