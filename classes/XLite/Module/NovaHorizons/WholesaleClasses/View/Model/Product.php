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

namespace XLite\Module\NovaHorizons\WholesaleClasses\View\Model;


class Product extends \XLite\View\Model\Product implements \XLite\Base\IDecorator
{
    public function __construct(array $params = [], array $sections = [])
    {
        parent::__construct($params, $sections);


        if (
            $this->getProduct()
            && $this->getProduct()->getProductClass()
            && $this->getProduct()->getProductClass()->isWholesalePriceClass()
        ) {
            if (!isset($this->schemaDefault['price'][ self::SCHEMA_ATTRIBUTES ])) {
                $this->schemaDefault['price'][ self::SCHEMA_ATTRIBUTES ] = [];
            }
            $this->schemaDefault['price'][ self::SCHEMA_ATTRIBUTES ]['class']    = 'hidden';
            $this->schemaDefault['price'][ self::SCHEMA_ATTRIBUTES ]['disabled'] = 'disabled';
        }


    }

    protected function prepareFieldParamsPrice($data)
    {
        if (\XLite\Core\Request::getInstance()->target == 'product') {
            if (
                $this->getProduct()
                && $this->getProduct()->getProductClass()
                && $this->getProduct()->getProductClass()->isWholesalePriceClass()
            ) {

                $wholesalePricingSet = $this->getProduct()->getProductClass()->getWholesalePricingSet();

                $data[ self::SCHEMA_LINK_HREF ] = $this->buildURL('wholesale_class_price', null, [
                    'pricing_set_id' => $wholesalePricingSet->getId(),
                ]);
                $data[ self::SCHEMA_LINK_TEXT ] = 'Wholesale class pricing';

                $data[ \XLite\Module\NovaHorizons\WholesaleClasses\View\FormField\Input\Text\Price::PARAM_SHOW_SYMBOL] = false;
            }
        }

        return $data;
    }

}