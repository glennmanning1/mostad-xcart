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
 * Quantity set items list
 */
class QuantitySet extends \XLite\View\ItemsList\Model\Table
{
    /**
     * @inheritdoc
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/QSL/AdvancedQuantity/items_list/quantity_set/style.css';

        return $list;
    }

    /**
     * @inheritdoc
     */
    public function getDataPrefix()
    {
        return 'quantity_set';
    }

    /**
     * @inheritdoc
     */
    public function getCreateDataPrefix()
    {
        return 'new_quantity_set';
    }

    /**
     * @inheritdoc
     */
    public function getRemoveDataPrefix()
    {
        return 'quantity_set_delete';
    }

    /**
     * @inheritdoc
     */
    protected function defineColumns()
    {
        $result = array(
            'quantity' => array(
                static::COLUMN_CLASS     => 'XLite\Module\QSL\AdvancedQuantity\View\FormField\Inline\Input\Text\Quantity',
                static::COLUMN_MAIN      => true,
                static::COLUMN_NO_WRAP   => true,
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_PARAMS    => array(
                    'required' => true,
                    'min'      => $this->getProduct()->getAbsoluteMinimumQuantity(),
                ),
                static::COLUMN_ORDERBY   => 100,
                ''
            ),
        );

        if (count($this->getProduct()->getQuantityUnits()) > 0) {
            $result['quantity_unit'] = array(
                static::COLUMN_CLASS     => 'XLite\Module\QSL\AdvancedQuantity\View\FormField\Inline\Select\QuantityUnit',
                static::COLUMN_NO_WRAP   => true,
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_PARAMS    => array(
                    'required' => true,
                    'product'  => $this->getProduct(),
                ),
                static::COLUMN_ORDERBY   => 200,
            );
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantitySet';
    }

    /**
     * @inheritdoc
     */
    protected function getCreateButtonLabel()
    {
        return 'Add quantity';
    }

    /**
     * @inheritdoc
     */
    protected function isInlineCreation()
    {
        return static::CREATE_INLINE_TOP;
    }

    // {{{ Behaviors

    /**
     * @inheritdoc
     */
    protected function isRemoved()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function getSortableType()
    {
        return static::SORT_TYPE_MOVE;
    }

    // }}}

    /**
     * @inheritdoc
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' quantity-sets-list';
    }

    /**
     * @inheritdoc
     */
    protected function getPanelClass()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();

        $entity->setProduct($this->getProduct());

        return $entity;
    }

    /**
     * @inheritdoc
     */
    protected function isPagerVisible()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        return $countOnly
            ? count($this->getProduct()->getQuantitySets())
            : $this->getProduct()->getQuantitySets();
    }

    /**
     * @inheritdoc
     */
    protected function isEmptyListTemplateVisible()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getCreateMessage($count)
    {
        return \XLite\Core\Translation::lbl('X quantities have been added', array('count' => $count));
    }

    /**
     * @inheritdoc
     */
    protected function getRemoveMessage($count)
    {
        return \XLite\Core\Translation::lbl('X quantities have been removed', array('count' => $count));
    }

}
