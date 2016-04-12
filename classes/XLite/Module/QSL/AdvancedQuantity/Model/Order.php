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

namespace XLite\Module\QSL\AdvancedQuantity\Model;

/**
 * Order
 */
class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    /**
     * @inheritdoc
     */
    public function countQuantity()
    {
        $quantity = 0;

        foreach ($this->getItems() as $item) {
            $quantity += $item->getSelectedAmount() ?: $item->getAmount();
        }

        return $quantity;
    }

    /**
     * @inheritdoc
     */
    public function normalizeItems()
    {
        // Normalize by key
        $keys = array();
        foreach ($this->getItems() as $item) {
            $key = $item->getKey();
            if (isset($keys[$key])) {
                $keys[$key]->setAmount($keys[$key]->getAmount() + $item->getAmount());
                $keys[$key]->setSelectedAmount($keys[$key]->getSelectedAmount() + $item->getSelectedAmount());
                $this->getItems()->removeElement($item);

                if (\XLite\Core\Database::getEM()->contains($item)) {
                    \XLite\Core\Database::getEM()->remove($item);
                }

            } else {
                $keys[$key] = $item;
            }
        }

        parent::normalizeItems();
    }

    /**
     * @inheritdoc
     */
    public function addItem(\XLite\Model\OrderItem $newItem)
    {
        $duplicate = $this->getItemByItem($newItem);

        $result = parent::addItem($newItem);

        if ($result && $duplicate) {
            $duplicate->setSelectedAmount($duplicate->getSelectedAmount() + $newItem->getSelectedAmount());
        }

        return $result;
    }


} 