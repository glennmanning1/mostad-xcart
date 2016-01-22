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
 * @Entity (repositoryClass="\XLite\XC\PitneyBowes\Model\Repo\PBParcel")
 * @Table  (name="pb_parcel")
 * @HasLifecycleCallbacks
 */
class PBParcel extends \XLite\Model\AEntity
{
    /**
     * https://wiki.ecommerce.pb.com/display/TECH4/Data+Types+-+InboundParcelRequest
     * parcelIdentificationNumber - maxLength = 50
     */
    const PARCEL_NUMBER_LENGTH = 22;

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
     * number
     *
     * @var string
     *
     * @GeneratedValue (strategy="AUTO")
     * @Column         (type="string")
     */
    protected $number;

    /**
     * Order items in parcel
     *
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @OneToMany(targetEntity="XLite\Module\XC\PitneyBowes\Model\ParcelItem", mappedBy="pbParcel", cascade={"all"})
     **/
    protected $parcelItems;

    /**
     * Pitney Bowes order association
     *
     * @var \XLite\Module\XC\PitneyBowes\Model\PBOrder
     * 
     * @ManyToOne(targetEntity="XLite\Module\XC\PitneyBowes\Model\PBOrder", inversedBy="parcels")
     * @JoinColumn(name="order_id", referencedColumnName="id")
     **/
    protected $order;

    /**
     * Flag: ASN sent
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $createAsnCalled = false;

    /**
     * Constructor
     *
     * @param array $data Entity properties OPTIONAL
     *
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->parcelItems = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct($data);
    }

    /**
     * Lifecycle callback
     * 
     * @param \Doctrine\ORM\Event\PreUpdateEventArgs $event Event argument
     * 
     * @return void
     *
     * @PreUpdate
     */
    public function prepareBeforeSave(\Doctrine\ORM\Event\PreUpdateEventArgs $event)
    {
        if (!$event->hasChangedField('createAsnCalled')) {
            $this->setCreateAsnCalled(false);
        }
    }

    /**
     * Count available for parcel order items
     * 
     * @param \XLite\Model\OrderItem $orderItem Order item
     * 
     * @return integer
     */
    public function getAmountInParcel($orderItem)
    {
        $result = 0;

        foreach ($this->getParcelItems() as $item) {
            if ($item->getOrderItem() && $item->getOrderItem()->getItemId() == $orderItem->getItemId()) {
                $result += $item->getAmount();
            }
        }

        return $result;
    }

    /**
     * Generate unique parcel number and set it to current parcel
     * 
     * @return void
     */
    public function autoGenerateNumber()
    {
        $number = \XLite\Core\Operator::getInstance()->generateToken(static::PARCEL_NUMBER_LENGTH, static::$chars);

        $this->setNumber($number);
    }

    /**
     * @param \Doctrine\Common\Collections\Collection  $items Order items to use
     * 
     * @return boolean
     */
    public function fillParcelItemsByOrderItems(\Doctrine\Common\Collections\Collection $items)
    {
        if (!$this->getOrder()) {
            return false;
        }

        foreach ($items as $orderItem) {
            if ($this->getOrder()->getAvailableAmount($orderItem) < 1) {
                continue;
            }
            $parcelItem = new \XLite\Module\XC\PitneyBowes\Model\ParcelItem();
            $parcelItem->setOrderItem($orderItem);
            $parcelItem->setAmount(0);
            $parcelItem->setPbParcel($this);

            $this->addParcelItems($parcelItem);
        }

        return true;
    }

    /**
     * Check if parcel has no parcel items
     * 
     * @return boolean
     */
    public function isEmpty()
    {
        $amount = array_reduce($this->getParcelItems()->toArray(), function($carry, $parcelItem){
            return $carry + $parcelItem->getAmount();
        });

        return $amount < 1;

    }
}
