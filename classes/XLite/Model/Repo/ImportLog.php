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
 * Import log repository
 */
class ImportLog extends \XLite\Model\Repo\ARepo
{
    /**
     * Return files list
     *
     * @return array 
     */
    public function findFiles()
    {
        return $this->createQueryBuilder('il')
            ->select('il.file')
            ->addSelect('SUM(IF(il.type = \'W\', 1, 0)) countW')
            ->addSelect('SUM(IF(il.type = \'E\', 1, 0)) countE')
            ->groupBy('il.file')
            ->getResult();
    }

    /**
     * Return errors list
     *
     * @param string $file File
     *
     * @return array 
     */
    public function findErrorsByFile($file)
    {
        return $this->createQueryBuilder('il')
            ->andWhere('il.file = :file')
            ->setParameter('file', $file)
            ->orderBy('il.type')
            ->addOrderBy('il.file')
            ->addOrderBy('il.row')
            ->getArrayResult();
    }

    /**
     *  Query for searching by value in arguments
     * 
     * @param string $type Log entry type
     * @param string $code Log entry code
     * @param string $value Log entry arguments.value
     * 
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function prepareQueryBuilderForFindByValue($type, $code, $value){
        return $this->createQueryBuilder('il')
            ->andWhere('il.type = :type')
            ->andWhere('il.code = :code')            
            ->andWhere('il.arguments LIKE :arguments')
            ->setParameter('arguments', '%"' . $value . '"%' )
            ->setParameter('type', $type)
            ->setParameter('code', $code);
    }
    
    /**
     *  Find log entries by value in arguments
     * 
     * @param string $type Log entry type
     * @param string $code Log entry code
     * @param string $value Log entry arguments.value
     * 
     * @return array
     */
    public function findByValue($type, $code, $value){
        $qb = $this->prepareQueryBuilderForFindByValue($type, $code, $value);
        return $qb->getResult();
    }

    /**
     * Count log entries by value in arguments
     * @param string $type Log entry type
     * @param string $code Log entry code
     * @param string $value Log entry arguments.value
     * 
     * @return integer
     */
    public function countByValue($type, $code, $value){
        $qb = $this->prepareQueryBuilderForFindByValue($type, $code, $value);        
        $qb->select('COUNT(il)');

        return intval($qb->getSingleScalarResult());
    }

    /**
     * Delete log records by type
     *
     * @param string $type Log entry type (e.g. W or E)
     *
     * @return void
     */
    public function deleteByType($type)
    {
        $this->prepareDeleteByTypeQueryBuilder($type)->execute();
    }

    /**
     * Prepare query builder for deleteByType() method
     *
     * @param string $type Log entry type
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function prepareDeleteByTypeQueryBuilder($type)
    {
        return $this->getQueryBuilder()
            ->delete($this->_entityName, 'il')
            ->andWhere('il.type = :type')
            ->setParameter('type', $type);
    }
}
