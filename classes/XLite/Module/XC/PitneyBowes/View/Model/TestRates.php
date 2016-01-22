<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\XC\PitneyBowes\View\Model;

/**
 * Test shipping rates widget
 */
class TestRates extends \XLite\View\Model\TestRates
{
    const SCHEMA_FIELD_COMMODITY = 'commodity';

    public function __construct()
    {
        $schema = array_reverse($this->schemaTestRates, true);
        $schema[self::SCHEMA_FIELD_COMMODITY] = array(
            self::SCHEMA_CLASS          => 'XLite\View\FormField\Select\Model\ProductSelector',
            self::SCHEMA_LABEL          => 'Commodity',
            self::SCHEMA_PLACEHOLDER    => static::t('Start typing product name or SKU'),
        );
        $this->schemaTestRates = array_reverse($schema, true);
    }
    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\Module\XC\PitneyBowes\View\Form\TestRates';
    }

    /**
     * Returns the list of related targets
     *
     * @return array
     */
    protected function getAvailableSchemaFields()
    {
        return array(
            static::SCHEMA_FIELD_COMMODITY,
            static::SCHEMA_FIELD_DST_COUNTRY,
            static::SCHEMA_FIELD_DST_STATE,
            static::SCHEMA_FIELD_DST_CITY,
            static::SCHEMA_FIELD_DST_ZIPCODE,
        );
    }

    /**
     * Alter default model object values
     *
     * @return array
     */
    protected function getDefaultModelObjectValues()
    {
        $data = parent::getDefaultModelObjectValues();
        $data[static::SCHEMA_FIELD_DST_COUNTRY] = 'CA';
        $data[static::SCHEMA_FIELD_DST_STATE] = '60';
        $data[static::SCHEMA_FIELD_DST_CITY] = '';

        return $data;
    }


}
