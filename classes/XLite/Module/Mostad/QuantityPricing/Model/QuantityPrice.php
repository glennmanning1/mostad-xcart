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

namespace XLite\Module\Mostad\QuantityPricing\Model;


/**
 * @Entity
 * @Table (name="quantity_price")
 */

class QuantityPrice extends \XLite\Model\AEntity
{
    const TYPE_PRODUCT = 'product';
    const TYPE_PRODUCT_VARIANT = 'productVariant';
    const TYPE_WHOLESALE_CLASS = 'wholesaleClass';

    /**
     * @var  integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer")
     */
    protected $id;

    /**
     * @var \XLite\Model\AEntity
     */
    protected $model;

    /**
     * @var integer
     *
     * @Column (name="model_id", type="integer")
     */
    protected $modelId;

    /**
     * @var string
     *
     * @Column (name="model_type", type="string", length=255)
     */
    protected $modelType;

    /**
     * @var integer
     *
     * @Column (type="integer")
     */
    protected $quantity;

    /**
     * @var float
     *
     * @Column (type="float")
     */
    protected $price;

    /**
     * @param $model
     *
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        $this->setModelId($model->getId());

        $class = get_class($model);

        $class = str_replace('XLite\Model\Proxy\__CG__\\', '', $class);

        $this->setModelType($class);

        return $this;
    }

    public function getDisplayPrice()
    {
        return $this->price;
    }

    public function getQuantityRangeBegin()
    {
        return $this->quantity;
    }

    public function getQuantityRangeEnd()
    {
        return $this->quantity;
    }

    public function getSavePriceValue()
    {
        $basePrice = $this->getModel()->getBasePrice();
        $qtyPrice = $this->price / $this->quantity;

        if ($basePrice > 0 && $qtyPrice > 0 && $basePrice != $qtyPrice) {
            return number_format(($qtyPrice/ $basePrice) * 100);
        }

        return 0;
    }
}