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

namespace XLite\Module\Mostad\ImprintingInformation\Model\Repo;


class Attribute extends \XLite\Model\Repo\Attribute implements \XLite\Base\IDecorator
{
    public function findImprintingAttribute($product)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('translations.name LIKE :name')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->eq('a.product', ':product'),
                $qb->expr()->eq('a.productClass', ':productClass')
            ));

        $qb->setParameters([
            'lng' => 'en',
            'name' => '%imprint%',
            'product' => $product,
            'productClass' => $product->getProductClass(),
        ]);

        $result = $qb->getQuery()->getResult();

        return $result;

    }

}