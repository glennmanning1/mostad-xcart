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

namespace XLite\Module\CDev\Wholesale\Model;

/**
 * Product
 */
class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * Storage of current wholesale quantity according to the clear price will be calculated
     *
     * @var integer
     */
    protected $wholesaleQuantity = 0;

    /**
     * Min quantities
     *
     * @var array()
     */
    protected $minQuantities = array();

    /**
     * Wholesale membership
     *
     * @var   \XLite\Model\Memberhsip
     */
    protected $wholesaleMembership;

    /**
     * Wholesale quantity setter
     *
     * @param integer $value
     *
     * @return void
     */
    public function setWholesaleQuantity($value)
    {
        $this->wholesaleQuantity = $value;
    }

    /**
     * Wholesale quantity getter
     *
     * @return integer
     */
    public function getWholesaleQuantity()
    {
        return $this->wholesaleQuantity;
    }

    /**
     * Set wholesale membership
     *
     * @param \XLite\Model\Membership|boolean $membership Membership
     *
     * @return void
     */
    public function setWholesaleMembership($membership)
    {
        $this->wholesaleMembership = $membership;
    }

    /**
     * Get wholesale membership
     *
     * @return \XLite\Model\Membership
     */
    public function getWholesaleMembership()
    {
        return $this->wholesaleMembership;
    }

    /**
     * Get minimum product quantity available to customer to purchase
     *
     * @param \XLite\Model\Membership $membership Customer's membership OPTIONAL
     *
     * @return integer
     */
    public function getMinQuantity($membership = null)
    {
        $id = $membership ? $membership->getMembershipId() : 0;

        if (!isset($this->minQuantities[$id])) {
            $minQuantity = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\MinQuantity')
                ->getMinQuantity(
                    $this,
                    $membership
                );

            $this->minQuantities[$id] = isset($minQuantity) ? $minQuantity->getQuantity() : 1;

        }

        return $this->minQuantities[$id];
    }

    /**
     * Check if wholesale prices are enabled for the specified product.
     * Return true if product is not on sale (Sale module)
     *
     * @return boolean
     */
    public function isWholesalePricesEnabled()
    {
        return !\XLite\Core\Operator::isClassExists('\XLite\Module\CDev\Sale\Main')
            || !$this->getParticipateSale();
    }

    /**
     * Override clear price of product
     *
     * @return float
     */
    public function getClearPrice()
    {
        $price = parent::getClearPrice();

        if ($this->isWholesalePricesEnabled() && $this->isPersistent()) {
            $wholesalePrice = $this->getWholesalePrice($this->getCurrentMembership());
            if (!is_null($wholesalePrice)) {
                $price = $wholesalePrice;
            }
        }

        return $price;
    }

    /**
     * Return base price
     *
     * @return float
     */
    public function getBasePrice()
    {
        return parent::getClearPrice();
    }

    /**
     * Override clear price of product
     *
     * @return float
     */
    public function getWholesalePrice($membership)
    {
        return \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\WholesalePrice')->getPrice(
            $this,
            $this->getWholesaleQuantity() > $this->getMinQuantity($membership) ? $this->getWholesaleQuantity() : $this->getMinQuantity($membership),
            $membership
        );
    }

    /**
     * Clone
     *
     * @return \XLite\Model\AEntity
     */
    public function cloneEntity()
    {
        $newProduct = parent::cloneEntity();
        $this->cloneQuantity($newProduct);
        $this->cloneMembership($newProduct);

        return $newProduct;
    }

    /**
     * Return current membership
     *
     * @return \XLite\Model\Membership
     */
    public function getCurrentMembership()
    {
        if ($this->getWholesaleMembership() !== null) {
            $membership = $this->getWholesaleMembership() ?: null;

        } elseif (defined('LC_CACHE_BUILDING') && LC_CACHE_BUILDING) {
            $membership = \XLite\Core\Auth::getInstance()->getProfile()
                ? \XLite\Core\Auth::getInstance()->getProfile()->getMembership()
                : null;

        } elseif (\XLite::getController() instanceOf \XLite\Controller\ACustomer) {
            $membership = \XLite::getController()->getCart()->getProfile()->getMembership();

        } else{
            $membership = \XLite\Core\Auth::getInstance()->getProfile()
                ? \XLite\Core\Auth::getInstance()->getProfile()->getMembership()
                : null;
        }

        return $membership;
    }

    /**
     * Clone quantity (used in cloneEntity() method)
     *
     * @param \XLite\Model\Product $newProduct
     *
     * @return void
     */
    protected function cloneQuantity($newProduct)
    {
        foreach (\XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\MinQuantity')->findBy(array('product' => $this)) as $quantity) {
            $newQuantity = $quantity->cloneEntity();
            $newQuantity->setProduct($newProduct);
            $newQuantity->setMembership($quantity->getMembership());
            $newQuantity->update();
        }
    }

    /**
     * Clone membership (used in cloneEntity() method)
     *
     * @param \XLite\Model\Product $newProduct
     *
     * @return void
     */
    protected function cloneMembership($newProduct)
    {
        foreach (\XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\WholesalePrice')->findBy(array('product' => $this)) as $price) {
            $newPrice = $price->cloneEntity();
            $newPrice->setProduct($newProduct);
            $newPrice->setMembership($price->getMembership());
            $newPrice->update();
        }
    }
}
