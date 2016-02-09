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

namespace XLite\Module\XC\PitneyBowes\View\Checkout\SurchargeInfo;

use XLite\Module\XC\PitneyBowes\Model\Shipping\Processor;

/**
 * PitneyBowesTooltip
 * @ListChild (list="checkout.review.surcharge.info", zone="customer", weight="20")
 * @ListChild (list="invoice.base.totals", zone="customer", weight="210")
 * @ListChild (list="invoice.base.totals", zone="admin", weight="210")
 */
class PitneyBowesTooltip extends \XLite\View\SurchargeInfo\ASurchargeInfo
{
    /**
     * Return file name for the center part template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/PitneyBowes/checkout/steps/review/parts/items.modifiers.info.tpl';
    }

   /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/PitneyBowes/checkout/steps/review/parts/info.css';

        return $list;
    }

    /**
     * Check controller visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        $order = $this->getOrderBySurcharge();

        return parent::isVisible()
            && $this->isShippingSurcharge()
            && $order
            && $order->getPbOrder()
            && $order->getShippingProcessor() instanceof Processor\PitneyBowes;
    }

    /**
     * Check if it is right surcharge
     *
     * @return boolean
     */
    protected function isShippingSurcharge()
    {
        return $this->getSurcharge()
            ? $this->getSurcharge()->getType() === \XLite\Model\Order\Surcharge::TYPE_SHIPPING
            : false;
    }

    /**
     * Getting order from surcharge if available
     *
     * @return \XLite\Model\Order
     */
    protected function getOrderBySurcharge()
    {
        $order = null;

        if ($this->getSurcharge()) {
            $order = $this->getSurcharge()->getOrder();
        }

        if (\XLite\Core\Request::getInstance()->order_id
            || \XLite\Core\Request::getInstance()->order_number
        ) {
            $order = $this->getOrder();
        }

        return $order;
    }

    // {{{ Template methods

    /**
     * Splitting shipping cost: transportation part
     *
     * @return string
     */
    protected function getTransportationPart()
    {
        $order = $this->getOrderBySurcharge();
        $value = Processor\PitneyBowes::getTransportationPart(
            $order->getSubtotal(),
            $order->getProfile()->getShippingAddress()->getCountry()->getCode(),
            $order->getPbOrder()->getCreateOrderResponse()->order
        );

        return static::formatPrice($value, $order->getCurrency(), true);
    }

    /**
     * Splitting shipping cost: transportation part
     *
     * @return string
     */
    protected function getImportationPart()
    {
        $order = $this->getOrderBySurcharge();
        $value = Processor\PitneyBowes::getImportationPart(
            $order->getSubtotal(),
            $order->getProfile()->getShippingAddress()->getCountry()->getCode(),
            $order->getPbOrder()->getCreateOrderResponse()->order
        );

        return static::formatPrice($value, $order->getCurrency(), true);
    }

    // }}}
}
