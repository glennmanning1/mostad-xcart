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

namespace XLite\Module\NovaHorizons\CategoryWholesale\Model\Repo;


class CategoryWholesalePrice extends \XLite\Module\CDev\Wholesale\Model\Repo\Base\AWholesalePrice
{

    const P_CATEGORY = 'category';

        /**
     * Search for prices
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only count OPTIONAL
     *
     * @return \Doctrine\ORM\PersistentCollection|integer
     */
    public function search(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $queryBuilder = $this->createQueryBuilder('w');
        $this->currentSearchCnd = $cnd;

        $membershipRelation = false;

        foreach ($this->currentSearchCnd as $key => $value) {
            $this->callSearchConditionHandler($value, $key, $queryBuilder, $countOnly);

            if (in_array($key, array(static::P_MEMBERSHIP, static::P_ORDER_BY_MEMBERSHIP))) {
                $membershipRelation = true;
            }
        }

        if ($membershipRelation) {
            $queryBuilder->leftJoin('w.membership', 'membership');
        }

        $cnd = new \Doctrine\ORM\Query\Expr\Orx();
        $cnd->add('w.quantityRangeBegin >= 1');
        $cnd->add('w.membership IS NOT NULL');
        $queryBuilder->andWhere($cnd);

        return $countOnly
            ? $this->searchCount($queryBuilder)
            : $this->searchResult($queryBuilder);
    }

        /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param mixed                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndCategory(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        if ($value instanceOf \XLite\Model\Category) {
            $queryBuilder->andWhere('w.category = :category')
                ->setParameter('category', $value);

        } else {
            $queryBuilder->leftJoin('w.category', 'category')
                ->andWhere('category.category_id = :categoryId')
                ->setParameter('categoryId', $value);
        }
    }

    protected function getHandlingSearchParams()
    {
        $list = parent::getHandlingSearchParams();

        $list[] = static::P_CATEGORY;

        return $list;
    }

    public function getWholesaleCategories()
    {
        $queryBuilder = $this->createQueryBuilder();

        $queryBuilder
            ->select("IDENTITY({$this->defaultAlias}.category)")
            ->where("{$this->defaultAlias}.category IS NOT NULL")
            ->distinct();

        $result = $queryBuilder->getQuery()->getScalarResult();

        $result = array_map('current', $result);

        return $result;
    }
}