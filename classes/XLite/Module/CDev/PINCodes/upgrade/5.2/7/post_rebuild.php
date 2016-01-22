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

function getProductsQuery($i, $batchSize)
{
    $repo = \XLite\Core\Database::getRepo('XLite\Model\Product');

    $andCnd = new \Doctrine\ORM\Query\Expr\Andx();
    $andCnd->add('p.pinCodesEnabled = :true');
    $andCnd->add('p.autoPinCodes = :false');

    return $repo->createQueryBuilder()
        ->innerJoinInventory()
        ->andWhere($andCnd)
        ->setParameter('true', true)
        ->setParameter('false', false)
        ->setFirstResult($i * $batchSize)
        ->setMaxResults($batchSize)
        ->getQuery();
}

return function()
{
    $batchSize = 100;
    $i = 1;
    $products = getProductsQuery(0, $batchSize)->getResult();
    do {
        foreach ($products as $product) {
            $product->syncAmount();
            $product->getInventory()->setEnabled(true);
        }
        \XLite\Core\Database::getEM()->flush();
        \XLite\Core\Database::getEM()->clear();
        $products = getProductsQuery($i, $batchSize)->getResult();
        $i++;
    } while ($products);

    \XLite\Core\Database::getEM()->flush();
};
