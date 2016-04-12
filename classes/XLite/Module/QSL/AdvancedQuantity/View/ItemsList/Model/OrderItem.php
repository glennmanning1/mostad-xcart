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

namespace XLite\Module\QSL\AdvancedQuantity\View\ItemsList\Model;

/**
 * Order items list
 */
class OrderItem extends \XLite\View\ItemsList\Model\OrderItem implements \XLite\Base\IDecorator
{

    /**
     * @inheritdoc
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/QSL/AdvancedQuantity/items_list/model/table/order_item/controller.js';

        return $list;
    }

    /**
     * @inheritdoc
     */
    protected function getOrderItemsDataFields()
    {
        $list = parent::getOrderItemsDataFields();
        $list[] = 'quantity_unit';

        return $list;
    }

    /**
     * @inheritdoc
     */
    protected function saveEntities()
    {
        $count = parent::saveEntities();

        $data = $this->getRequestData();

        foreach ($this->getPageDataForUpdate() as $entity) {
            $entityId = $entity->getItemId();
            if (isset($data['order_items'][$entityId]['amount']) && $entity->getQuantityUnit()) {
                $entity->setAmount($entity->getAmount() * $entity->getQuantityUnit()->getMultiplier());
            }
        }

        return $count;
    }

    /**
     * @inheritdoc
     */
    protected function changeItemAmountInStock($entity)
    {
        // Normalize quantity
        if (isset($this->orderItemsData[$entity->getItemId()]['amount'])) {
            $this->orderItemsData[$entity->getItemId()]['amount'] = $entity->getProduct()
                ->formatQuantity($this->orderItemsData[$entity->getItemId()]['amount']);
        }

        $amount = $entity->getSelectedAmount() ?: $entity->getAmount();

        if (
            isset($this->orderItemsData[$entity->getItemId()]['amount'])
            && $amount != $this->orderItemsData[$entity->getItemId()]['amount']
        ) {
            // Calculate amount to update stock: negative when qty was increased and positive when decreased
            $delta = $this->orderItemsData[$entity->getItemId()]['amount'] - $amount;

            // Update stock
            $entity->changeSelectedAmount($delta);
        }
    }

    /**
     * @inheritdoc
     */
    protected function postprocessInsertedEntity(\XLite\Model\AEntity $entity, array $line)
    {
        $result = parent::postprocessInsertedEntity($entity, $line);

        if ($result && !$entity->getQuantityUnit() && count($entity->getProduct()->getQuantityUnits()) > 0) {
            $entity->setQuantityUnit($entity->getProduct()->getQuantityUnits()->first());
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function defineColumns()
    {
        $result = parent::defineColumns();
        $result['quantity_unit'] = array(
            static::COLUMN_NAME    => static::t('Quantity unit'),
            static::COLUMN_CLASS   => 'XLite\Module\QSL\AdvancedQuantity\View\FormField\Inline\Select\QuantityUnit',
            static::COLUMN_NO_WRAP => true,
            static::COLUMN_ORDERBY => 350,
        );

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function preprocessFieldParams(array $column, \XLite\Model\AEntity $entity)
    {
        $result = parent::preprocessFieldParams($column, $entity);
        if ($column[static::COLUMN_CODE] == 'quantity_unit') {
            $result['product'] = $entity->getProduct();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function isClassColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        return parent::isClassColumnVisible($column, $entity)
            && ($column[static::COLUMN_CODE] != 'quantity_unit' || count($entity->getProduct()->getQuantityUnits()) > 0);
    }

    /**
     * Get quantity unit
     *
     * @param \XLite\Model\OrderItem $entity OrderItem entity
     *
     * @return integer
     */
    protected function getOrderItemDataFieldValueQuantityUnit(\XLite\Model\OrderItem $entity)
    {
        return $entity->getQuantityUnit()
            ? $entity->getQuantityUnit()->getId()
            : null;
    }

    /**
     * Get quantity unit value
     *
     * @param \XLite\Model\OrderItem $entity Order item
     *
     * @return integer
     */
    protected function getOrderItemDataFieldValueQuantity_unit(\XLite\Model\OrderItem $entity)
    {
        return $entity->getQuantityUnit()
            ? $entity->getQuantityUnit()->getId()
            : null;
    }
}
