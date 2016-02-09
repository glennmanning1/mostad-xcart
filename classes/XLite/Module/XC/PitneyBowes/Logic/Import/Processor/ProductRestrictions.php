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

namespace XLite\Module\XC\PitneyBowes\Logic\Import\Processor;

/**
 * Reviews import processor
 */
class ProductRestrictions extends \XLite\Logic\Import\Processor\AProcessor
{
    /**
     * Get title
     *
     * @return string
     */
    public static function getTitle()
    {
        return static::t('Product restrictions imported');
    }

    /**
     * Return empty array to prevent displaying of the product restrictions keys in the 'Import mode' tooltip
     *
     * @return array
     */
    public function getAvailableEntityKeys()
    {
        return array();
    }

    /**
     * Return true if import run in update-only mode
     *
     * @return boolean
     */
    protected function isUpdateMode()
    {
        return false;
    }

    /**
     * Check - specified file is imported by this processor or not
     *
     * @param \SplFileInfo $file File
     *
     * @return boolean
     */
    protected function isImportedFile(\SplFileInfo $file)
    {
        return false !== strpos($file->getFilename(), 'commodity-eligibility');
    }

    /**
     * Check - row processing is allowed or not
     *
     * @return boolean
     */
    protected function isRowProcessingAllowed()
    {
        return parent::isRowProcessingAllowed()
            && (
                $this->isVerification()
                || !$this->isRowVerificationFailed()
            );
    }

    /**
     * Check - row verification step is failed or not
     *
     * @return boolean
     */
    public function isRowVerificationFailed()
    {
        //TODO: Cache import logs after full verification
        return !$this->isVerification()
            && \XLite\Core\Database::getRepo('XLite\Model\ImportLog')->findOneBy(array('row' => $this->key() + 1));
    }

    /**
     * Get repository
     *
     * @return \XLite\Model\Repo\ARepo
     */
    protected function getRepository()
    {
        return \XLite\Core\Database::getRepo('XLite\Module\XC\PitneyBowes\Model\ProductRestriction');
    }

    // {{{ Columns

    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'MERCHANT_COMMODITY_REF_ID' => array(
                static::COLUMN_IS_KEY => true,
                static::COLUMN_LENGTH => 32,
                static::COLUMN_PROPERTY => 'product',
            ),
            'COUNTRY_CODE'              => array(
                static::COLUMN_IS_KEY   => true,
                static::COLUMN_PROPERTY => 'country',
            ),
            'RESTRICTION_CODE'          => array(
                static::COLUMN_PROPERTY => 'restriction_code',
            ),
        );
    }

    // }}}

    // {{{ Verification

    /**
     * Get messages
     *
     * @return array
     */
    public static function getMessages()
    {
        return parent::getMessages() +
            array(
                'RESTRICTION-MERCHANT_COMMODITY_REF_ID-FMT'     => 'Unknown product is stated',
                'RESTRICTION-COUNTRY_CODE-FMT'                  => 'Unknown country code',
                'RESTRICTION-RESTRICTION_CODE-FMT'              => 'Empty restriciton code',
            );
    }

    /**
     * Verify 'MERCHANT_COMMODITY_REF_ID' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyMERCHANT_COMMODITY_REF_ID($value, array $column)
    {
        if ($this->verifyValueAsEmpty($value) || !$this->verifyValueAsProduct($value)) {
            $this->addWarning('RESTRICTION-MERCHANT_COMMODITY_REF_ID-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * Verify 'COUNTRY_CODE' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyCOUNTRY_CODE($value, array $column)
    {
        if ($this->verifyValueAsEmpty($value) || !$this->verifyValueAsCountry3Code($value)) {
            $this->addWarning('RESTRICTION-COUNTRY_CODE-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * Verify 'review' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyRESTRICTION_CODE($value, array $column)
    {
        if ($this->verifyValueAsEmpty($value)) {
            $this->addWarning('RESTRICTION-RESTRICTION_CODE-FMT', array('column' => $column, 'value' => $value));
        }
    }

    /**
     * Verify value as country code
     *
     * @param mixed @value Value
     *
     * @return boolean
     */
    protected function verifyValueAsCountry3Code($value)
    {
        return preg_match('/^[a-z]{3}$/Si', $value)
            && 0 < \XLite\Core\Database::getRepo('XLite\Model\Country')->countBy(array('code3' => $value));
    }

    // }}}

    // {{{ Normalizators

    /**
     * Normalize 'MERCHANT_COMMODITY_REF_ID' value
     *
     * @param mixed @value Value
     *
     * @return \XLite\Model\Product
     */
    protected function normalizeMERCHANT_COMMODITY_REF_IDValue($value)
    {
        return $this->normalizeValueAsProduct($value);
    }

    /**
     * Normalize 'additionDate' value
     *
     * @param mixed @value Value
     *
     * @return integer
     */
    protected function normalizeCOUNTRY_CODEValue($value)
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Country')->findOneBy(array('code3' => $value)) ?: $value;
    }

    // }}}
}
