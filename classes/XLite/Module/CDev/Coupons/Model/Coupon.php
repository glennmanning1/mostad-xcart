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

namespace XLite\Module\CDev\Coupons\Model;

/**
 * Coupon
 *
 * @Entity (repositoryClass="\XLite\Module\CDev\Coupons\Model\Repo\Coupon")
 * @Table  (name="coupons",
 *      indexes={
 *          @Index (name="ce", columns={"code", "enabled"})
 *      }
 * )
 */
class Coupon extends \XLite\Model\AEntity
{
    /**
     * Coupon types
     */
    const TYPE_PERCENT  = '%';
    const TYPE_ABSOLUTE = '$';

    /**
     * Coupon validation error codes
     */
    const ERROR_DISABLED      = 'disabled';
    const ERROR_EXPIRED       = 'expired';
    const ERROR_USES          = 'uses';
    const ERROR_TOTAL         = 'total';
    const ERROR_PRODUCT_CLASS = 'product_class';
    const ERROR_MEMBERSHIP    = 'membership';
    const ERROR_SINGLE_USE    = 'singleUse';
    const ERROR_SINGLE_USE2   = 'singleUse2';
    const ERROR_CATEGORY      = 'category';


    /**
     * Product unique ID
     *
     * @var   integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Code
     *
     * @var   string
     *
     * @Column (type="string", options={ "fixed": true }, length=16)
     */
    protected $code;

    /**
     * Enabled status
     *
     * @var   boolean
     *
     * @Column (type="boolean")
     */
    protected $enabled = true;

    /**
     * Value
     *
     * @var   float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $value = 0.0000;

    /**
     * Type
     *
     * @var   string
     *
     * @Column (type="string", options={ "fixed": true }, length=1)
     */
    protected $type = self::TYPE_PERCENT;

    /**
     * Comment
     *
     * @var   string
     *
     * @Column (type="string", length=64)
     */
    protected $comment = '';

    /**
     * Uses count
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $uses = 0;

    /**
     * Date range (begin)
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $dateRangeBegin = 0;

    /**
     * Date range (end)
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $dateRangeEnd = 0;

    /**
     * Total range (begin)
     *
     * @var   float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $totalRangeBegin = 0;

    /**
     * Total range (end)
     *
     * @var   float
     *
     * @Column (type="decimal", precision=14, scale=4)
     */
    protected $totalRangeEnd = 0;

    /**
     * Uses limit
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $usesLimit = 0;

    /**
     * Uses limit per user
     *
     * @var   integer
     *
     * @Column (type="integer", options={ "unsigned": true })
     */
    protected $usesLimitPerUser = 0;

    /**
     * Flag: Can a coupon be used together with other coupons (false) or no (true)
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $singleUse = false;

    /**
     * Product classes
     *
     * @var   \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToMany (targetEntity="XLite\Model\ProductClass", inversedBy="coupons")
     * @JoinTable (name="product_class_coupons",
     *      joinColumns={@JoinColumn (name="coupon_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn (name="class_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $productClasses;

    /**
     * Memberships
     *
     * @var   \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToMany (targetEntity="XLite\Model\Membership", inversedBy="coupons")
     * @JoinTable (name="membership_coupons",
     *      joinColumns={@JoinColumn (name="coupon_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn (name="membership_id", referencedColumnName="membership_id", onDelete="CASCADE")}
     * )
     */
    protected $memberships;

    /**
     * Used coupons
     *
     * @var   \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Module\CDev\Coupons\Model\UsedCoupon", mappedBy="coupon")
     */
    protected $usedCoupons;

    /**
     * Categories
     *
     * @var   \Doctrine\Common\Collections\ArrayCollection
     *
     * @ManyToMany (targetEntity="XLite\Model\Category", inversedBy="coupons")
     * @JoinTable (name="coupon_categories",
     *      joinColumns={@JoinColumn (name="coupon_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn (name="category_id", referencedColumnName="category_id", onDelete="CASCADE")}
     * )
     */
    protected $categories;

