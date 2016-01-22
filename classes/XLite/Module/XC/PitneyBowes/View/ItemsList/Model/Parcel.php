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

namespace XLite\Module\XC\PitneyBowes\View\ItemsList\Model;

/**
 * Parcels items list
 */
class Parcel extends \XLite\View\ItemsList\Model\Table
{

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'orderItem' => array(
                static::COLUMN_CREATE_CLASS     => 'XLite\Module\XC\PitneyBowes\View\FormField\Inline\Select\ParcelItem',
                static::COLUMN_NAME => static::t('OrderItem'),
                static::COLUMN_NO_WRAP  => true,
                static::COLUMN_MAIN => true,
                static::COLUMN_PARAMS => array(
                    'required'  => true,
                    'order'   => $this->getOrder()
                ),
            ),
            'amount' => array(
                static::COLUMN_CLASS   => 'XLite\View\FormField\Inline\Input\Text\Integer',
                static::COLUMN_NAME => static::t('Amount'),
                static::COLUMN_MAIN => true,
                static::COLUMN_PARAMS        => array(
                    \XLite\View\FormField\Input\Text\Base\Numeric::PARAM_MIN              => 0,
                    \XLite\View\FormField\Input\Text\Base\Numeric::PARAM_MOUSE_WHEEL_CTRL => false
                ),
            ),
        );
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\XC\PitneyBowes\Model\ParcelItem';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' pb-parcel';
    }

    /**
     * Get create button label
     *
     * @return string
     */
    protected function getCreateButtonLabel()
    {
        return 'Add order item';
    }

    /**
     * Get order
     *
     * @param \XLite\Model\AEntity $entity Parcel item
     *
     * @return string
     */
    protected function getOrderItemColumnValue(\XLite\Model\AEntity $entity)
    {
        return $entity->getOrderItem()->getName();
    }

    /**
     * Create entity
     *
     * @return \XLite\Model\AEntity
     */
    protected function createEntity()
    {
        $parcelItem = parent::createEntity();

        $parcelItem->setPbParcel($this->getParcel());
        $this->getParcel()->addParcelItems($parcelItem);

        return $parcelItem;
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        $result->{\XLite\Module\XC\PitneyBowes\Model\Repo\ParcelItem::P_PARCEL} = $this->getParcel();

        return $result;
    }

    /**
     * Prepare field params for 
     *
     * @param array                $column
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function preprocessFieldParams(array $column, \XLite\Model\AEntity $entity)
    {
        $list = parent::preprocessFieldParams($column, $entity);

        $list[\XLite\View\FormField\Input\Text\Base\Numeric::PARAM_MAX]
            = $this->getOrder()->getPbOrder()->getAvailableAmount($entity->getOrderItem(), $this->getParcel());

        return $list;
    }
}