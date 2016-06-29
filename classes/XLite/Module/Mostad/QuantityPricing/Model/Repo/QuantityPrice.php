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

namespace XLite\Module\Mostad\QuantityPricing\Model\Repo;


/**
 * Class QuantityPrice
 * @package XLite\Module\Mostad\QuantityPricing\Model\Repo
 */
class QuantityPrice extends \XLite\Model\Repo\ARepo
{
    /**
     * Condition Parameters
     */
    const P_MODEL_ID   = 'modelId';
    const P_MODEL_TYPE = 'modelType';

    /**
     * @return string
     */
    protected function getIdField()
    {
        return 'id';
    }

    /**
     * @param \XLite\Core\CommonCell $cnd
     * @param bool $countOnly
     *
     * @return int
     */
    public function search(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        $queryBuilder = $this->createQueryBuilder('q');
        $this->currentSearchCnd = $cnd;

        foreach ($this->currentSearchCnd as $key => $value) {
            $this->callSearchConditionHandler($value, $key, $queryBuilder, $countOnly);
        }

        $queryBuilder->orderBy('q.quantity');

        return $countOnly
            ? $this->searchCount($queryBuilder)
            : $this->searchResult($queryBuilder);
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     *
     * @return int
     */
    public function searchCount(\Doctrine\ORM\QueryBuilder $qb)
    {
        $qb->select('COUNT(DISTINCT q.' . $this->getIdField() .  ')');
        return intval($qb->getSingleScalarResult());
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     *
     * @return mixed
     */
    public function searchResult(\Doctrine\ORM\QueryBuilder $qb)
    {
        return $qb->getResult();
    }

    /**
     * @param $value
     * @param $key
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param $countOnly
     */
    protected function callSearchConditionHandler($value, $key, \Doctrine\ORM\QueryBuilder $queryBuilder, $countOnly)
    {
        if ($this->isSearchParamHasHandler($key)) {
            $this->{'prepareCnd' . ucfirst($key)}($queryBuilder, $value, $countOnly);
        }
    }

    /**
     * @param $param
     *
     * @return bool
     */
    protected function isSearchParamHasHandler($param)
    {
        return in_array($param, $this->getHandlingSearchParams());
    }

    /**
     * @return array
     */
    protected function getHandlingSearchParams()
    {
       return array(
           static::P_MODEL_TYPE,
           static::P_MODEL_ID,
       );
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param $value
     * @param $countOnly
     */
    protected function prepareCndModelId(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        if (!empty($value)) {
            $queryBuilder->andWhere('q.modelId = :modelId')
                ->setParameter('modelId', $value);
        }
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param $value
     * @param $countOnly
     */
    protected function prepareCndModelType(\Doctrine\ORM\QueryBuilder $queryBuilder, $value, $countOnly)
    {
        if (!empty($value)) {
            $queryBuilder->andWhere('q.modelType = :modelType')
                ->setParameter('modelType', $value);
        }
    }
}