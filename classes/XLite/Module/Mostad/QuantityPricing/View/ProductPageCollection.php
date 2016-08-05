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

namespace XLite\Module\Mostad\QuantityPricing\View;

/**
 * @LC_Dependencies ("CDev\Wholesale", "NovaHorizons\WholesaleClasses", "XC\ProductVariants")
 */
class ProductPageCollection extends \XLite\View\ProductPageCollection implements \XLite\Base\IDecorator
{
    protected function getProductModifierTypes()
    {
        $result = parent::getProductModifierTypes();
        // If we already have wholesale skip it.
        if (empty($result['wholesale'])) {
            $quantity = \XLite\Core\Database::getRepo('XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice')
                ->getModifierTypesByProduct($this->getProduct());
            foreach ([$quantity] as $modifierType) {
                if (isset($modifierType)) {
                    foreach ($modifierType as $key => $value) {
                        $result[ $key ] = isset($result[ $key ])
                            ? $result[ $key ] || $value
                            : $value;
                    }
                }
            }
        }
        return $result;
    }


}