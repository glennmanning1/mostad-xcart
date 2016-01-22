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

namespace XLite\Module\CDev\VolumeDiscounts\Model\Repo;

/**
 * VolumeDiscount repository
 */
class VolumeDiscount extends \XLite\Model\Repo\ARepo
{
    /**
     * Allowable search params
     */
    const P_MEMBERSHIP = 'membership';
    const P_SUBTOTAL = 'subtotal';
    const P_SUBTOTAL_ADV = 'subtotalAdv';
    const P_MIN_VALUE = 'minValue';
    const P_ORDER_BY_SUBTOTAL = 'orderBySubtotal';
    const P_ORDER_BY_MEMBERSHIP = 'orderByMembership';
    const P_LIMIT = 'limit';

    /**
     * Find one similar discount
     *
     * @param \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount $model Discount
     *
     * @return \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount
     */
    public function findOneSimilarDiscount(\XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount $model)
    {
        return $this->defineFindOneSimilarDiscountQuery($model)->getSingleResult();
    }

    /**
     * Define query for 'findOneSimilarDiscount' method
     *
     * @param \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount $model Discount
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineFindOneSimilarDiscountQuery(\XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount $model)
    {
        $qb = $this->createQueryBuilder()
            ->andWhere('v.subtotalRangeBegin = :rangeBegin')
            ->setParameter('rangeBegin', $model->getSubtotalRangeBegin())
            ->setMaxResults(1);

        if ($model->getMembership()) {
            $qb->andWhere('v.membership = :membership')
                ->setParameter('membership', $model->getMembership());

        } else {
            $qb->andWhere('v.membership IS NULL');
        }

        return $qb;
    }

    // {{{ Search discounts methods

    /**
     * Search for discounts
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only count OPTIONAL
     *
     * @return array|integer
     */
    public function search(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $queryBuilder = $this->createQueryBuilder('v');
        $this->currentSearchCnd = $cnd;

        $membershipRelation = false;

        foreach ($this->currentSearchCnd as $key => $value) {
            $this->callSearchConditionHandler($value, $key, $queryBuilder, $countOnly);
            if (in_array($key, array(self::P_MEMBERSHIP, self::P_ORDER_BY_MEMBERSHIP), true)) {
                $membershipRelation = true;
            }
        }

        if ($membershipRelation) {
            $queryBuilder->leftJoin('v.membership', 'membership');
        }

        return $countOnly
            ? $this->searchCount($queryBuilder)
            : $this->searchResult($queryBuilder);
    }

    /**
     * Search count only routine.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb Query builder routine
     *
     * @return integer
     */
    protected function searchCount(\Doctrine\ORM\QueryBuilder $qb)
    {
        $qb->select('COUNT(v.id)');

        return (int) $qb->getSingleScalarResult();
    }

    /**
     * Search result routine.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb Query builder routine
     *
     * @return array
     */
    protected function searchResult(\Doctrine\ORM\QueryBuilder $qb)
    {
        return $qb->getResult();
    }


    /**
     * Return list of handling search params
     *
     * @return array
     */
    protected function getHandlingSearchParams()
    {
        return array(
            self::P_MEMBERSHIP,
            self::P_SUBTOTAL,
            self::P_SUBTOTAL_ADV,
            self::P_MIN_VALUE,
            self::P_ORDER_BY_SUBTOTAL,
            self::P_ORDER_BY_MEMBERSHIP,
            self::P_LIMIT,
        );
    }

    /**
     * Check if param can be used for search
     *
     * @param string $param Name of param to check
     *
     * @return boolean
     */
    protected function isSearchParamHasHandler($param)
    {
        return in_array($param, $this->getHandlingSearchParams(), true);
    }

