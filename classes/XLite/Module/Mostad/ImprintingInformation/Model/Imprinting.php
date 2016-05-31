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

namespace XLite\Module\Mostad\ImprintingInformation\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * Class Imprinting
 * @package XLite\Module\Mostad\ImprintingInformation\Model
 *
 * @Entity()
 * @Table(name="imprinting")
 */
class Imprinting extends \XLite\Model\AEntity
{
    const STATUS_NEW = 'NEW';
    const STATUS_SAME = 'SAME';
    const STATUS_UPDATE = 'UPDATE';
    /**
     * @var int
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * Item order
     *
     * @var \XLite\Model\Order
     *
     * @OneToOne  (targetEntity="XLite\Model\Order", inversedBy="imprinting")
     * @JoinColumn (name="order_id", referencedColumnName="order_id", onDelete="CASCADE")
     */
    protected $order;

    /**
     * @var string
     * @Column(type="string", length=10)
     */
    protected $status = self::STATUS_NEW;

    /**
     * @var string
     * @Column(name="firm_name", type="string", length=255, nullable=true)
     */
    protected $firmName;

//    /**
//     * @var \XLite\Model\Address
//     *
//     * @ManyToOne(targetEntity="\XLite\Model\Address")
//     * @JoinColumn(name="address_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
//     */
//    protected $address;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $website;

    /**
     * @var boolean
     * @Column(name="add_logo", type="boolean")
     */
    protected $addLogo = false;

    /**
     * @var string
     * @Column(name="online_firm_name", type="string", length=255, nullable=true)
     */
    protected $onlineFirmName;

    /**
     * @var string
     * @Column(name="online_email", type="string", length=255, nullable=true)
     */
    protected $onlineEmail;

    /**
     * @var string
     * @Column(name="online_website", type="string", length=255, nullable=true)
     */
    protected $onlineWebsite;

    /**
     * @var boolean
     * @Column(name="online_add_to_site", type="boolean")
     */
    protected $onlineAddToSite = false;

    /**
     * @var boolean
     * @Column(type="boolean")
     */
    protected $confirm = false;


    public static function getStatusArray()
    {
        return array(
                self::STATUS_NEW => 'I am ordering imprinting for the first time. I have indicated my imprint information in the fields below.',
                self::STATUS_UPDATE => 'My imprint information has changed. My imprint changes are indicated in the fields below.',
                self::STATUS_SAME => 'My imprint has NOT changed. Use my imprint information that you have on file.',
        );
    }

}