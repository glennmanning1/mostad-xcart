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
 * Update products sales information.
 * Return number of updated products
 *
 * @param integer $pos Current iterator position
 *
 * @return integer
 */
function upgrade5211_UpdateSales($pos, $chunkSize)
{
    $i = $result = 0;
    $repo = \XLite\Core\Database::getRepo('XLite\Model\Product');

    $iterator = $repo->getExportIterator($pos);
    $iterator->rewind();

    while ($iterator->valid()) {
        $entity = $iterator->current();
        $entity = $entity[0];

        $entity->updateSales();

        $pos++;

        if ($chunkSize <= ++$i) {
            $result = $pos;
            break;
        }

        $iterator->next();
    }

    return $result;
}

return function($status = null)
{
    // Update product sales information

    $chunkSize = 40;

    if (null === $status) {
        $maxResults = (int) \XLite\Core\Database::getEM()->createQuery('SELECT COUNT(p.product_id) FROM XLite\Model\Product p')
            ->getSingleScalarResult();
        return array(0, $maxResults);
    }

    if (is_array($status)) {
        $newPosition = upgrade5211_UpdateSales($status[0], $chunkSize);
        if (!$newPosition || $status[0] == $newPosition) {
            return null;
        }
        $status[0] = $newPosition;
        return $status;
    }
};
