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
        $newFields = array();
        $newFields['freeShipping'] = array(
            self::SCHEMA_CLASS => 'XLite\Module\CDev\Coupons\View\FormField\Enabled',
            self::SCHEMA_LABEL => 'Include Free Shipping',
        );

        $newFields['deferredBilling'] = array(
            self::SCHEMA_CLASS => 'XLite\Module\CDev\Coupons\View\FormField\Enabled',
            self::SCHEMA_LABEL => 'Include Deferred Billing',
        );

        $this->schemaDefault = array_slice($this->schemaDefault, 0, 5, true)
            + $newFields
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

        $freeShippingTypes = array(\XLite\Module\CDev\Coupons\Model\Coupon::TYPE_FREESHIP);
        $valueTypes = array(\XLite\Module\CDev\Coupons\Model\Coupon::TYPE_DEFERRED);
        $deferredTypes = array(\XLite\Module\Mostad\Coupons\Model\Coupon::TYPE_DEFERRED);

        if (!isset($this->schemaDefault['freeShipping'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE])) {
            $this->schemaDefault['freeShipping'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE] = array();
        }

        if (isset($this->schemaDefault['freeShipping'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'])) {
            $freeShippingTypes = array_merge($this->schemaDefault['freeShipping'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'], $freeShippingTypes);
        }
        $this->schemaDefault['freeShipping'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'] = $freeShippingTypes;

        if (!isset($this->schemaDefault['deferredBilling'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE])) {
            $this->schemaDefault['deferredBilling'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE] = array();
        }

        if (isset($this->schemaDefault['deferredBilling'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'])) {
            $deferredTypes = array_merge($this->schemaDefault['deferredBilling'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'], $deferredTypes);
        }
        $this->schemaDefault['deferredBilling'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'] = $deferredTypes;


        if (!isset($this->schemaDefault['value'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE])) {
            $this->schemaDefault['value'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE] = array();
        }

        if (isset($this->schemaDefault['value'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'])) {
            $valueTypes = array_merge($this->schemaDefault['value'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'],$valueTypes);
        }

        $this->schemaDefault['value'][self::SCHEMA_DEPENDENCY][self::DEPENDENCY_HIDE]['type'] = $valueTypes;

        return $this->getFieldsBySchema($this->schemaDefault);
    }
}