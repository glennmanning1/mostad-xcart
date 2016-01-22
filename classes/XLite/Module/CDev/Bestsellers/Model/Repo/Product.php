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

namespace XLite\Module\CDev\Bestsellers\Model\Repo;

/**
 * The "OrderItem" model repository
 */
class Product extends \XLite\Model\Repo\Product implements \XLite\Base\IDecorator
{
    /**
     * Defines bestsellers products collection
     *
     * @param \XLite\Core\CommonCell $cnd   Search condition
     * @param integer                $count Number of products to get OPTIONAL
     * @param integer                $cat   Category identificator OPTIONAL
     *
     * @return array
     */
    public function findBestsellers(\XLite\Core\CommonCell $cnd, $count = 0, $cat = 0)
    {
        return $this->defineBestsellersQuery($cnd, $count, $cat)->getOnlyEntities();
    }

    /**
     * Prepares query builder object to get bestsell products
     *
     * @param \XLite\Core\CommonCell $cnd   Search condition
     * @param integer                $count Number of products to get
     * @param integer                $cat   Category identificator
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder object
     */
    protected function defineBestsellersQuery(\XLite\Core\CommonCell $cnd, $count, $cat)
    {
        list($sort, $order) = $cnd->{self::P_ORDER_BY};

        $qb = $this->createQueryBuilder()
            ->andWhere('p.sales > 0')
            ->addGroupBy('p.product_id')
            ->addOrderBy('p.sales', 'desc')
            ->addOrderBy($sort, $order);

        if (0 < $count) {
            $qb->setMaxResults($count);
        }

        if (0 < $cat) {
            $qb->linkLeft('p.categoryProducts', 'cp')->linkLeft('cp.category', 'c');
            \XLite\Core\Database::getRepo('XLite\Model\Category')->addSubTreeCondition($qb, $cat);
        }

        return \XLite\Core\Database::getRepo('XLite\Model\Product')->assignExternalEnabledCondition($qb, 'p');
    }

    /**
     * Find sales by product
     *
     * @param \XLite\Model\Product $product Product
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder object
     */
    public function findSalesByProduct(\XLite\Model\Product $product)
    {
        $qb = $this->createPureQueryBuilder()
            ->linkInner('p.order_items', 'o')
            ->linkInner('o.order', 'ord')
            ->linkInner('ord.paymentStatus', 'ps')
            ->select('sum(o.amount) as product_amount')
            ->andWhere('o.object = :product')
            ->setParameter('product', $product);

        return (int) $qb->andWhere($qb->expr()->in('ps.code', \XLite\Model\Order\Status\Payment::getPaidStatuses()))
            ->getSingleScalarResult();
    }

    /**
     * Count items for quick data
     *
     * @return integer
     */
    public function countForSales()
    {
        return (int) $this->defineCountForSalesQuery()->getSingleScalarResult();
    }

    /**
     * Define query builder for COUNT query
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineCountForSalesQuery()
    {
        $qb = $this->createPureQueryBuilder();

        return $qb->select(
            'COUNT(DISTINCT ' . $qb->getMainAlias() . '.' . $this->getPrimaryKeyField() . ')'
        );
    }

    /**
     * Define items iterator
     *
     * @param integer $position Position OPTIONAL
     *
     * @return \Doctrine\ORM\Internal\Hydration\IterableResult
     */
    public function getSalesIterator($position = 0)
    {
        return $this->defineSalesIteratorQueryBuilder($position)
            ->iterate();
    }

    /**
     * Define quick data iterator query builder
     *
     * @param integer $position Position
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineSalesIteratorQueryBuilder($position)
    {
        return $this->createPureQueryBuilder()
            ->setFirstResult($position)
            ->setMaxResults(1000000000);
    }
}