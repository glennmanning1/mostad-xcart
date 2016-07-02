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

namespace XLite\Module\Mostad\QuantityPricing\View\Model;


class Product extends \XLite\View\Model\Product implements \XLite\Base\IDecorator
{
    public function __construct(array $params = [], array $sections = [])
    {
        parent::__construct($params, $sections);

        $product = $this->getProduct();

        if ($product->getQuantityPriceEnabled()) {
            unset($this->schemaDefault['price']);
        }


        $taxClassIndex = (array_search('taxClass', array_keys($this->schemaDefault))) + 1;

        $this->schemaDefault = array_slice($this->schemaDefault, 0, $taxClassIndex, true) +
                               [
                                   'quantityPriceEnabled' => [
                                       self::SCHEMA_CLASS => 'XLite\View\FormField\Input\Checkbox\OnOff',
                                       self::SCHEMA_LABEL => 'Quantity pricing enabled',
                                   ],
                               ]
                               + array_slice($this->schemaDefault, $taxClassIndex, count($this->schemaDefault) - $taxClassIndex, true);

    }

    protected function prepareFieldParamsQuantityPriceEnabled($data)
    {
        if (\XLite\Core\Request::getInstance()->target == 'product') {
            if ($this->getProduct()->getQuantityPriceEnabled()) {

                $data[ self::SCHEMA_LINK_HREF ] = $this->buildURL('product', null, [
                    'product_id' => $this->getProduct()
                        ->getId(),
                    'page'       => 'quantity_pricing'
                ]);
                $data[ self::SCHEMA_LINK_TEXT ] = 'Quantity pricing';
            }
        }

        return $data;
    }
}