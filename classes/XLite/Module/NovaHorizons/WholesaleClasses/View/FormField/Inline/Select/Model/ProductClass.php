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

namespace XLite\Module\NovaHorizons\WholesaleClasses\View\FormField\Inline\Select\Model;


class ProductClass extends \XLite\View\FormField\Inline\Base\Single
{
    /**
     */
    const DEFAULT_TEXT = 'Please choose a product class';

    /**
     * Preprocess value before save
     *
     * @param mixed $value Value
     *
     * @return mixed
     */
    protected function preprocessValueBeforeSave($value)
    {
        return \XLite\Core\Database::getRepo('XLite\Model\ProductClass')->find(parent::preprocessValueBeforeSave($value));
    }

    /**
     * @return bool
     */
    protected function isEditable()
    {
        return parent::isEditable() && true;
    }

    /**
     * @return null
     */
    protected function getProductClassName()
    {
        return $this->getProductClass()
            ? $this->getProductClass()->getName()
            :null;
    }

    /**
     * @return string
     */
    protected function getDefaultText()
    {
        return self::DEFAULT_TEXT;
    }


    /**
     * Define form field
     *
     * @return string
     */
    protected function defineFieldClass()
    {
        return 'XLite\Module\NovaHorizons\WholesaleClasses\View\FormField\SelectProductClass';
    }

    /**
     * @return string
     */
    protected function getViewTemplate()
    {
        $parentTemplate = parent::getViewTemplate();

        $ourTemplate = 'modules/NovaHorizons/WholesaleClasses/form_field/product_class_view.tpl';
        return $ourTemplate;
    }

    /**
     * @return null
     */
    protected function getEntityValue()
    {
        $value = parent::getEntityValue();

        return $value ? $value->getId() : null;
    }

    /**
     * @return \XLite\Model\AEntity
     */
    protected function getProductClass()
    {
        return $this->getEntity()->getClass();
    }
}