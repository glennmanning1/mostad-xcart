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

namespace XLite\Module\Mostad\Coupons\View\Model;

/**
 * Coupon model form extension
 *
 * @LC_Dependencies("CDev\Coupons","XC\FreeShipping")
 */
class Coupon extends \XLite\Module\CDev\Coupons\View\Model\Coupon implements \XLite\Base\IDecorator
{

    /**
     * Coupon constructor.
     *
     * @param array $params
     * @param array $sections
     */
    public function __construct(array $params = array(), array $sections = array())
    {
        $freeShippingField = array();
        $freeShippingField['freeShipping'] = array(
            self::SCHEMA_CLASS => 'XLite\Module\CDev\Coupons\View\FormField\Enabled',
            self::SCHEMA_LABEL => 'Include Free Shipping',
        );

        $this->schemaDefault = array_slice($this->schemaDefault, 0, 5, true)
            + $freeShippingField
            + array_slice($this->schemaDefault, 5, count($this->schemaDefault)-5, true);
        
        $this->schemaDefault['product'] = array(
            self::SCHEMA_CLASS => 'XLite\View\FormField\Select\Model\ProductSelector',
            self::SCHEMA_LABEL => 'Product',
            self::SCHEMA_REQUIRED => false,
            \XLite\View\FormField\Select\Model\AModel::PARAM_IS_MODEL_REQUIRED => false,
        );

        return parent::__construct($params, $sections);
    }

    /**
     * @return array
     */
    protected function getFormFieldsForSectionDefault()
    {
        parent::getFormFieldsForSectionDefault();

        $this->schemaDefault['freeShipping'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'] = array(\XLite\Module\CDev\Coupons\Model\Coupon::TYPE_FREESHIP);

        return $this->getFieldsBySchema($this->schemaDefault);
    }
}