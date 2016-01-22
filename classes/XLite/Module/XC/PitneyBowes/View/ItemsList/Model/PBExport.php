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

namespace XLite\Module\XC\PitneyBowes\View\ItemsList\Model;

/**
 * OrderItem items list
 */
class PBExport extends \XLite\View\ItemsList\Model\Table
{

    /**
     * Hide panel
     *
     * @return null
     */
    protected function getPanelClass()
    {
        return null;
    }

    /**
     * Items are non-removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return false;
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return null;
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'type'      => array(
                static::COLUMN_ORDERBY       => 100,
                static::COLUMN_NAME          => static::t('Type'),
                static::COLUMN_NO_WRAP       => true,
                static::COLUMN_MAIN          => true,
            ),
            'differential'      => array(
                static::COLUMN_ORDERBY       => 100,
                static::COLUMN_NAME          => static::t('Exported'),
                static::COLUMN_NO_WRAP       => true,
            ),
            'date'      => array(
                static::COLUMN_ORDERBY       => 200,
                static::COLUMN_NAME          => static::t('Date'),
                static::COLUMN_NO_WRAP       => true,
            ),
            'status'    => array(
                static::COLUMN_ORDERBY       => 300,
                static::COLUMN_NAME          => static::t('Status'),
                static::COLUMN_NO_WRAP       => true,
            ),
        );
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' pb-export-items-list';
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\XC\PitneyBowes\Model\PBExport';
    }

    // {{{ Columns value getters

    /**
     * Get value of the "sku" column
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBExport $item Export item model
     *
     * @return string
     */
    protected function getTypeColumnValue(\XLite\Module\XC\PitneyBowes\Model\PBExport $item)
    {
        $parts = explode('_', $item->getFilename());
        return static::t(ucfirst($parts[1])) ?: static::t('Unknown');
    }

    /**
     * Get value of the "differential" column
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBExport $item Export item model
     *
     * @return string
     */
    protected function getDifferentialColumnValue(\XLite\Module\XC\PitneyBowes\Model\PBExport $item)
    {
        return $item->getDifferential() ? static::t('Updates to catalog') : static::t('Full catalog');
    }

    /**
     * Get value of the "name" column
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBExport $item Export item model
     *
     * @return string
     */
    protected function getDateColumnValue(\XLite\Module\XC\PitneyBowes\Model\PBExport $item)
    {
        return \XLite\Core\Converter::formatTime($item->getExportDate());
    }

    /**
     * Get value of the "name" column
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBExport $item Export item model
     *
     * @return string
     */
    protected function getStatusColumnValue(\XLite\Module\XC\PitneyBowes\Model\PBExport $item)
    {
        $result = static::t('Unknown');
        switch ($item->getStatus()) {
            case \XLite\Module\XC\PitneyBowes\Model\PBExport::STATUS_PENDING:
                $result = static::t('Pending');
                break;
            case \XLite\Module\XC\PitneyBowes\Model\PBExport::STATUS_APPROVED:
                $result = static::t('Approved');
                break;
            case \XLite\Module\XC\PitneyBowes\Model\PBExport::STATUS_FAILED:
                $result = static::t('Failed');
                break;
        }
        return $result;
    }

    // }}}
}