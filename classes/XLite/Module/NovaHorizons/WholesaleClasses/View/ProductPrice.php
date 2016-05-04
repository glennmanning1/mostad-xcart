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

namespace XLite\Module\NovaHorizons\WholesaleClasses\View;


class ProductPrice extends \XLite\View\Product\Details\Customer\Widget
{
    protected $wholesalePrices = null;

    /**
     * Return the specific widget service name to make it visible as specific CSS class
     *
     * @return null|string
     */
    public function getFingerprint()
    {
        return 'widget-fingerprint-product-wholesale-class-prices';
    }
    
    protected function getDefaultTemplate()
    {
        return 'modules/NovaHorizons/WholesaleClasses/product_price/body.tpl';
    }

    protected function defineWholesalePrices()
    {
        return \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet')
            ->getWholesalePrices($this->getProduct());
    }

    protected function getWholesaleClassPrices()
    {
        if (!$this->wholesalePrices) {
            $this->wholesalePrices = $this->defineWholesalePrices();
        }

        return $this->wholesalePrices;
    }


}