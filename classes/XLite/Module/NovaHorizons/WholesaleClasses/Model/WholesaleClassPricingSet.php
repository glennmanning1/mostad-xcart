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
 * Class WholesaleClassPricingSet
 * @package XLite\Module\NovaHorizons\WholesaleClasses\Model
 * @Entity
 * @Table(name="wholesale_classes_pricing_set")
 */

class WholesaleClassPricingSet extends \XLite\Model\AEntity
{
    /**
     * @var int
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var boolean
     * @Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name = '';

    /**
     * @var \XLite\Model\ProductClass
     *
     * @ManyToOne(targetEntity="XLite\Model\ProductClass")
     * @JoinColumn(name="class_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $class;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @OneToMany(targetEntity="XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice", mappedBy="set")
     */
    protected $prices;

    protected $basePrice;

    public function __construct() {
        $this->prices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param $class
     */
    public function setClass($class)
    {
        if (!$class instanceof \XLite\Model\ProductClass) {
            $classId = $class;
            $class = new \XLite\Model\ProductClass();
            $class->setId($classId);
        }

        $this->class = $class;
    }
    
    public function getMinQuantity($membership = null)
    {
        return 1;
    }

    public function getBasePrice()
    {
        if ($this->basePrice) {
            return $this->basePrice;
        }
        $this->basePrice = 0.01;
        foreach ($this->getPrices() as $price) {
            if ($price->getPrice() > $this->basePrice) {
                $this->basePrice = $price->getPrice();
            }
        }

        return $this->basePrice;
    }

}