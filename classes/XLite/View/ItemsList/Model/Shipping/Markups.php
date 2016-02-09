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

namespace XLite\View\ItemsList\Model\Shipping;

/**
 * Shipping rates list
 */
class Markups extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Current shipping zone (runtime cache)
     *
     * @var \XLite\Model\Zone
     */
    protected $currentShippingZone;

    /**
     * Get a list of CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/' . $this->getPageBodyDir() . '/shipping/markups/style.css';

        return $list;
    }

    /**
     * Get a list of JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/' . $this->getPageBodyDir() . '/shipping/markups/controller.js';

        return $list;
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Model\Shipping\Markup';
    }

    /**
     * Get JS handler class name (used for pagination)
     *
     * @return string
     */
    protected function getJSHandlerClassName()
    {
        return 'ShippingMarkupItemsList';
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'subtotalRange' => array(
                static::COLUMN_NAME => static::t('Subtotal range'),
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text\PriceRange',
                static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.header.tpl',
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_ORDERBY => 100,
            ),
            'weightRange' => array(
                static::COLUMN_NAME => static::t('Weight range'),
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text\FloatRange',
                static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.header.tpl',
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_ORDERBY => 200,
            ),
            'itemsRange' => array(
                static::COLUMN_NAME => static::t('Items range'),
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text\IntegerRange',
                static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.header.tpl',
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_ORDERBY => 300,
            ),
            'markup_flat' => array(
                static::COLUMN_NAME => static::t('flat rate'),
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text\Price',
                static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.header.tpl',
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_ORDERBY => 400,
            ),
            'markup_per_item' => array(
                static::COLUMN_NAME => static::t('per item'),
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text\Price',
                static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.header.tpl',
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_ORDERBY => 500,
            ),
            'markup_percent' => array(
                static::COLUMN_NAME => static::t('%'),
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text\Float',
                static::COLUMN_PARAMS => array(
                    \XLite\View\FormField\Input\Text\Base\Numeric::PARAM_MOUSE_WHEEL_ICON => false,
                ),
                static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.header.tpl',
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_ORDERBY => 600,
            ),
            'markup_per_weight' => array(
                static::COLUMN_NAME => static::t('per weight unit'),
                static::COLUMN_CLASS => 'XLite\View\FormField\Inline\Input\Text\Price',
                static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.header.tpl',
                static::COLUMN_EDIT_ONLY => true,
                static::COLUMN_ORDERBY => 700,
            ),
        );
    }

    /**
     * Create entity
     *
     * @return \XLite\Model\AEntity
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();
        $entity->setZone($this->getCurrentShippingZone());
        if ($this->getModelForm()) {
            $entity->setShippingMethod($this->getModelForm()->getModelObject());
        }

        return $entity;
    }

    /**
     * Get create button label
     *
     * @return string
     */
    protected function getCreateButtonLabel()
    {
        return '+';
    }

    /**
     * Creation button position
     *
     * @return integer
     */
    protected function isCreation()
    {
        return static::CREATE_INLINE_BOTTOM;
    }

    /**
     * Inline creation mechanism position
     *
     * @return integer
     */
    protected function isInlineCreation()
    {
        return static::CREATE_INLINE_BOTTOM;
    }

    /**
     * Mark list as removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return true;
    }

    /**
     * Check if the simple class is used for widget displaying
     *
     * @param array $column
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function isClassColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        return isset($column[static::COLUMN_CLASS]);
    }

    /**
     * Check if the simple class is used for widget displaying
     *
     * @param array $column Column
     *
     * @return boolean
     */
    protected function isCreateTemplateColumnVisible(array $column)
    {
        return isset($column[static::COLUMN_TEMPLATE]);
    }

    /**
     * Get create line columns
     *
     * @return array
     */
    protected function getCreateColumns()
    {
        $list = parent::getCreateColumns();
        $list[] = array(
            static::COLUMN_CODE => 'formula',
            static::COLUMN_NAME => '',
            static::COLUMN_SERVICE => true,
            static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.formula.tpl'
        );

        return $list;
    }

    /**
     * Get preprocessed columns structure
     *
     * @return array
     */
    protected function getColumns()
    {
        $list = parent::getColumns();
        $list[] = array(
            static::COLUMN_CODE => 'formula',
            static::COLUMN_NAME => '',
            static::COLUMN_SERVICE => true,
            static::COLUMN_TEMPLATE => 'items_list/model/table/shipping/markups/cell.formula.tpl'
        );

        return $list;
    }

    /**
     * Define line class as list of names
     *
     * @param integer              $index  Line index
     * @param \XLite\Model\AEntity $entity Line model OPTIONAL
     *
     * @return array
     */
    protected function defineLineClass($index, \XLite\Model\AEntity $entity = null)
    {
        $result = parent::defineLineClass($index, $entity);
        if ($entity->getZone()) {
            $result[] = 'zone-' . $entity->getZone()->getZoneId();
        }

        return $result;
    }


    /**
     * Returns current shipping zone
     *
     * @return \XLite\Model\Zone
     */
    protected function getCurrentShippingZone()
    {
        if (null === $this->currentShippingZone) {
            $zoneId = \XLite\Core\Request::getInstance()->shippingZone ?: $this->getShippingZone();
            $this->currentShippingZone = \XLite\Core\Database::getRepo('XLite\Model\Zone')->find($zoneId);
        }

        return $this->currentShippingZone;
    }

    /**
     * Get page data for update
     *
     * @return array
     */
    protected function getPageDataForUpdate()
    {
        $list = array();
        $zone = $this->getCurrentShippingZone();
        foreach (parent::getPageDataForUpdate() as $entity) {
            if ($zone && $entity->getZone() && $zone->getZoneId() === $entity->getZone()->getZoneId()) {
                $list[] = $entity;
            }
        }

        return $list;
    }

    // {{{ Search

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();
        $result->methodId = \XLite\Core\Request::getInstance()->methodId;
        $result->shippingZone = \XLite\Core\Request::getInstance()->shippingZone ?: $this->getShippingZone();

        return $result;
    }

    // }}}

    /**
     * Return class name for the list pager
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return 'XLite\View\Pager\Admin\Model\Shipping\Markup';
    }

    /**
     * Check - table header is visible or not
     *
     * @return boolean
     */
    protected function isTableHeaderVisible()
    {
        return false;
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' shipping-markups';
    }

    /**
     * Check - sticky panel is visible or not
     *
     * @return boolean
     */
    protected function isPanelVisible()
    {
        return false;
    }

    /**
     * Get URL common parameters
     *
     * @return array
     */
    protected function getCommonParams()
    {
        $this->commonParams = parent::getCommonParams();
        $this->commonParams['methodId'] = \XLite\Core\Request::getInstance()->methodId;
        $this->commonParams['shippingZone'] = \XLite\Core\Request::getInstance()->shippingZone ?: $this->getShippingZone();

        return $this->commonParams;
    }

    /**
     * @return integer
     */
    protected function getShippingZone()
    {
        if ($this->getModelForm()) {
            $method = $this->getModelForm()->getModelObject();

            $zones = \XLite\Core\Database::getRepo('XLite\Model\Zone')->getOfflineShippingZones($method);
            $list = array_keys($zones[0] ? $zones[0] : ($zones[1] ? $zones[1] : array(1)));

            return $list[0];
        }

        return 1;
    }
}
