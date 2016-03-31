<?php
// vim: set ts=2 sw=2 sts=2 et:

/**
 * Hidden Categories Module
 *
 * NOTICE OF LICENSE
 *
 * The software license agreement for this module can be found at
 * the following URL: https://www.cflsystems.com/software-license-agreement.html
 *
 * This file and its source code are property of CFL Systems, Inc. and are
 * protected by United States copyright law. The source code contained in this file
 * may not be reproduced, copied, modified or redistributed in any form without
 * written authorization by an officer of CFL Systems, Inc.
 *
 * @category  X-Cart 5 Module
 * @author    CFL Systems, Inc. <support@cflsystems.com>
 * @copyright Copyright (c) 2015-2016 CFL Systems, Inc. All rights reserved.
 * @license   CFL Systems Software License Agreement - https://www.cflsystems.com/software-license-agreement.html
 * @link      https://www.cflsystems.com/hidden-categories-for-x-cart-5.html
 */

namespace XLite\Module\CSI\HiddenCategories\Logic\Import\Processor;

/**
 * Categories import processor
 */
class Categories extends \XLite\Logic\Import\Processor\Categories implements \XLite\Base\IDecorator
{
    /**
     * Get messages
     *
     * @return array
     */
    public static function getMessages()
    {
        return parent::getMessages()
            + array(
                'CATEGORY-CSI-HIDDEN-CATEGORY' => 'Hidden category field value must be boolean',
            );
    }

    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();

        $columns['csiHiddenCategory'] = array();

        return $columns;
    }

    /**
     * Normalize 'csiHiddenCategory' value
     *
     * @param mixed $value Value
     *
     * @return boolean
     */
    protected function normalizeCsiHiddenCategory($value)
    {
        return $this->normalizeValueAsBoolean($value);
    }

    /**
     * Verify 'csiHiddenCategory' value
     *
     * @param mixed $value  Value
     * @param array $column Column info
     *
     * @return void
     */
    protected function verifyCsiHiddenCategory($value, array $column)
    {
        if (!$this->verifyValueAsEmpty($value) && !$this->verifyValueAsBoolean($value)) {
            $this->addWarning('CATEGORY-CSI-HIDDEN-CATEGORY', array('column' => $column, 'value' => $value));
        }
    }
}
