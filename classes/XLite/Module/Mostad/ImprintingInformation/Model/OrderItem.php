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


class OrderItem extends \XLite\Model\OrderItem implements \XLite\Base\IDecorator
{

    public function needsImprinting()
    {
        foreach ($this->getAttributeValues() as $attributeValue) {
            if (stripos($attributeValue->getName(), 'imprint') !== false && ($attributeValue->getValue() === true || stripos($attributeValue->getValue(), 'yes') !== false)) {
                return true;
            }

            if (stripos($attributeValue->getName(), 'imprint') !== false && ($attributeValue->getValue() === false || stripos($attributeValue->getValue(), 'no') !== false)) {
                return false;
            }
        }
        
        return $this->getProduct()->needsImprinting();
    }

}