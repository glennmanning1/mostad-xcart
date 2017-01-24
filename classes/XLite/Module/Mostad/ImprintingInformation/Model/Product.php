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

namespace XLite\Module\Mostad\ImprintingInformation\Model;

use XLite\Core\Database;
use XLite\Model\Attribute;

abstract class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{
    /**
     * Get all attributes
     *
     * @return array
     */
    public function getAllAttributes()
    {
        $result = [];

        foreach (Attribute::getTypes() as $type => $name) {
            $class  = Attribute::getAttributeValueClass($type);
            $result = array_merge(
                $result,
                Database::getRepo($class)->findAllAttributes($this)
            );
        }

        return $result;
    }

    public function needsImprinting()
    {
        $result = [];

        $attributes = \XLite\Core\Database::getRepo('XLite\Model\Attribute')->findImprintingAttribute($this);

        foreach (Attribute::getTypes() as $type => $name) {
            $class  = Attribute::getAttributeValueClass($type);
            $result = array_merge(
                $result,
                Database::getRepo($class)->findAllImprintingAttributeValues($this, $attributes)
            );
        }

        foreach ($result as $attributeValue) {
            if (stripos($attributeValue->getAttribute()->getName(), 'imprint') !== false && ($attributeValue->getValue() === true || stripos($attributeValue->getValue(), 'yes') !== false)) {
                return true;
            }

            if (stripos($attributeValue->getAttribute()->getName(), 'imprint') !== false && ($attributeValue->getValue() === false || stripos($attributeValue->getValue(), 'no') !== false)) {
                return false;
            }
        }

        return false;
    }

}