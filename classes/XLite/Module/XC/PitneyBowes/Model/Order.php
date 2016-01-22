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

namespace XLite\Module\XC\PitneyBowes\Model;

use \XLite\Module\XC\PitneyBowes\Model\Shipping;

/**
 * Class represents an order
 */
class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    /**
     * Pitney Bowes order association
     *
     * @var \XLite\Module\XC\PitneyBowes\Model\PBOrder
     * 
     * @OneToOne(targetEntity="XLite\Module\XC\PitneyBowes\Model\PBOrder", mappedBy="order", cascade={"persist"})
     * @JoinColumn(name="pb_order_id", referencedColumnName="id")
     **/
    protected $pbOrder;

    /**
     * Check if PitneyBowes is selected as shipping method
     */
    public function isPitneyBowesSelected()
    {
        return $this->getShippingProcessor() instanceof Shipping\Processor\PitneyBowes;
    }

    /**
     * @return void
     */
    public function updatePBOrder($ordersReturnedFromPB)
    {
        if ($ordersReturnedFromPB) {
            foreach ($ordersReturnedFromPB as $order) {
                $pbOrder = $this->getPbOrder();
                if ($pbOrder) {
                    $pbOrder->setOrmus($order->orderId);
                    $pbOrder->setTransactionId($order->order->transactionId);
                    $pbOrder->setCreateOrderResponse($order);

                } else {
                    $pbOrder = new \XLite\Module\XC\PitneyBowes\Model\PBOrder();
                    $pbOrder->setOrmus($order->orderId);
                    $pbOrder->setTransactionId($order->order->transactionId);
                    $pbOrder->setOrder($this);
                    $pbOrder->setCreateOrderResponse($order);

                    $this->setPbOrder($pbOrder);
                }
                \XLite\Core\Database::getEM()->persist($this);
            }
        }
    }

    /**
     * @return void
     */
    protected function confirmOrderApiCall()
    {
        $api = new Shipping\PitneyBowesApiFacade(
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration()
        );

        $confirmOrderResult = $api->confirmOrder($this->getPbOrder());
        if ($confirmOrderResult) {
            $this->confirmOrderHistoryEvent($this->getPbOrder(), $confirmOrderResult);
        }

        $this->setShippingStatus(\XLite\Model\Order\Status\Shipping::STATUS_PROCESSING);
    }

    /**
     * Called when an order successfully placed by a client
     *
     * @return void
     */
    public function processSucceed()
    {
        parent::processSucceed();

        if ($this->isPitneyBowesSelected()
            && $this->getPbOrder()
        ) {
            $this->createOrderHistoryEvent($this->getPbOrder());
            $this->confirmOrderApiCall();
        }
    }

    /**
     * @param \XLite\Module\XC\PitneyBowes\Model\PBOrder    $pbOrder            Pitney Bowes order model
     * 
     * @return void
     */
    protected function createOrderHistoryEvent(\XLite\Module\XC\PitneyBowes\Model\PBOrder $pbOrder)
    {
        $createOrderResult = $pbOrder->getCreateOrderResponse();

        \XLite\Core\OrderHistory::getInstance()->registerEvent(
            $this->getOrderId(),
            'PB_SHIPPING',
            'PitneyBowes shipping order created',
            array(),
            '',
            array(
                array(
                    'name'  => 'Grand total',
                    'value' => $createOrderResult->order->total->value,
                ),
                array(
                    'name'  => 'Order ID',
                    'value' => $pbOrder->getOrmus()
                ),
                array(
                    'name'  => 'Total transportation',
                    'value' => $createOrderResult->order->totalTransportation->total->value,
                ),
                array(
                    'name'  => 'Total importation',
                    'value' => $createOrderResult->order->totalImportation->total->value,
                ),
                array(
                    'name'  => 'Expire date',
                    'value' => $createOrderResult->expireDate,
                ),
                array(
                    'name'  => 'Hub address',
                    'value' => $this->postprocessHubAddress($createOrderResult->shipToHub),
                ),
                array(
                    'name'  => 'Delivery time',
                    'value' => $this->postprocessDeliveryTime($createOrderResult->order),
                ),
            )
        );
    }

    /**
     * Postprocess hub address
     * 
     * @param mixed $shipToHub createOrder API response part
     * 
     * @return string
     */
    protected function postprocessHubAddress($shipToHub)
    {
        $addressParts = (array) $shipToHub->hubAddress;
        $addressString = implode(' ', $addressParts);

        return $shipToHub->hubId . ' : ' . $addressString;
    }

    /**
     * Postprocess delivery time
     * 
     * @param mixed $order createOrder API response part
     * 
     * @return string
     */
    protected function postprocessDeliveryTime($order)
    {
        $min = $order->totalTransportation->minDays ?: '&infin;';
        $max = $order->totalTransportation->maxDays ?: '&infin;';

        return static::t(
            '{{X}} - {{Y}} days',
            array(
                'X' => $min,
                'Y' => $max,
            )
        );
    }


    /**
     * @param \XLite\Module\XC\PitneyBowes\Model\PBOrder    $pbOrder            Pitney Bowes order model
     * @param mixed $confirmOrderResult ConfirmOrder api call result
     * 
     * @return void
     */
    protected function confirmOrderHistoryEvent(\XLite\Module\XC\PitneyBowes\Model\PBOrder $pbOrder, $confirmOrderResult)
    {
        \XLite\Core\OrderHistory::getInstance()->registerEvent(
            $this->getOrderId(),
            'PB_SHIPPING',
            'PitneyBowes shipping order confirmed',
            array(),
            '',
            array(
                array(
                    'name'  => 'Transaction ID',
                    'value' => $confirmOrderResult->transactionId,
                ),
                array(
                    'name'  => 'Order ID',
                    'value' => $confirmOrderResult->orderId,
                ),
                array(
                    'name'  => 'Result',
                    'value' => $confirmOrderResult->result,
                ),
            )
        );
    }

    /**
     * Check order restricted
     *
     * @return boolean
     */
    public function containsRestrictedProducts()
    {
        $result = false;

        foreach ($this->getItems() as $item) {
            if ($item->getProduct()->isRestrictedProduct()) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
