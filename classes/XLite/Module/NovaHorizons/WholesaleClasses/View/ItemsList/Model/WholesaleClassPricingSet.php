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

namespace XLite\Module\NovaHorizons\WholesaleClasses\View\ItemsList\Model;


class WholesaleClassPricingSet extends \XLite\View\ItemsList\Model\Table
{

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet';
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'name' => array(
                static::COLUMN_CLASS   => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_PARAMS       => array('required' => true),
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Name'),
                static::COLUMN_ORDERBY => 100,

            ),
            'class' => [
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Product class'),
                static::COLUMN_CLASS   => 'XLite\Module\NovaHorizons\WholesaleClasses\View\FormField\Inline\Select\Model\ProductClass',
                static::COLUMN_ORDERBY => 200,
            ],
            'pricing' => array(
                static::COLUMN_TEMPLATE      => 'modules/NovaHorizons/WholesaleClasses/page/wholesale_class_pricing_set/parts/edit_pricing.tpl',
                static::COLUMN_HEAD_TEMPLATE => 'modules/NovaHorizons/WholesaleClasses/page/wholesale_class_pricing_set/parts/edit_pricing.tpl',
                static::COLUMN_ORDERBY       => 300,
            ),
        );
    }

    protected function isSwitchable()
    {
        return true;
    }

    protected function isRemoved()
    {
        return true;
    }

    protected function isInlineCreation()
    {
        return static::CREATE_INLINE_TOP;
    }

    protected function getCreateURL()
    {
        return \XLite\Core\Converter::buildURL('wholesale_class_pricing_set');
    }

    protected function getEditLinkLabel($entity)
    {
        return static::t('Edit prices');
    }

    protected function getEditURL($entity)
    {
        return $entity && $entity->getId()
            ? $this->buildURL('wholesale_class_price', '', array('pricing_set_id' => $entity->getId()))
            : $this->buildURL('wholesale_class_price');
    }
}