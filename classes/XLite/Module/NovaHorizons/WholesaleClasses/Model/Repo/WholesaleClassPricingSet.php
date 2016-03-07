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

/**
 * Class WholesaleClassPricingSet
 * @package XLite\Module\NovaHorizons\WholesaleClasses\Model\Repo
 */
class WholesaleClassPricingSet extends \XLite\Model\Repo\ARepo
{
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
        $queryBuilder           = $this->createQueryBuilder('r');
        $this->currentSearchCnd = $cnd;

        foreach ($this->currentSearchCnd as $key => $value) {
            $this->callSearchConditionHandler($value, $key, $queryBuilder, $countOnly);
        }

        return $countOnly
            ? $this->searchCount($queryBuilder)
            : $this->searchResult($queryBuilder);
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     *
     * @return int
     */
    public function searchCount(\Doctrine\ORM\QueryBuilder $queryBuilder)
    {
        $queryBuilder->select('COUNT(DISTINCT r.' . $this->getIdField() . ')');

        return intval($queryBuilder->getSingleScalarResult());
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     *
     * @return mixed
     */
    public function searchResult(\Doctrine\ORM\QueryBuilder $queryBuilder)
    {
        return $queryBuilder->getResult();
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
        return [];
    }
}