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

namespace XLite\Module\Mostad\QuantityPricing\View\ItemsList\Model;


/**
 * Class QuantityPrice
 * @package XLite\Module\Mostad\QuantityPricing\View\ItemsList\Model
 */
class QuantityPrice extends \XLite\View\ItemsList\Model\Table
{

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice';
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'quantity' => array(
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_NAME => \XLite\Core\Translation::lbl('Quantity'),
                static::COLUMN_ORDERBY => 100,
            ),
            'price'    => array(
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_NAME => \XLite\Core\Translation::lbl('Price'),
                static::COLUMN_ORDERBY => 200,
            ),
        );
    }

    /**
     * @return bool
     */
    protected function isRemoved()
    {
        return true;
    }

    /**
     * @return int
     */
    protected function isInlineCreation()
    {
        return static::CREATE_INLINE_TOP;
    }

    /**
     * @return string
     */
    protected function getCreateURL()
    {
        return \XLite\Core\Converter::buildUrl('quantity_pricing');
    }


    /**
     * createEntity
     *
     * @return \XLite\Model\Product
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();

        $entity->setModel($this->getObject());

        return $entity;
    }

    /**
     * @param \XLite\Core\CommonCell $cnd
     * @param bool $countOnly
     *
     * @return mixed
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_ID} = $this->getObject()->getId();
        $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_TYPE} = get_class($this->getObject());

        return \XLite\Core\Database::getRepo('XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice')
            ->search($cnd, $countOnly);
    }

}