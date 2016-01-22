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
 * Product restriction items list
 */
class ProductRestriction extends \XLite\View\ItemsList\Model\Table
{

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'country'      => array(
                static::COLUMN_ORDERBY       => 100,
                static::COLUMN_NAME          => static::t('Restricted country'),
                static::COLUMN_NO_WRAP       => true,
                static::COLUMN_MAIN          => true,
            ),
            'restriction'      => array(
                static::COLUMN_ORDERBY       => 200,
                static::COLUMN_NAME          => static::t('Reason'),
            ),
        );
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\XC\PitneyBowes\Model\ProductRestriction';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' pb-restriction';
    }

    /**
     * Get country
     *
     * @param \XLite\Model\AEntity $entity Restriction item
     *
     * @return string
     */
    protected function getCountryColumnValue(\XLite\Model\AEntity $entity)
    {
        return $entity->getCountry()->getCountry();
    }

    /**
     * Get order
     *
     * @param \XLite\Model\AEntity $entity Restriction item
     *
     * @return string
     */
    protected function getRestrictionColumnValue(\XLite\Model\AEntity $entity)
    {
        return $entity->getRestrictionCode();
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        $result->{\XLite\Module\XC\PitneyBowes\Model\Repo\ProductRestriction::SEARCH_PRODUCT} = $this->getProductId();

        return $result;
    }

    /**
     * Prepare field params for 
     *
     * @param array                $column
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function preprocessFieldParams(array $column, \XLite\Model\AEntity $entity)
    {
        $list = parent::preprocessFieldParams($column, $entity);

        return $list;
    }
}