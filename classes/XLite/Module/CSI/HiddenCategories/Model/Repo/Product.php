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

namespace XLite\Module\CSI\HiddenCategories\Model\Repo;

/**
 * The "product" model repository
 */
class Product extends \XLite\Model\Repo\Product implements \XLite\Base\IDecorator
{
    /**
     * Allowable search params
     */
    const P_CSI_HIDDEN_CATEGORY = 'csiHiddenCategory';

    /**
     * Return list of handling search params
     *
     * @return array
     */
    protected function getHandlingSearchParams()
    {
        $list = parent::getHandlingSearchParams();
        
        $list[] = self::P_CSI_HIDDEN_CATEGORY;
        
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
        // find all hidden categories
        $cond = array('csiHiddenCategory' => intval((bool)$value));
        $hiddenCategoriesObj = \XLite\Core\Database::getRepo('XLite\Model\Category')->findBy($cond);
        
        // if none found do nothing
        if (!$hiddenCategoriesObj) {
            return;
        }
        
        $hiddenCategoriesIds = $subCategoriesIds = array();
        
        // find all subcategories of hidden categories
        foreach ($hiddenCategoriesObj as $k => $v) {
            $catid = $v->getCategoryId();
            
            $hiddenCategoriesIds[] = $catid;
                
            $subCategories = \XLite\Core\Database::getRepo('XLite\Model\Category')->getCategoriesPlainList($catid);
            
            if ($subCategories) {
                foreach ($subCategories as $subK => $subV) {
                    $subCategoriesIds[] = $subV['category_id'];
                }
            }
        }
        
        $hiddenCategoriesIds = array_merge($hiddenCategoriesIds, $subCategoriesIds);
        $hiddenCategoriesIds = array_unique($hiddenCategoriesIds);
        
        $queryBuilder->linkInner('p.categoryProducts', 'cp')
            ->linkInner('cp.category', 'c');

        // exclude all hidden categories and their subcategories
        $queryBuilder->andWhere('c.category_id NOT IN (' . implode(',', $hiddenCategoriesIds) . ')');
    }
}
