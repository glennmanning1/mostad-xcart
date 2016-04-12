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

namespace XLite\Module\QSL\AdvancedQuantity\View;

/**
 * Minimum quantity for product
 *
 * @LC_Dependencies ("CDev\Wholesale")
 */
class MinQuantity extends \XLite\Module\CDev\Wholesale\View\MinQuantity implements \XLite\Base\IDecorator
{
    /**
     * Minimum quantity list
     *
     * @var mixed[]
     */
    protected $minQuantityList;

    /**
     * Return minimum quantity by units
     *
     * @return mixed[]
     */
    protected function getMinimumOrderQuantityList()
    {
        if (!isset($this->minQuantityList)) {
            $product = $this->getParam(self::PARAM_PRODUCT);
            $min = $this->getMinimumOrderQuantity();
            $this->minQuantityList = array();
            foreach ($product->getQuantityUnits() as $unit) {
                $this->minQuantityList[$unit->getId()] = array(
                    'qty'  => $product->formatQuantity($min / $unit->getMultiplier()),
                    'unit' => $unit->getName(),
                );

                $min_set = null;
                foreach ($product->getQuantitySets() as $set) {
                    if (!$set->getQuantityUnit() || $set->getQuantityUnit()->getId() == $unit->getId()) {
                        $min_set = isset($min_set) ? min($min_set, $set->getQuantity()) : $set->getQuantity();
                    }
                }

                if (isset($min_set) && $min_set > $this->minQuantityList[$unit->getId()]['qty']) {
                    $this->minQuantityList[$unit->getId()]['qty'] = $min_set;
                }
            }

            if (!$this->minQuantityList) {
                $this->minQuantityList[] = array(
                    'qty'  => $min,
                    'unit' => static::t('units'),
                );
            }
        }

        return $this->minQuantityList;
    }

    /**
     * Check - need display 'or' label or not
     *
     * @param array   $qty   Quantity cell
     * @param integer $index Quantity cell index
     * @param integer $count Quantity ceells list count
     *
     * @return boolean
     */
    protected function isOrVisible(array $qty, $index, $count)
    {
        return $index < $count;
    }

}
