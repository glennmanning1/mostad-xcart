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

namespace XLite\Module\QSL\AdvancedQuantity\Model\Product;

/**
 * Quantity unit
 *
 * @Entity
 * @Table (name="qsl_product_quantity_units")
 */
class QuantityUnit extends \XLite\Model\Base\I18n
{

    /**
     * Unique ID
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Multiplier
     *
     * @var float
     *
     * @Column (type="float")
     */
    protected $multiplier = 1;

    /**
     * Position
     *
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $position = 0;

    /**
     * Product
     *
     * @var \XLite\Model\Product
     *
     * @ManyToOne  (targetEntity="XLite\Model\Product", inversedBy="quantity_units")
     * @JoinColumn (name="product_id", referencedColumnName="product_id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * Get formatter amount
     *
     * @param float $quantity Quantity
     *
     * @return string
     */
    public function formatAmount($quantity)
    {
        return \XLite\Core\Translation::lbl(
            'qty / unit',
            array(
                'quantity' => $quantity,
                'unit'     => $this->getName(),
            )
        );
    }

    /**
     * Calculate product price
     *
     * @param \XLite\Model\Product $product Product
     * @param float                $base    Base price OPTIONAL
     *
     * @return float
     */
    public function calculatePrice(\XLite\Model\Product $product, $base = null)
    {
        return $this->getMultiplier() * (isset($base) ? $base : $product->getQuantityUnitBasePrice());
    }

    /**
     * @inheritdoc
     */
    public function prepareEntityBeforeCommit($type)
    {
        parent::prepareEntityBeforeCommit($type);

        if ($type == static::ACTION_DELETE) {
            $repo = \XLite\Core\Database::getRepo('XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantitySet');
            foreach ($this->getProduct()->getQuantitySets() as $set) {
                if ($set->getQuantityUnit() && $set->getQuantityUnit()->getId() == $this->getId()) {
                    $repo->delete($set, false);
                    $this->getProduct()->getQuantitySets()->removeElement($set);
                }
            }
        }
    }

} 