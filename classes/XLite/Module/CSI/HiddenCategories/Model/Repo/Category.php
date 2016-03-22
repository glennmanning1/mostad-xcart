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
 * @copyright Copyright (c) 2015 CFL Systems, Inc. All rights reserved.
 * @license   CFL Systems Software License Agreement - https://www.cflsystems.com/software-license-agreement.html
 * @link      https://www.cflsystems.com/hidden-categories-for-x-cart-5.html
 */

namespace XLite\Module\CSI\HiddenCategories\Model\Repo;

/**
 * Category repository class
 */
class Category extends \XLite\Model\Repo\Category implements \XLite\Base\IDecorator
{
    /**
     * Allowable search params
     */
    const SEARCH_CSI_HIDDEN_CATEGORY = 'csiHiddenCategory';
    
    /**
     * Initialize the query builder (to prevent the use of language query)
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to use
     * @param string                     $alias        Table alias OPTIONAL
     * @param boolean                    $excludeRoot  Do not include root category into the search result OPTIONAL
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function initializeQueryBuilder($queryBuilder, $alias = null, $excludeRoot = true)
    {
        $this->addHiddenCategoryCondition($queryBuilder, $alias);

        return parent::initializeQueryBuilder($queryBuilder, $alias, $excludeRoot);
    }

    /**
     * Return the category hidden condition
     *
     * @return boolean
     */
    public function getHiddenCategoryCondition()
    {
        return !\XLite::isAdminZone();
    }

    /**
     * Adds additional condition to the query for checking if category is hidden
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder object
     * @param string                     $alias        Entity alias OPTIONAL
     *
     * @return void
     */
    protected function addHiddenCategoryCondition(\Doctrine\ORM\QueryBuilder $queryBuilder, $alias = null)
    {
        if ($this->getHiddenCategoryCondition()) {
            $queryBuilder->andWhere(($alias ?: $this->getDefaultAlias()) . '.csiHiddenCategory = :csiHiddenCategory')
                ->setParameter('csiHiddenCategory', false);
        }
    }

    /**
     * Return list of handling search params
     *
     * @return array
     */
    protected function getHandlingSearchParams()
    {
        $list = parent::getHandlingSearchParams();
        
        $list[] = static::SEARCH_CSI_HIDDEN_CATEGORY;
        
        return $list;
    }
    
    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param mixed                      $value        Condition data
     *
     * @return void
     */
    protected function prepareCndCsiHiddenCategory(\Doctrine\ORM\QueryBuilder $queryBuilder, $value)
    {
        $queryBuilder->andWhere('c.csiHiddenCategory = :csiHiddenCategory')
            ->setParameter('csiHiddenCategory', intval((bool)$value));
    }
}
