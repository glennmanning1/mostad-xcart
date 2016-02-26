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

namespace XLite\Module\NovaHorizons\CategoryWholesale\Model;

/**
 * Wholesale price model (product)
 *
 * @Entity (repositoryClass="\XLite\Module\Novahorizons\CategoryWholesale\Model\Repo\CategoryWholesalePrice")
 * @Table  (name="category_wholesale_prices",
 *      indexes={
 *          @Index (name="range", columns={"category_id", "membership_id", "quantityRangeBegin", "quantityRangeEnd"})
 *      }
 * )
 */
class CategoryWholesalePrice extends \XLite\Module\CDev\Wholesale\Model\Base\AWholesalePrice
{
    /**
     * Relation to a product entity
     *
     * @var \XLite\Model\Category
     *
     * @ManyToOne  (targetEntity="XLite\Model\Category")
     * @JoinColumn (name="category_id", referencedColumnName="category_id", onDelete="CASCADE")
     */
    protected $category;

    /**
     * Return owner
     *
     * @return \XLite\Model\Product
     */
    public function getOwner()
    {
        return $this->getCategory();
    }

    /**
     * Set owner
     *
     * @param \XLite\Model\Product $owner Owner
     *
     * @return void
     */
    public function setOwner($owner)
    {
        return $this->setCategory($owner);
    }

    public function isDefaultPrice()
    {
        return false;
    }

}