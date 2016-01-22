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

namespace XLite\Module\XC\PitneyBowes\View\ItemsList\Model\Shipping;

/**
 * Shipping carriers list
 */
class Carriers extends \XLite\View\ItemsList\Model\Shipping\Carriers implements \XLite\Base\IDecorator
{
    /**
     * Check if method of PitneyBowes processor
     *
     * @param \XLite\Model\AEntity $method
     *
     * @return boolean
     */
    protected function isPitneyBowesProcessor(\XLite\Model\AEntity $method)
    {
        return $method->getProcessor() == \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::PROCESSOR_ID;
    }

    /**
     * Check if the simple class is used for widget displaying
     *
     * @param array                $column
     * @param \XLite\Model\AEntity $entity
     *
     * @return boolean
     */
    protected function isClassColumnVisible(array $column, \XLite\Model\AEntity $entity)
    {
        $result = parent::isClassColumnVisible($column, $entity);

        if (
            $result
            && $this->isPitneyBowesProcessor($entity)
            && 'handlingFee' == $column[static::COLUMN_CODE]
        ) {
            $result = false;
        }

        return $result;
    }
}
