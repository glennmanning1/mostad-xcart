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

namespace XLite\Module\NovaHorizons\WholesaleClasses\Model\Repo;


class WholesaleClassPrice  extends \XLite\Module\CDev\Wholesale\Model\Repo\Base\AWholesalePrice
{

    const P_SET = 'set';

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
    protected function prepareCndSet(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $queryBuilder->andWhere('w.set = :set')
            ->setParameter('set', $value);
    }

    protected function getHandlingSearchParams()
    {
        $list = parent::getHandlingSearchParams();

        $list[] = static::P_SET;

        return $list;
    }

    public function getPriceBySetAndQuantity($set, $quantity)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $cnd = new \Doctrine\ORM\Query\Expr\Orx;

        $cnd->add('c.quantityRangeEnd >= :quantity');
        $cnd->add('c.quantityRangeEnd = 0');

        $queryBuilder->select('c')
            ->where('c.set = :set' )
            ->andWhere('c.quantityRangeBegin <= :quantity')
            ->andWhere($cnd)
            ->setParameters(array(
                'set' => $set,
                'quantity' => $quantity,
            ));

        $result = $queryBuilder->getQuery()->getOneOrNullResult();

        if (!$result) {
            return 0;
        }

        return $quantity * $result->getPrice();
    }

    /**
     * Process contition
     *
     * @param \XLite\Core\CommonCell $cnd    Contition
     * @param mixed                  $object Object
     *
     * @return \XLite\Core\CommonCell
     */
    protected function processContition($cnd, $object)
    {
        $cnd->{self::P_SET} = $object;

        return $cnd;
    }

    public function getWholesaleClassPrices($set)
    {
        $queryBuilder = $this->createQueryBuilder('c');
        
        $queryBuilder->where('c.set = :set' )
            ->setParameters(array(
                'set' => $set,
            ));

        return $queryBuilder->getResult();
    }

}