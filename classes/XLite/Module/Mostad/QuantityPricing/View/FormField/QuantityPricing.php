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

namespace XLite\Module\Mostad\QuantityPricing\View\FormField;


class QuantityPricing extends \XLite\View\FormField\Inline\Label
{

    protected function getDefaultTemplate()
    {
        return 'modules/Mostad/QuantityPricing/form_field/quantity_pricing.tpl';
    }

    protected function getLink()
    {
        return $this->getEntity()->getDefaultPrice()
            ? $this->buildURL('product', null, array('product_id' => $this->getEntity()->getProduct()->getId(), 'page' => 'quantity_pricing'))
            : $this->buildURL('product_variant', null, array('id' => $this->getEntity()->getId(), 'page' => 'quantity_pricing'));
    }

}