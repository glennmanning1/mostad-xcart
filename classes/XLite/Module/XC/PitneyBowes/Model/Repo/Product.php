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

namespace XLite\Module\XC\PitneyBowes\Model\Repo;

/**
 * The "OrderItem" model repository
 */
class Product extends \XLite\Model\Repo\Product implements \XLite\Base\IDecorator
{
    /**
     * Differential export mode
     *
     * @var boolean
     */
    protected $isDifferential = false;

    /**
     * Define query builder for COUNT query
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineCountForExportQuery()
    {
        $qb = parent::defineCountForExportQuery();
        if ($this->isDifferential()) {
            $qb->andWhere('p.exported_pb = 0');
        }
        return $qb;
    }

    /**
     * Define export iterator query builder
     *
     * @param integer $position Position
     *
     * @return \XLite\Model\QueryBuilder\AQueryBuilder
     */
    protected function defineExportIteratorQueryBuilder($position)
    {
        $qb = parent::defineExportIteratorQueryBuilder($position);
        if ($this->isDifferential()) {
            $qb->andWhere('p.exported_pb = 0');
        }
        return $qb;
    }

    /**
     * Define export iterator query builder
     *
     * @param boolean $flag True if repo should work as differential
     *
     * @return void
     */
    public function isDifferential()
    {
        return $this->isDifferential;
    }

    /**
     * Define export iterator query builder
     *
     * @param boolean $flag True if repo should work as differential
     *
     * @return void
     */
    public function setDifferential($flag = false)
    {
        $this->isDifferential = $flag;
    }
}
