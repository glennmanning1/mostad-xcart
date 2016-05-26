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

/**
 * Get count of profiles with non-initialized searchFakeField field
 *
 * @return integer
 */
function upgrade5211_GetEmptySearchFakeFieldCount($em)
{
    return $em
        ->createQuery('SELECT COUNT(p) FROM XLite\Model\Profile p WHERE (p.searchFakeField = :searchFakeField and p.login != :searchFakeField) OR p.searchFakeField is null')
        ->setParameter('searchFakeField', '')
        ->getSingleScalarResult();
}

/**
 * Update searchFakeField field of profiles.
 * Return number of updated profiles
 *
 * @return integer
 */
function upgrade5211_UpdateSearchfakeField($em, $iterationSize)
{
    $updatedCount = 0;
    $iterableResult = $em->createQuery(
        'SELECT p FROM XLite\Model\Profile p WHERE p.searchFakeField is null or (p.searchFakeField = :searchFakeField and p.login != :searchFakeField)'
    )
        ->setParameter('searchFakeField', '')
        ->setMaxResults($iterationSize)
        ->iterate();

    $i = 0;
    $batchSize = 100;
    foreach ($iterableResult as $row) {
        $profile = $row[0];
        $profile->updateSearchFakeField();
        $updatedCount ++;

        if (($i % $batchSize) === 0) {
            $em->flush();
            $em->clear();
        }
        ++$i;
    }

    $em->flush();

    return $updatedCount;
}

return function($status = null)
{
    // Initialize searchFakeField

    $iterationSize = 4;

    $em = \XLite\Core\Database::getEM();

    if (null === $status) {
        $maxPosition = ceil(upgrade5211_GetEmptySearchFakeFieldCount($em) / $iterationSize);
        return array(0, $maxPosition);
    }

    if (is_array($status)) {
        $updatedCount = upgrade5211_UpdateSearchfakeField($em, $iterationSize);
        if (0 == $updatedCount) {
            // There are no updated profiles - break hook operation
            return null;
        }
        $status[0] ++;
        return $status;
    }
};
