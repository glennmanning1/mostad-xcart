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

namespace XLite\Module\Mostad\BlogUpdates\Model\Repo;


class BlogPost extends \XLite\Model\Repo\ARepo
{
    /**
     * @return array
     */
    public function getCurrentPosts()
    {
        $oldestDate = new \DateTime();
        $oldestDate->modify('-3 days');

        $qb = $this->createQueryBuilder('p')
            ->select()
            ->where('p.cached > :oldest')
            ->setParameter('oldest', $oldestDate)
            ->setMaxResults(2);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getNewestPosts()
    {
        $qb = $this->createQueryBuilder('p')
            ->select()
            ->orderBy('p.cached')
            ->setMaxResults(2);

        return $qb->getQuery()->getResult();
    }

}