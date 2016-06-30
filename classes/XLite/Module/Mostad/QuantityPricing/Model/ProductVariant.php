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

namespace XLite\Module\Mostad\QuantityPricing\Model;


class ProductVariant extends \XLite\Module\XC\ProductVariants\Model\ProductVariant implements \XLite\Base\IDecorator
{

    protected $quantityPrices;


    public function getQuantityPrices()
    {
        if (!$this->quantityPrices) {
            $cnd = new \XLite\Core\CommonCell();
            $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_ID}   = $this->getId();
            $cnd->{\XLite\Module\Mostad\QuantityPricing\Model\Repo\QuantityPrice::P_MODEL_TYPE} = 'XLite\Module\XC\ProductVariants\Model\ProductVariant';

            $this->quantityPrices = \XLite\Core\Database::getRepo('XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice')
                ->search($cnd, false);
        }

        return $this->quantityPrices;
    }

}