    protected static $runtimeCacheForUsedCouponsCount = array();

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     */
    public function __construct(array $data = array())
    {
        $this->productClasses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->memberships    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usedCoupons    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories     = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Check - discount is absolute or not
     *
     * @return boolean
     */
    public function isAbsolute()
    {
        return static::TYPE_ABSOLUTE === $this->getType();
    }

    /**
     * Check - coupon is started
     *
     * @return boolean
     */
    public function isStarted()
    {
        return 0 === $this->getDateRangeBegin() || $this->getDateRangeBegin() < \XLite\Core\Converter::time();
    }

    /**
     * Check - coupon is expired or not
     *
     * @return boolean
     */
    public function isExpired()
    {
        return 0 < $this->getDateRangeEnd() && $this->getDateRangeEnd() < \XLite\Core\Converter::time();
    }

    /**
     * Check coupon activity
     *
     * @param \XLite\Model\Order $order Order OPTIONAL
     *
     * @return boolean
     */
    public function isActive(\XLite\Model\Order $order = null)
    {
        try {
            $result = $this->checkCompatibility($order);
        } catch (\XLite\Module\CDev\Coupons\Core\CompatibilityException $exception) {
            $result = false;
        }

        return $result;
    }


    // {{{ Amount

    /**
     * Get amount
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return float
     */
    public function getAmount(\XLite\Model\Order $order)
    {
        $total = $this->getOrderTotal($order);

        return $this->isAbsolute()
            ? min($total, $this->getValue())
            : ($total * $this->getValue() / 100);
    }

    /**
     * Get order total
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return float
     */
    protected function getOrderTotal(\XLite\Model\Order $order)
    {
        return array_reduce($this->getValidOrderItems($order), function ($carry, $item) {
            return $carry + $item->getSubtotal();
        }, 0);
    }

    /**
     * Get order items which are valid for the coupon
     *
     * @param \XLite\Model\Order $order Order
     *
     * @return array
     */
    protected function getValidOrderItems($order)
    {
        $items = array();
        foreach ($order->getItems() as $item) {
            if ($this->isValidForProduct($item->getProduct())) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Is coupon valid for product
     *
     * @param \XLite\Model\Product $product Product
     *
     * @return boolean
     */
    public function isValidForProduct(\XLite\Model\Product $product)
    {
        $result = true;

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

    // }}}

    /**
     * Check coupon compatibility
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return boolean
     */
    public function checkCompatibility(\XLite\Model\Order $order = null)
    {
        if (!$this->getEnabled()) {
            $this->throwCompatibilityException(
                '',
                'Sorry, the coupon you entered is invalid. Make sure the coupon code is spelled correctly'
            );
        }

        $this->checkDate();
        $this->checkUsage();

        if ($order) {
            if ($order->getProfile()) {
                $this->checkPerUserUsage($order->getProfile(), $order->containsCoupon($this));
            }
            $this->checkConflictsWithCoupons($order);
            $this->checkMembership($order);
            $this->checkCategory($order);
            $this->checkProductClass($order);
            $this->checkOrderTotal($order);
        }

        return true;
    }

    // {{{ Date

    /**
     * Check coupon dates
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkDate()
    {
        if (!$this->isStarted()) {
            $this->throwCompatibilityException(
                '',
                'Sorry, the coupon you entered is invalid. Make sure the coupon code is spelled correctly'
            );
        }
        if ($this->isExpired()) {
            $this->throwCompatibilityException(
                '',
                'Sorry, the coupon has expired'
            );
        }
    }

    // }}}

    // {{{ Usage

    /**
     * Check coupon usages
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkUsage()
    {
        if (0 < $this->getUsesLimit() && $this->getUsesLimit() <= $this->getUses()) {
            $this->throwCompatibilityException(
                '',
                'Sorry, the coupon use limit has been reached'
            );
        }
    }

    /**
     * Check coupon usages per user
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkPerUserUsage(\XLite\Model\Profile $profile, $inOrder)
    {
        if (0 >= $this->getUsesLimitPerUser()) {
            return;
        }

        $this->profilesUsesCount();

        $profileUsesCount = null;

        if (array_key_exists($profile->getLogin(), static::$runtimeCacheForUsedCouponsCount)) {
            $profileUsesCount = static::$runtimeCacheForUsedCouponsCount[$profile->getLogin()];
        } else {
            $profileUsesCount = $this->getUsedCoupons()->filter(
                function($usedCoupon) use ($profile) {
                    $orderProfileIdentificator = $usedCoupon->getOrder()->getProfile()
                        ? $usedCoupon->getOrder()->getProfile()->getLogin()
                        : null;

                    $currentProfileIdentificator = $profile->getLogin();

                    return $orderProfileIdentificator
                        && $currentProfileIdentificator
                        && $orderProfileIdentificator === $currentProfileIdentificator;
                }
            )->count();

            static::$runtimeCacheForUsedCouponsCount[$profile->getLogin()] = $profileUsesCount;
        }

        if ($inOrder) {
            $profileUsesCount -= 1;
        }

        if ($this->getUsesLimitPerUser() <= $profileUsesCount) {
            $this->throwCompatibilityException(
                '',
                'Sorry, the coupon use limit has been reached'
            );
        }
    }

    // }}}

    // {{{ Coupons conflicts

    /**
     * Check if coupon is unique within an order
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return boolean
     */
    public function checkUnique(\XLite\Model\Order $order)
    {
        if ($order->containsCoupon($this)) {
            $this->throwCompatibilityException(
                '',
                'You have already used the coupon'
            );
        }

        return true;
    }

    /**
     * Check coupon usages
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkConflictsWithCoupons(\XLite\Model\Order $order)
    {
        if (!$order->containsCoupon($this)) {
            if ($this->getSingleUse() && $order->getUsedCoupons()->count()) {
                $this->throwCompatibilityException(
                    static::ERROR_SINGLE_USE,
                    'This coupon cannot be combined with other coupons'
                );
            }

            if (!$this->getSingleUse() && $order->hasSingleUseCoupon()) {
                $this->throwCompatibilityException(
                    static::ERROR_SINGLE_USE2,
                    'Sorry, this coupon cannot be combined with the coupon already applied. Revome the previously applied coupon and try again.'
                );
            }
        }
    }

    // }}}

    // {{{ Total

    /**
     * Check order total
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkOrderTotal(\XLite\Model\Order $order)
    {
        $total = $this->getOrderTotal($order);
        $currency = $order->getCurrency();

        $rangeBegin = $this->getTotalRangeBegin();
        $rangeEnd = $this->getTotalRangeEnd();

        $rangeBeginValid = 0.0 === $rangeBegin || $rangeBegin <= $total;
        $rangeEndValid = 0.0 === $rangeEnd || $rangeEnd >= $total;

        if (!$rangeBeginValid && !$rangeEndValid) {
            $this->throwCompatibilityException(
                static::ERROR_TOTAL,
                'To use the coupon, your order subtotal must be between X and Y',
                array(
                    'min' => $currency->formatValue($rangeBegin),
                    'max' => $currency->formatValue($rangeEnd),
                )
            );
        } elseif (!$rangeBeginValid) {
            $this->throwCompatibilityException(
                static::ERROR_TOTAL,
                'To use the coupon, your order subtotal must be at least X',
                array('min' => $currency->formatValue($rangeBegin))
            );
        } elseif (!$rangeEndValid) {
            $this->throwCompatibilityException(
                static::ERROR_TOTAL,
                'To use the coupon, your order subtotal must not exceed Y',
                array('max' => $currency->formatValue($rangeEnd))
            );
        }
    }

    // }}}

    // {{{ Category

    /**
     * Check coupon category
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkCategory(\XLite\Model\Order $order)
    {
        if ($this->getCategories()->count()) {
            $found = false;

            foreach ($order->getItems() as $item) {
                foreach ($item->getProduct()->getCategories() as $category) {
                    if ($this->getCategories()->contains($category)) {
                        $found = true;

                        break;
                    }
                }

                if ($found) {
                    break;
                }
            }

            if (!$found) {
                $this->throwCompatibilityException(
                    '',
                    'Sorry, the coupon you entered cannot be applied to the items in your cart'
                );
            }
        }
    }

    // }}}

    // {{{ Membership

    /**
     * Check coupon membership
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkMembership(\XLite\Model\Order $order)
    {
        if ($this->getMemberships()->count()
            && $order->getProfile()
            && !$this->getMemberships()->contains($order->getProfile()->getMembership())
        ) {
            $this->throwCompatibilityException(
                '',
                'Sorry, the coupon you entered is not valid for your membership level. Contact the administrator'
            );
        }
    }

    // }}}

    // {{{ Product class

    /**
     * Check coupon product class
     *
     * @param \XLite\Model\Order $order Order
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function checkProductClass(\XLite\Model\Order $order)
    {
        if ($this->getProductClasses()->count()) {
            $found = false;
            foreach ($order->getItems() as $item) {
                if ($item->getProduct()->getProductClass()
                    && $this->getProductClasses()->contains($item->getProduct()->getProductClass())
                ) {
                    $found = true;

                    break;
                }
            }

            if (!$found) {
                $this->throwCompatibilityException(
                    '',
                    'Sorry, the coupon you entered cannot be applied to the items in your cart'
                );
            }
        }
    }

    // }}}

    /**
     * Throws exception
     *
     * @param string $code    Message params
     * @param string $message Message text
     * @param array  $params  Message params
     *
     * @throws \XLite\Module\CDev\Coupons\Core\CompatibilityException
     *
     * @return void
     */
    protected function throwCompatibilityException($code = '', $message = null, array $params = array())
    {
        throw new \XLite\Module\CDev\Coupons\Core\CompatibilityException($message, $params, $this, $code);
    }
}
