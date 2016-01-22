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

namespace XLite\Model\Shipping;

/**
 * Shipping markup model
 *
 * @Entity (repositoryClass="XLite\Model\Repo\Shipping\Markup")
 * @Table (name="shipping_markups",
 *      indexes={
 *          @Index (name="rate", columns={"method_id","zone_id","min_weight","min_total","min_items"}),
 *          @Index (name="max_weight", columns={"max_weight"}),
 *          @Index (name="max_total", columns={"max_total"}),
 *          @Index (name="max_items", columns={"max_items"}),
 *          @Index (name="markup_flat", columns={"markup_flat"}),
 *          @Index (name="markup_per_item", columns={"markup_per_item"}),
 *          @Index (name="markup_percent", columns={"markup_percent"}),
 *          @Index (name="markup_per_weight", columns={"markup_per_weight"})
 *      }
 * )
 */
class Markup extends \XLite\Model\AEntity
{
    const INFINITY_VALUE = 999999999;

    /**
     * A unique ID of the markup
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column (type="integer")
     */
    protected $markup_id;

    /**
     * Markup condition: min weight of products in the order
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $min_weight = 0;

    /**
     * Markup condition: max weight of products in the order
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $max_weight = self::INFINITY_VALUE;

    /**
     * Markup condition: min order subtotal
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $min_total = 0;

    /**
     * Markup condition: max order subtotal
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $max_total = self::INFINITY_VALUE;

    /**
     * Markup condition: min product items in the order
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=0)
     */
    protected $min_items = 0;

    /**
     * Markup condition: max product items in the order
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=0)
     */
    protected $max_items = self::INFINITY_VALUE;

    /**
     * Markup value: flat rate value
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $markup_flat = 0;

    /**
     * Markup value: percent value
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $markup_percent = 0;

    /**
     * Markup value: flat rate value per product item
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $markup_per_item = 0;

    /**
     * Markup value: flat rate value per weight unit
     *
     * @var float
     *
     * @Column (type="decimal", precision=14, scale=2)
     */
    protected $markup_per_weight = 0;

    /**
     * Shipping method (relation)
     *
     * @var \XLite\Model\Shipping\Method
     *
     * @ManyToOne  (targetEntity="XLite\Model\Shipping\Method", inversedBy="shipping_markups")
     * @JoinColumn (name="method_id", referencedColumnName="method_id", onDelete="CASCADE")
     */
    protected $shipping_method;

    /**
     * Zone (relation)
     *
     * @var \XLite\Model\Zone
     *
     * @ManyToOne  (targetEntity="XLite\Model\Zone", inversedBy="shipping_markups", cascade={"detach", "merge", "persist"})
     * @JoinColumn (name="zone_id", referencedColumnName="zone_id", onDelete="CASCADE")
     */
    protected $zone;

    /**
     * Calculated markup value
     *
     * @var float
     */
    protected $markupValue = 0;

    /**
     * getMarkupValue
     *
     * @return float
     */
    public function getMarkupValue()
    {
        return $this->markupValue;
    }

    /**
     * setMarkupValue
     *
     * @param integer $value Markup value
     *
     * @return void
     */
    public function setMarkupValue($value)
    {
        $this->markupValue = $value;
    }

    /**
     * Has rates
     *
     * @return boolean
     */
    public function hasRates()
    {
        return true;
    }

    /**
     * Returns weight range
     *
     * @return array
     */
    public function getWeightRange()
    {
        return array(
            $this->getMinWeight(),
            $this->getMaxWeight() == static::INFINITY_VALUE ? html_entity_decode('&#x221E;') : $this->getMaxWeight()
        );
    }

    /**
     * Set weight range
     *
     * @param array $value value
     *
     * @return array
     */
    public function setWeightRange($value)
    {
        if (is_array($value)) {
            $this->setMinWeight($value[0]);
            $this->setMaxWeight($value[1] === html_entity_decode('&#x221E;') ? static::INFINITY_VALUE : $value[1]);
        }
    }

    /**
     * Returns subtotal range
     *
     * @return array
     */
    public function getSubtotalRange()
    {
        return array(
            $this->getMinTotal(),
            $this->getMaxTotal() == static::INFINITY_VALUE ? html_entity_decode('&#x221E;') : $this->getMaxTotal()
        );
    }

    /**
     * Set subtotal range
     *
     * @param array $value value
     *
     * @return array
     */
    public function setSubtotalRange($value)
    {
        if (is_array($value)) {
            $this->setMinTotal($value[0]);
            $this->setMaxTotal($value[1] === html_entity_decode('&#x221E;') ? static::INFINITY_VALUE : $value[1]);
        }
    }

    /**
     * Returns items range
     *
     * @return array
     */
    public function getItemsRange()
    {
        return array(
            $this->getMinItems(),
            $this->getMaxItems() == static::INFINITY_VALUE ? html_entity_decode('&#x221E;') : $this->getMaxItems()
        );
    }

    /**
     * Set items range
     *
     * @param array $value value
     *
     * @return array
     */
    public function setItemsRange($value)
    {
        if (is_array($value)) {
            $this->setMinItems($value[0]);
            $this->setMaxItems($value[1] === html_entity_decode('&#x221E;') ? static::INFINITY_VALUE : $value[1]);
        }
    }
}
