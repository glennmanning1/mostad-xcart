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

/**
 * Pitney Bowes order model
 *
 * @Entity
 * @Table  (name="pb_order")
 */
class PBOrder extends \XLite\Model\AEntity
{
    /**
     * TRANSACTION_ID_LENGTH - maxLength = 10
     */
    const TRANSACTION_ID_LENGTH = 10;

    /**
     * Number characters list
     *
     * @var array
     */
    protected static $chars = array(
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
    );

    /**
     * ID
     *
     * @var integer
     *
     * @Id
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="integer", options={ "unsigned": true })
     */
    protected $id;

    /**
     * Order ID returned by PB
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $ormus;

    /**
     * Transaction ID
     *
     * @var string
     *
     * @Column (type="string")
     */
    protected $transactionId;

    /**
     * Order association
     *
     * @var \XLite\Model\Order
     * 
     * @OneToOne(targetEntity="XLite\Model\Order", inversedBy="pbOrder")
     * @JoinColumn(name="order_id", referencedColumnName="order_id", onDelete="SET NULL")
     **/
    protected $order;

    /**
     * Parcels association
     *
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @OneToMany(targetEntity="XLite\Module\XC\PitneyBowes\Model\PBParcel", mappedBy="order", cascade={"persist"})
     **/
    protected $parcels;

    /**
     * 
     * @var mixed
     * 
     * @Column (type="object")
     */
    protected $createOrderResponse;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     *
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->parcels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->transactionId = static::generateTransactionId();

        parent::__construct($data);
    }

    /**
     * Generate unique parcel number and set it to current parcel
     * 
     * @return string
     */
    public static function generateTransactionId()
    {
        return \XLite\Core\Operator::getInstance()->generateToken(static::TRANSACTION_ID_LENGTH, static::$chars);
    }

    /**
     * Count order item in all parcels
     * 
     * @param \XLite\Model\OrderItem $orderItem Order item
     * 
     * @return integer
     */
    public function getAmountInAllParcels(\XLite\Model\OrderItem $orderItem)
    {
        $parcels = $this->getParcels();

        return array_reduce($parcels->toArray(), function($carry, $parcel) use ($orderItem) {
            return $carry + $parcel->getAmountInParcel($orderItem);
        });
    }

    /**
     * Count available for parcel order items
     * 
     * @param \XLite\Model\OrderItem                        $orderItem  Order item
     * @param \XLite\Module\XC\PitneyBowes\Model\PBParcel   $parcel     Current parcel  OPTIONAL
     * 
     * @return integer
     */
    public function getAvailableAmount(\XLite\Model\OrderItem $orderItem, $parcel = null)
    {
        $getAmountInParcels = $this->getAmountInAllParcels($orderItem);

        if (null !== $parcel) {
            $getAmountInParcels -= $parcel->getAmountInParcel($orderItem);
        }

        return $orderItem->getAmount() - $getAmountInParcels;
    }

    /**
     * Check if there is any unassigned order items
     * 
     * @return boolnean
     */
    public function isNewParcelAllowed()
    {
        $orderItems = $this->getOrder()->getItems();

        $that53omg = $this;

        $haveOrderItems = array_reduce($orderItems->toArray(), function($carry, $orderItem) use ($that53omg) {
            return $carry ?: 0 < $that53omg->getAvailableAmount($orderItem);
        });

        $haveEmptyParcels = array_reduce($this->getParcels()->toArray(), function($carry, $parcel){
            return $carry ?: $parcel->isEmpty();
        });

        return $haveOrderItems && !$haveEmptyParcels;
    }
}
