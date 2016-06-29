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

namespace XLite\Module\Mostad\QuantityPricing\Controller\Admin;


class WholesaleClassPrice extends \XLite\Module\NovaHorizons\WholesaleClasses\Controller\Admin\WholesaleClassPrice implements \XLite\Base\IDecorator
{
    
    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();
        
        $list['quantity_pricing'] = 'Quantity pricing';

        return $list;
    }
    
    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();

        $list['quantity_pricing'] = 'modules/Mostad/QuantityPricing/tabs/wholesale_class_quantity_pricing.tpl';

        return $list;
    }
    
    /**
     * Handle the update to product quantity pricing
     */
    protected function doActionQuantityPricingUpdate()
    {
        $list = new \XLite\Module\Mostad\QuantityPricing\View\ItemsList\Model\QuantityPrice();
        $list->processQuick();
    }
    
    /**
     * Helper for quantity pricing
     *
     * @return \XLite\Model\Product
     */
    public function getObject()
    {
        return $this->getPriceSet();
    }
    

}