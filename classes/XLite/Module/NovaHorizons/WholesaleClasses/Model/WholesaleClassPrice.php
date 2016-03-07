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

namespace XLite\Module\NovaHorizons\WholesaleClasses\Model;

/**
 * Wholesale price model (set)
 *
 * @Entity (repositoryClass="\XLite\Module\NovaHorizons\WholesaleClasses\Model\Repo\WholesaleClassPrice")
 * @Table  (name="wholesale_classes_price",
 *      indexes={
 *          @Index (name="range", columns={"set_id", "membership_id", "quantityRangeBegin", "quantityRangeEnd"})
 *      }
 * )
 */
class WholesaleClassPrice extends \XLite\Module\CDev\Wholesale\Model\Base\AWholesalePrice
{
    /**
     * @var \XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet
     *
     * @ManyToOne(targetEntity="XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet")
     * @JoinColumn(name="set_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $set;

    /**
     * Return owner
     *
     * @return mixed
     */
    public function getOwner()
    {
        $this->getSet();
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
        return $this->setSet($owner);
    }

    public function isDefaultPrice()
    {
        return false;
    }

}