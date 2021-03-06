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

namespace XLite\Model\Repo;

/**
 * Event tasks repository
 */
class EventTask extends \XLite\Model\Repo\ARepo
{
    /**
     * Query limit
     */
    const QUERY_LIMIT = 10;

    /**
     * Find query 
     *
     * @param integer $limit Tasks limit OPTIONAL
     * 
     * @return array
     */
    public function findQuery($limit = self::QUERY_LIMIT)
    {
        return $this->defineFindQuery($limit)->getResult();
    }

    /**
     * Clean event tasks
     *
     * @param string    $eventName  Event name
     * @param int       $exceptId   Task id
     *
     * @return void
     */
    public function cleanTasks($eventName, $exceptId)
    {
        $this->getQueryBuilder()
            ->delete($this->_entityName, 'e')
            ->andWhere('e.name = :eventName')
            ->andWhere('e.id != :exceptId')
            ->setParameter('eventName', $eventName)
            ->setParameter('exceptId', $exceptId)
            ->execute();
    }

    /**
     * Define query for findQuery() method
     *
     * @param integer $limit Tasks limit
     * 
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineFindQuery($limit)
    {
        return $this->createQueryBuilder('e')
            ->setMaxResults($limit)
            ->orderBy('e.id', 'asc');
    }
}
