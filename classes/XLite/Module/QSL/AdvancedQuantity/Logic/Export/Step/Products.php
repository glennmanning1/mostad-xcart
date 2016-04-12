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

namespace XLite\Module\QSL\AdvancedQuantity\Logic\Export\Step;

/**
 * Products
 */
class Products extends \XLite\Logic\Export\Step\Products implements \XLite\Base\IDecorator
{

    /**
     * @inheritdoc
     */
    protected function defineColumns()
    {
        $columns = parent::defineColumns();
        $columns['fractionLength'] = array();
        $columns['quantitySets'] = array();
        $columns['quantityUnits'] = array();

        return $columns;
    }

    /**
     * Get column value for 'fractionLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getFractionLengthColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'fraction_length');
    }

    /**
     * Get column value for 'quantitySets' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getQuantitySetsColumnValue(array $dataset, $name, $i)
    {
        $result = array();
        foreach ($dataset['model']->getQuantitySets() as $set) {
            $result[] = $set->getQuantity()
                . ($set->getQuantityUnit() ? '/' . $set->getQuantityUnit()->getName() : '');
        }

        return $result;
    }

    /**
     * Get column value for 'quantityUnits' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getQuantityUnitsColumnValue(array $dataset, $name, $i)
    {
        $result = array();
        foreach ($dataset['model']->getQuantityUnits() as $model) {
            $result[] = $model->getName() . '=' . $model->getMultiplier();
        }

        return $result;
    }

}