    /**
     * Call corresponded method to handle a search condition
     *
     * @param mixed                      $value        Condition data
     * @param string                     $key          Condition name
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param boolean                    $countOnly    Return items list or only count OPTIONAL
     *
     * @return void
     */
    protected function callSearchConditionHandler($value, $key, \Doctrine\ORM\QueryBuilder $queryBuilder, $countOnly)
    {
        if ($this->isSearchParamHasHandler($key)) {
            $this->{'prepareCnd' . ucfirst($key)}($queryBuilder, $value, $countOnly);
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    protected function prepareCndMembership(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        if (null !== $value) {
            $cnd = new \Doctrine\ORM\Query\Expr\Orx();
            $cnd->add('membership.membership_id = :membershipId');
            $cnd->add('v.membership IS NULL');

            $queryBuilder->andWhere($cnd)
                ->setParameter('membershipId', $value);

        } else {
            $queryBuilder->andWhere('v.membership IS NULL');
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    protected function prepareCndSubtotal(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $cnd = new \Doctrine\ORM\Query\Expr\Orx();
        $cnd->add('v.subtotalRangeEnd > :subtotal');
        $cnd->add('v.subtotalRangeEnd = 0');

        $queryBuilder->andWhere('v.subtotalRangeBegin <= :subtotal')
            ->andWhere($cnd)
            ->setParameter('subtotal', $value);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndSubtotalAdv(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $queryBuilder->andWhere('v.subtotalRangeBegin > :subtotal')
            ->setParameter('subtotal', $value);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndMinValue(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        $queryBuilder->andWhere('v.value > :value')
            ->setParameter('value', $value);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndOrderBy(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value, $countOnly)
    {
        if (!$countOnly) {
            list($sort, $order) = $value;

            $queryBuilder->addOrderBy($sort, $order);
        }
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndOrderBySubtotal(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value, $countOnly)
    {
        $this->prepareCndOrderBy($queryBuilder, $value, $countOnly);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     * @param boolean                    $countOnly    "Count only" flag. Do not need to add "order by" clauses if only count is needed.
     *
     * @return void
     */
    protected function prepareCndOrderByMembership(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value, $countOnly)
    {
        $this->prepareCndOrderBy($queryBuilder, $value, $countOnly);
    }

    /**
     * Prepare certain search condition
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder to prepare
     * @param array                      $value        Condition data
     *
     * @return void
     */
    protected function prepareCndLimit(\Doctrine\ORM\QueryBuilder $queryBuilder, array $value)
    {
        $queryBuilder->setFrameResults($value);
    }

    // }}}

    // {{{ Correct subtotalRangeEnd values

    /**
     * Re-calculate subtotalRangeEnd value for each discount
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return void
     */
    public function correctSubtotalRangeEnd()
    {
        $cnd = new \XLite\Core\CommonCell();
        $cnd->{self::P_ORDER_BY_SUBTOTAL} = array('v.subtotalRangeBegin', 'ASC');

        // Get all discounts
        $discounts = $this->search($cnd);

        $groups = $this->groupDiscounts($discounts);

        foreach ($groups as $discounts) {
            $this->correctSubtotalRange($discounts);
        }

        \XLite\Core\Database::getEM()->flush();
    }

    /**
     * Group discounts
     *
     * @param \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount[] $discounts
     *
     * @return array
     */
    protected function groupDiscounts($discounts)
    {
        $result = array();

        foreach ($discounts as $discount) {
            $membershipId = $discount->getMembership() ? $discount->getMembership()->getMembershipId() : 0;
            $result[$membershipId][] = $discount;
        }

        return array_values($result);
    }

    /**
     * Correct subtotal range
     *
     * @param \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount[] $discounts
     *
     * @return void
     */
    protected function correctSubtotalRange($discounts)
    {
        $rangeEnd = array();
        foreach ($discounts as $k => $discount) {
            $rangeEnd[$k] = $this->findDiscountNextRangeBegin($discount->getSubtotalRangeBegin(), $discounts);
        }

        foreach ($discounts as $k => $discount) {
            $discount->setSubtotalRangeEnd($rangeEnd[$k]);
        }
    }

    /**
     * Find range begin of next discount in sequence
     *
     * @param float                                                     $rangeBegin Range begin
     * @param \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount[] $discounts  Discounts
     *
     * @return float
     */
    protected function findDiscountNextRangeBegin($rangeBegin, $discounts)
    {
        $absMaxSubtotal = pow(10, 16);
        $result = $absMaxSubtotal;

        foreach ($discounts as $discount) {
            $discountRangeBegin = $discount->getSubtotalRangeBegin();
            if ($discountRangeBegin > $rangeBegin && $discountRangeBegin < $result) {
                $result = $discountRangeBegin;
            }
        }

        return $result !== $absMaxSubtotal ? $result : 0;
    }

    // }}}

    // {{{ Find suitable discount methods

    /**
     * Get first discount suitable for specified subtotal
     * @deprecated
     *
     * @param float                   $subtotal   Subtotal
     * @param \XLite\Model\Membership $membership Membership object
     *
     * @return \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount
     */
    public function getFirstDiscountBySubtotal($subtotal, $membership)
    {
        $cnd = new \XLite\Core\CommonCell();
        $cnd->{self::P_SUBTOTAL} = $subtotal;
        $cnd->{self::P_MEMBERSHIP} = $membership ? $membership->getMembershipId() : null;
        if ($membership) {
            $cnd->{self::P_ORDER_BY_MEMBERSHIP} = array('membership.membership_id', 'DESC');
        }
        $cnd->{self::P_ORDER_BY_SUBTOTAL} = array('v.subtotalRangeBegin', 'ASC');

        $discounts = $this->search($cnd);

        return $discounts
            ? array_shift($discounts)
            : null;
    }

    /**
     * Get first discount suitable for specified subtotal
     *
     * @param \XLite\Core\CommonCell $cnd Condition
     *
     * @return \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount
     */
    public function getFirstDiscount($cnd)
    {
        $discounts = $this->search($this->getFirstDiscountCondition($cnd));

        return $discounts
            ? array_shift($discounts)
            : null;
    }

    /**
     * getFirsDiscountCondition
     *
     * @param \XLite\Core\CommonCell $cnd Condition
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getFirstDiscountCondition($cnd)
    {
        $result = new \XLite\Core\CommonCell();

        $result->{self::P_SUBTOTAL} = $cnd->{self::P_SUBTOTAL} ?: 0;
        $cnd->{self::P_ORDER_BY_SUBTOTAL} = array('v.subtotalRangeBegin', 'ASC');

        $membership = $cnd->{self::P_MEMBERSHIP};
        $result->{self::P_MEMBERSHIP} = $membership ? $membership->getMembershipId() : null;
        if ($membership) {
            $result->{self::P_ORDER_BY_MEMBERSHIP} = array('membership.membership_id', 'DESC');
        }

        return $result;
    }

    // }}}

    // {{{ Find next suitable discount method

    /**
     * Get next discount suitable for specified subtotal
     *
     * @param \XLite\Core\CommonCell $cnd Condition
     *
     * @return \XLite\Module\CDev\VolumeDiscounts\Model\VolumeDiscount
     */
    public function getNextDiscount($cnd)
    {
        $discounts = $this->search($this->getNextDiscountCondition($cnd));

        return $discounts
            ? array_shift($discounts)
            : null;
    }

    /**
     * getFirsDiscountCondition
     *
     * @param \XLite\Core\CommonCell $cnd Condition
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getNextDiscountCondition($cnd)
    {
        $result = new \XLite\Core\CommonCell();
        $cnd->{self::P_MIN_VALUE} = 0;

        $result->{self::P_SUBTOTAL_ADV} = $cnd->{self::P_SUBTOTAL_ADV} ?: 0;
        $cnd->{self::P_ORDER_BY_SUBTOTAL} = array('v.subtotalRangeBegin', 'ASC');

        $membership = $cnd->{self::P_MEMBERSHIP};
        $result->{self::P_MEMBERSHIP} = $membership ? $membership->getMembershipId() : null;
        if ($membership) {
            $result->{self::P_ORDER_BY_MEMBERSHIP} = array('membership.membership_id', 'DESC');
        }

        return $result;
    }

    // }}}
}
