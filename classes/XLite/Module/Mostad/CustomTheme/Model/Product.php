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

namespace XLite\Module\Mostad\CustomTheme\Model;

/**
 * @LC_Dependencies("XC\ProductVariants", "QSL\AdvancedQuantity")
 */
class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{

    /**
     * Get public images
     *
     * @return array
     */
    public function getPublicImages()
    {
        $list = parent::getPublicImages();

        if ($this->isUseVariantImage()) {
            array_unshift($list, $this->getDefaultVariant()->getImage());
        }

        return $list;
    }
    
    /**
     * Get minimum product quantity available to customer to purchase
     *
     * @param \XLite\Model\Membership $membership Customer's membership OPTIONAL
     *
     * @return integer
     */
    public function getMinQuantity($membership = null)
    {
        $absoluteMin = $this->getAbsoluteMinimumQuantity();
        
        if ($absoluteMin !== 1) {
            return $absoluteMin;
        }
        
        $id = $membership ? $membership->getMembershipId() : 0;

        if (!isset($this->minQuantities[$id])) {
            $minQuantity = \XLite\Core\Database::getRepo('XLite\Module\CDev\Wholesale\Model\MinQuantity')
                ->getMinQuantity(
                    $this,
                    $membership
                );

            $this->minQuantities[$id] = isset($minQuantity) ? $minQuantity->getQuantity() : 1;

        }

        return $this->minQuantities[$id];
    }

}